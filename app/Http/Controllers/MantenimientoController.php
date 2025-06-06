<?php

namespace App\Http\Controllers;

use App\Exports\MantenimientoExport;
use App\Models\AperturaCaja;
use App\Models\Caja;
use App\Models\DetalleMantenimiento;
use App\Models\Mantenimiento;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Recibo;
use App\Models\Tasa;
use App\Models\Transaccion;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;  
use Alert;
class MantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('superAdmin')) {
                $data = Mantenimiento::with(['user', 'empleado', 'pago'])->orderBy('id', 'DESC')->get();
 
            } else {
                $data = Mantenimiento::with(['user', 'empleado', 'pago'])->where('empleado_id', Auth::user()->id)->get();

            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('empleado', function ($row) {
                    return $row->empleado->name ?? 'S/D';
                })
             
                ->addColumn('monto_total', function ($row) {
                    return number_format($row->pago->monto_total, 2);
                })
                ->addColumn('fecha', function ($row) {
                    return $row->created_at->format('Y-m-d'); // Ajusta el formato de fecha aquí
                })
                ->addColumn('status', function ($row) {
                    $status = $row->pago->status;
                    $class = $status == 'Pagado' ? 'primary' : 'danger'; // Clase basada en el estado
                    return '<span class="badge bg-' . $class . '">' . $status . '</span>';
                })
                ->addColumn('actions', function ($row) {
                    $viewUrl = route('mantenimientos.edit', $row->id);
                    $deleteUrl = route('mantenimientos.destroy', $row->id);
                    $pdfUrl = route('mantenimientos.pdf', $row->id); // Asegúrate de que la ruta esté correcta
    
                    return view('ventas.actions', compact('viewUrl', 'deleteUrl', 'pdfUrl'))->render();
                })

                ->rawColumns(['status', 'actions'])
                ->make(true);
        }

        return view('mantenimientos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {


        $users = User::pluck('name', 'id');

        function isConnected()
        {
            $connected = @fsockopen("www.google.com", 80); // Intenta conectar al puerto 80 de Google
            if ($connected) {
                fclose($connected);
                return true; // Hay conexión
            }
            return false; // No hay conexión
        }

        if (isConnected()) {
            $response = file_get_contents("https://ve.dolarapi.com/v1/dolares/oficial");

        } else {

            $response = false;
        }



        // dd();
        if ($response) {
            $dato = json_decode($response);
            $dollar = $dato->promedio;
        } else {
            $consulta = Tasa::where('name', 'DOLLAR')->where('status', 'Activo')->first();
            $dollar = $consulta->valor;

        }

        return view('mantenimientos.mantener')->with('dollar', $dollar)->with('users', $users);
    }

    public function datatableProductoVenta(Request $request)
    {
        if ($request->ajax()) {
            $productos = Producto::with('subCategoria.categoria')
            ->whereHas('subCategoria.categoria', function ($query) {
                $query->where('nombre', 'SERVICIOS');
            }) 
            ->get();

            return DataTables::of($productos)
                ->addColumn('fecha_vencimiento', function ($producto) {
                    $date = Carbon::now();
                    if ($producto->fecha_vencimiento <= $date) {
                        return '<span class="badge bg-danger">Vencido</span>';
                    } else {
                        return $producto->fecha_vencimiento;
                    }
                })
                ->addColumn('imagen', function ($producto) {
                    $imagen = $producto->imagenes->first();
                    if ($imagen) {
                        return '<img src="' . asset($imagen->url) . '" alt="Producto" style="width: 50px; height: 50px; object-fit: cover;">';
                    }
                    return '<img src="' . asset('iconos/caja.png') . '" alt="Producto" style="width: 50px; height: 50px; object-fit: cover;">';
                })
                ->editColumn('created_at', function ($producto) {
                    return $producto->created_at->format('Y-m-d H:i:s');
                })
                ->addColumn('categoria', function ($producto) {
                    return $producto->subCategoria->categoria->nombre ?? '';
                })
                ->addColumn('subCategoria', function ($producto) {
                    return $producto->subCategoria ? $producto->subCategoria->nombre : '';
                })
                ->addColumn('actions', function ($producto) {
                    return '<button type="button" id="agregarCarrito" class="btn btn-success"><span >Agregar</span></button>';
                })
                ->rawColumns(['fecha_vencimiento', 'actions', 'imagen']) // Especifica las columnas que contienen HTML sin escape
                ->make(true);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        

       // dd($request);
        $caja = Caja::find(1);

        if (!$caja) {
            Alert::error('¡Error!', 'No hay caja disponible')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->back();

        }

        $apertura = AperturaCaja::where('caja_id', $caja->id)->where('estatus', 'Operando')->first();
        if (!$apertura) {
            Alert::error('¡Error!', 'No existe una caja abierta')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->back();
        }
        if ($request->productos == [] || $request->productos == null) {
            Alert::error('¡Error!', 'Para realizar una venta es necesario agregar productos')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->back();
        }
        //obtener datos
        $productos = $request->productos;

        $paymentMethods = [
            [
                "id" => 1,
                "metodo" => "Efectivo",
                "monto" => $request->input('Efectivo') // Monto ingresado para "Efectivo"
            ],
            [
                "id" => 2,
                "metodo" => "Punto de Venta",
                "monto" => $request->input('Punto-de-Venta')
            ],
            [
                "id" => 3,
                "metodo" => "Transferencia",
                "monto" => $request->input('Transferencia')
            ],
            [
                "id" => 4,
                "metodo" => "Pago Movil",
                "monto" => $request->input('Pago-Movil')
            ],
            [
                "id" => 6,
                "metodo" => "Divisa",
                "monto" => $request->input('Divisa')
            ]
        ];


       
        // Filtrar los métodos de pago que sean distintos de null y mayores a cero
        $filteredPayments = array_filter($paymentMethods, function ($value) {
            return $value !== null && $value > 0;
        });

        // Convertir el array filtrado a un objeto JSON
        $jsonObject = json_encode($filteredPayments);

        $metodos = json_decode($jsonObject, true);

        $tasaDollar = $request->dollar;

        //calcular el monto total, monto neto e impuestos

        $totalNeto = 0;
        $montoTotal = 0;
        $impuestosTotal = 0;

        foreach ($productos as $producto) {
            $nombre = $producto['nombre'];

            $cantidad = $producto['cantidad'];



            $productoModel = Producto::where('nombre', $nombre)->first();
            if ($productoModel->cantidad <= $cantidad) {


                // Mostrar un mensaje de error con el nombre del producto
                Alert::error('¡Error!', "Stock insuficiente para el producto: $nombre")
                    ->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

                return redirect()->back();
            }

            $totalNeto += $productoModel->precio_venta * $cantidad * $tasaDollar;

            if ($productoModel->aplica_iva == 1) {
                $montoTotal += $cantidad * $productoModel->precio_venta * 1.16 * $tasaDollar;
                $impuestosTotal += ($productoModel->precio_venta * 0.16) * $cantidad * $tasaDollar;
            } else {
                $montoTotal += $productoModel->precio_venta * $cantidad * $tasaDollar;
            }
        }


        $userId = Auth::id();

        //registrar pago

        $pago = new Pago();
        $pago->status = 'Pagado';
        $pago->tipo = 'Servicio';
        $pago->forma_pago = json_encode($metodos);
        $pago->monto_total = $montoTotal;
        $pago->monto_neto = $totalNeto;
        $pago->tasa_dolar = $request->tasa;
        $pago->creado_id = $userId;
        $pago->fecha_pago = Carbon::now()->format('Y-m-d');
        $pago->impuestos = $impuestosTotal;
        $pago->save();

        //registrar venta
        $venta = new Mantenimiento();
        $venta->user_id = $request->user_id;
        $venta->empleado_id = $userId;
        $venta->monto_total = $montoTotal;
        $venta->descripcion = $request->descripcion;
        $venta->monto_mantenimiento = $montoTotal;
        $venta->monto_adicional = 0;
        $venta->estado = $request->estado;
        $venta->fecha_ingreso = $request->fecha_ingreso;
        $venta->fecha_estimada_entrega = $request->fecha_estimada_entrega;
        $venta->pago_id = $pago->id;
        $venta->save();

        // Registrar detalles ventas
        foreach ($productos as $producto) {
            $nombre = $producto['nombre'];

            $cantidad = $producto['cantidad'];



            $productoModel = Producto::where('nombre', $nombre)->first();


            $detalleVenta = new DetalleMantenimiento();
            $detalleVenta->producto_id = $productoModel->id;
            $detalleVenta->precio_producto = $productoModel->precio_venta * $tasaDollar;
            $detalleVenta->cantidad = $cantidad;
            $detalleVenta->neto = $productoModel->precio_venta * $cantidad * $tasaDollar;
          //  $detalleVenta->impuesto = ($productoModel->aplica_iva == 1) ? ($productoModel->precio_venta * 0.16 * $tasaDollar) * $cantidad : 0;
            $detalleVenta->mantenimiento_id = $venta->id;
            $detalleVenta->save();

            // Actualizar stock

         //   $productoModel->cantidad -= $producto['cantidad'];
         //   $productoModel->save();

        }

        $recibo = new Recibo();
        $recibo->tipo = 'Servicio';
        $recibo->monto = $montoTotal;
        $recibo->estatus = 'Pagado';
        $recibo->pago_id = $pago->id;
        $recibo->user_id = $request->user_id;
        $recibo->activo = 1;
        $recibo->creado_id = $userId;
        $recibo->descuento = $request->descuento;
        $recibo->save();

        //caja
       

        
        foreach ($metodos as $metodo) {
            // Verificar si el monto es mayor a 0 para cada metodo
            
            if (($metodo['monto'] > 0) && $metodo['metodo']) {
                // Asignar monto y datos del método de pago según el caso
                $monto = $metodo['monto'];
                $forma_pago = $metodo['metodo'];
               
                $moneda = ($metodo['metodo'] === 'Divisa') ? 'Dollar' : 'Bolívar';  // Cambiar moneda según el método
           
           
            // Crear la transacción
            $transaccion = new Transaccion();
            $transaccion->caja_id = 1; // Asume que tienes un valor fijo o el ID de la caja
            $transaccion->usuario_id = $userId; // Asume que tienes el ID del usuario
            $transaccion->tipo = 'SERVICIO'; // Tipo de transacción
            $transaccion->apertura_id = $apertura->id;
            $transaccion->mantenimiento_id = $venta->id;
            $transaccion->metodo_pago = $forma_pago;

            // Verificar si el pago es en divisa y asignar los valores correspondientes
            if ($moneda === 'Dollar') {
                $transaccion->moneda = $moneda;
                $transaccion->monto_total_dolares = $monto ?? 0;
                $transaccion->monto_total_bolivares = 0;
            } else {
                $transaccion->moneda = $moneda;
                $transaccion->monto_total_bolivares = $monto ?? 0;
                $transaccion->monto_total_dolares = 0;
            }

            $transaccion->fecha = Carbon::now(); // Fecha actual de la transacción
            $transaccion->save(); // Guardar la transacción en la base de datos
            }
            
           
        }

        Alert::success('¡Exito!', 'Se ha registrado el mantenimiento')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('mantenimientos.index', $venta->id);
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
    public function edit(string $id)
    {
        $venta = Mantenimiento::with(['user', 'empleado', 'pago', 'detalles'])->find($id);
        return view('mantenimientos.edit', compact('venta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mantenimiento = Mantenimiento::find($id);

        if(!$mantenimiento){
            Alert::error('¡Error!', 'Mantenimiento no encontrado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->route('ventas');
        }

        $mantenimiento->estado = $request->estado;
        $mantenimiento->save();

        Alert::success('¡Éxito!', 'Mantenimiento Actualizado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('mantenimientos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $venta = Mantenimiento::find($id);

        if (!$venta) {
            Alert::error('¡Error!', 'Mantenimiento no encontrado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->route('ventas');
        }

        // Elimina los detalles de la venta
        $venta->detalles()->delete();

        // Elimina el pago asociado a la venta
        if ($venta->pago) {
            $venta->pago->delete();
        }

        // Elimina la venta
        $venta->delete();

        Alert::success('¡Éxito!', 'Mantenimiento eliminado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('mantenimientos.index');
    }

    public function eliminarMultiplesRegistros(Request $request)
    {
        // Verifica que el array "selected_taxes" esté presente en la solicitud
        if ($request->has('selected_taxes') && is_array($request->selected_taxes)) {
            $selectedTaxes = $request->selected_taxes;

            // Elimina los registros usando Eloquent
            Mantenimiento::whereIn('id', $selectedTaxes)->delete();

            Alert::success('¡Éxito!', 'Mantenimiento eliminadas exiosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->route('mantenimientos.index');
        }

        Alert::error('¡Error!', 'Datos invalidos')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('mantenimientos.index');
    }

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $type = $request->type;

        if ($type == 'EXCEL') {
            return Excel::download(new MantenimientoExport($startDate, $endDate), 'ventas.xlsx');
        } elseif ($type == 'PDF') {
            $ventas = Mantenimiento::with(['user', 'empleado'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $pdf = \PDF::loadView('exports.ventas_pdf', compact('ventas'));

            // Abre el PDF en el navegador
            return $pdf->stream('ventas.pdf');
        }
    }
}
