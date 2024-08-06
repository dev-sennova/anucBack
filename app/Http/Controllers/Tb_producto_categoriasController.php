<?php

namespace App\Http\Controllers;

use App\Models\Tb_producto_categorias;
use Illuminate\Http\Request;

class Tb_producto_categoriasController extends Controller
{
    public function index(Request $request)
    {
        $producto_categorias = Tb_producto_categorias::orderBy('categoria','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'producto_categorias' => $producto_categorias
        ];
    }

    public function indexOne(Request $request)
    {
        $producto_categorias = Tb_producto_categorias::orderBy('categoria','desc')
        ->where('tb_producto_categorias.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'producto_categorias' => $producto_categorias
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_producto_categorias=new Tb_producto_categorias();
            $tb_producto_categorias->categoria=$request->categoria;
            $tb_producto_categorias->estado=1;

            if ($tb_producto_categorias->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Producto Categorias fue creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Producto Categorias no pudo ser creado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_producto_categorias=Tb_producto_categorias::findOrFail($request->id);
            $tb_producto_categorias->categoria=$request->categoria;
            $tb_producto_categorias->estado='1';

            if ($tb_producto_categorias->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Producto Categorias se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Producto Categorias no pudo ser actualizado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function deactivate(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_producto_categorias=Tb_producto_categorias::findOrFail($request->id);
            $tb_producto_categorias->estado='0';

            if ($tb_producto_categorias->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Producto Categorias fue desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Producto Categorias no pudo ser desactivado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function activate(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_producto_categorias=Tb_producto_categorias::findOrFail($request->id);
            $tb_producto_categorias->estado='1';

            if ($tb_producto_categorias->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Producto Categorias fue activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Producto Categorias no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
