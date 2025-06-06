<?php

namespace App\Http\Controllers;

use App\Exports\ProductosExport;
use App\Models\DetalleCompra;
use App\Models\DetalleVenta;
use App\Models\ImagenProducto;
use App\Models\Producto;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use Flash;
use Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function almacen(Request $request)
    {
        if ($request->ajax()) {
            $query = Producto::with('subCategoria');
    
            // Filtrar por subcategoría si se proporciona
            if ($request->has('subCategoria') && !empty($request->subCategoria)) {
                $query->where('sub_categoria_id', $request->subCategoria);
            }
    
            return DataTables::of($query->get())
            ->addColumn('fecha_vencimiento', function ($producto) {
                $date = Carbon::now();
                return $producto->fecha_vencimiento <= $date
                    ? '<span class="badge bg-danger">Vencido</span>'
                    : $producto->fecha_vencimiento;
            })
            ->addColumn('aplica_iva', function ($producto) {
                return $producto->aplica_iva
                    ? '<span class="badge bg-success">Sí</span>'
                    : '<span class="badge bg-danger">No</span>';
            })
            ->addColumn('imagen', function ($producto) {
                $imagen = $producto->imagenes->first();
                if ($imagen) {
                    return '<img src="' . asset($imagen->url) . '" alt="Producto" style="width: 50px; height: 50px; object-fit: cover;">';
                }
                return '<img src="' . asset('iconos/caja.png') . '" alt="Producto" style="width: 50px; height: 50px; object-fit: cover;">';
            })
            ->editColumn('created_at', fn($producto) => $producto->created_at->format('Y-m-d H:i:s'))
            ->editColumn('updated_at', fn($producto) => $producto->updated_at->format('Y-m-d H:i:s'))
            ->addColumn('subCategoria', fn($producto) => $producto->subCategoria->nombre ?? '')
            ->addColumn('categoria', fn($producto) => $producto->subCategoria->categoria->nombre ?? '')
            ->addColumn('ganancia', fn($producto) => number_format($producto->precio_venta - $producto->precio_compra, 2, '.', ''))
            ->addColumn('disponible', fn($producto) => $producto->disponible
                ? '<span class="badge bg-success">SÍ</span>'
                : '<span class="badge bg-danger">NO</span>')
            ->addColumn('actions', 'productos.actions')
            ->rawColumns(['status', 'actions', 'disponible', 'aplica_iva', 'imagen'])
            ->make(true);
        
        } else {
            $subcategorias = SubCategoria::all(); // Enviar las subcategorías a la vista
            return view('productos.index', compact('subcategorias'));
        }
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subcategorias = SubCategoria::pluck('nombre', 'id');

        return view('productos.create')->with('subcategorias', $subcategorias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos del formulario aquí si es necesario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'precio_venta' => 'required|numeric|min:0', // Precio no puede ser negativo
            'precio_compra' => 'required|numeric|min:0', // Precio no puede ser negativo
             
            'cantidad' => 'required|integer|min:0', // Cantidad no puede ser negativa
            'sub_categoria_id' => 'required|exists:sub_categorias,id',
           
        ]);
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,

            'precio_venta' => $request->precio_venta,
            'precio_compra' => $request->precio_compra,
            'aplica_iva' => 0,

            'cantidad' => $request->cantidad,
            'sub_categoria_id' => $request->sub_categoria_id,
            'disponible' => 1
        ]);



        if ($request->hasFile('imagenes')) {

            // Eliminar imágenes anteriores del producto
            ImagenProducto::where('producto_id', $producto->id)->delete();
        
            // Guardar nuevas imágenes
            foreach ($request->file('imagenes') as $imagen) {
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $rutaImagen = '/productos/' . $nombreImagen;
                $imagen->move(public_path('productos'), $nombreImagen);
        
                // Crear el registro en la base de datos
                ImagenProducto::create([
                    'url' => $rutaImagen,
                    'producto_id' => $producto->id,
                    'status' => 'Activo'
                ]);
            }
        }


        // Mensaje de éxito y redirección
        Alert::success('Éxito!', 'Producto Registrado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect(route('almacen'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $subcategorias = SubCategoria::pluck('nombre', 'id');
        $producto = Producto::where('id', $id)->first();

        return view('productos.edit')->with('subcategorias', $subcategorias)->with('producto', $producto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'precio_venta' => 'required|numeric|min:0', // Precio no puede ser negativo
            'precio_compra' => 'required|numeric|min:0', // Precio no puede ser negativo
            'cantidad' => 'required|integer|min:0', // Cantidad no puede ser negativa
            'sub_categoria_id' => 'required|exists:sub_categorias,id',
            'imagenes.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de imágenes
        ]);
    
        // Buscar el producto por su ID
        $producto = Producto::findOrFail($id);
    
        // Actualizar los campos del producto
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio_venta = $request->precio_venta;
        $producto->cantidad = $request->cantidad;
        $producto->sub_categoria_id = $request->sub_categoria_id;
        $producto->precio_compra = $request->precio_compra;
    
        // Manejar las imágenes si se envían
        if ($request->hasFile('imagenes')) {
            // Eliminar imágenes anteriores del producto
            $imagenesAnteriores = ImagenProducto::where('producto_id', $producto->id)->get();
            foreach ($imagenesAnteriores as $imagen) {
                $rutaImagenAnterior = public_path($imagen->url);
                if (file_exists($rutaImagenAnterior)) {
                    unlink($rutaImagenAnterior); // Eliminar archivo
                }
                $imagen->delete(); // Eliminar registro
            }
    
            // Guardar nuevas imágenes
            foreach ($request->file('imagenes') as $imagen) {
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $rutaImagen = '/productos/' . $nombreImagen;
                $imagen->move(public_path('productos'), $nombreImagen);
    
                // Crear el registro en la base de datos
                ImagenProducto::create([
                    'url' => $rutaImagen,
                    'producto_id' => $producto->id,
                    'status' => 'Activo',
                ]);
            }
        }
    
        // Guardar el producto actualizado
        $producto->save();
    
        // Redireccionar con un mensaje de éxito
        Alert::success('¡Éxito!', 'Producto actualizado exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('almacen');
    }
    

    public function imagenesProducto(Request $request, $id)
    {

        $producto = Producto::where('id', $id)->first();


        if (!$producto) {
            Alert::error('¡Error!', 'No existe este producto')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('almacen'));
        }
        $imagenes = ImagenProducto::where('producto_id', $id)->get();

        return view('productos.imagenes')->with('producto', $producto)->with('imagenes', $imagenes);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $producto = Producto::where('id', $id)->first();


        if (!$producto) {
            Alert::error('¡Error!', 'No existe este producto')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('almacen'));
        }

        //Eliminar ventas y compras

      try {
        DetalleVenta::where('id_producto', $producto->id)->delete();
        DetalleCompra::where('id_producto', $producto->id)->delete();
        ImagenProducto::where('producto_id', $producto->id)->delete();

        $producto->delete();
        Alert::success('¡Éxito!', 'Producto eliminado exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('almacen');
      } catch (\Throwable $th) {
        Alert::error('¡Error!', 'No se puede eliminar este producto')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('almacen'));
      }
    }

    public function agregarImagen(Request $request, $id)
    {

        $producto = Producto::where('id', $id)->first();
        // Guardar las imágenes asociadas al producto
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $rutaImagen = '/productos/' . $nombreImagen;
                $imagen->move(public_path('productos'), $nombreImagen);

                ImagenProducto::create([
                    'url' => $rutaImagen,
                    'producto_id' => $producto->id,
                    'status' => 'Activo'
                ]);
            }
        }

        // Mensaje de éxito y redirección
        Alert::success('Éxito!', 'Imagenes registradas exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect(route('almacen'));
    }

    public function removerImagen($id)
    {

        $imagen = ImagenProducto::where('id', $id)->first();


        if (!$imagen) {
            Alert::error('¡Error!', 'No existe esta imagen')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('almacen'));
        }

        $imagen->delete();
        return response()->json([
            'success' => true,
            'message' => 'Imagen eliminada exitosamente.'
        ], 200);
    }

    public function export(Request $request)
    {
        $filters = $request->only(['disponible', 'fecha_inicio', 'fecha_fin']);

        return Excel::download(new ProductosExport($filters), 'productos.xlsx');
    }

    public function reporte()
    {
       
        return view('productos.reporte', compact('productosData', 'meses'));
    }

    public function eliminarMultiplesRegistros(Request $request)
    {
        // Verifica que el array "selected_taxes" esté presente en la solicitud
        if ($request->has('selected_taxes') && is_array($request->selected_taxes)) {
            $selectedTaxes = $request->selected_taxes;

          try {
             // Elimina los registros usando Eloquent
             Producto::whereIn('id', $selectedTaxes)->delete();

             Alert::success('¡Éxito!', 'Productos eliminadas exiosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
             return redirect()->route('almacen');
          } catch (\Throwable $th) {
            Alert::error('¡Error!', 'No se pudo realizar la operación, verifique que los productos no esten en este momento asociados a una venta')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('almacen');
          }
        }

       
    }
}
