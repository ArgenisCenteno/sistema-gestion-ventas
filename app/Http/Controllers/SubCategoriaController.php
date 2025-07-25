<?php

namespace App\Http\Controllers;

use App\Models\SubCategoria;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Flash;
use Alert;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
class SubCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subcategorias = SubCategoria::with('categoria')->get();
            return DataTables::of($subcategorias)
            ->addColumn('actions', 'subcategorias.actions')
                ->editColumn('status', function($row) {
                    return $row->status ? '<span class="badge badge-primary">Activo</span>' : '<span class="badge badge-warning text-black">Inactivo</span>';
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->format('Y-m-d H:i:s');
                })
                ->editColumn('updated_at', function($row) {
                    return $row->updated_at->format('Y-m-d H:i:s');
                })
                ->rawColumns(['actions', 'status'])
                ->make(true);
        } else {
             $categorias = Categoria::pluck('nombre', 'id');
            return view('subcategorias.index')->with('categorias', $categorias);
        }
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::pluck('nombre', 'id');
    
        return view('subcategorias.create')->with('categorias', $categorias);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $consultar = SubCategoria::where('nombre', $request->nombre)->first();
        

        if($consultar){
            Alert::error('¡Error!', 'Existe una categoría con este nombre')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('categorias.index'));
        }

        $crear = SubCategoria::create([
            'nombre' => $request->nombre,
            'categoria_id' => $request->categoria_id,
            'status' => $request->status
        ]);
        if ($crear) {
            // Categoría creada correctamente
            Alert::success('¡Éxito!', 'Registro hecho correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        } else {
            // Error al intentar crear la categoría
            Alert::error('¡Error!', 'Error al intentar registrar la subcategoría')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        }
    
        return redirect(route('subcategorias.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $subcategoria = SubCategoria::findOrFail($id);
    return response()->json($subcategoria);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subcategoria = SubCategoria::find($id);
        $categorias = Categoria::pluck('nombre', 'id');
        
        if($subcategoria){
            return view('subcategorias.edit', compact('subcategoria', 'categorias'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $actualizar = SubCategoria::where('id', $id)->first();
       

        if(!$actualizar){
            Alert::error('¡Error!', 'No existe esta subcategoria')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('categorias.index'));
        }

        $actualizar->update([
            'nombre' => $request->nombre,
            'categoria_id' => $request->categoria_id,
            'status' => $request->status
        ]);
        if ($actualizar) {
            // Categoría creada correctamente
            Alert::success('¡Éxito!', 'Registro actualizado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        } else {
            // Error al intentar crear la categoría
            Alert::error('¡Error!', 'Error al intentar actualizar la categoría')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        }
    
        return redirect(route('subcategorias.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $actualizar = SubCategoria::where('id', $id)->first();
        if(!$actualizar){
            Alert::error('¡Error!', 'No existe esta subcategoria')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('subcategorias.index'));
        }

        try {
            $actualizar->delete();
        Alert::success('¡Exito!', 'Registro eliminado exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect(route('subcategorias.index'));
        } catch (\Throwable $th) {
            Alert::error('¡Error!', 'No se puede eliminar, hay productos con esta subcategoría')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

            return redirect(route('subcategorias.index'));

        }
    }
}
