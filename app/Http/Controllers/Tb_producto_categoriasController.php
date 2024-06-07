<?php

namespace App\Http\Controllers;

use App\Models\Tb_producto_categorias;
use Illuminate\Http\Request;

class Tb_producto_categoriasController extends Controller
{
    public function index(Request $request)
    {
        $producto_categorias = Tb_producto_categorias::orderBy('producto_categorias','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'producto_categorias' => $producto_categorias
        ];
    }

    public function indexOne(Request $request)
    {
        $producto_categorias = Tb_producto_categorias::orderBy('producto_categorias','desc')
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
                    'message' => 'producto_categorias creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'producto_categorias no pudo ser creada'
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
                    'message' => 'producto_categorias actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'producto_categorias no pudo ser actualizada'
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
                    'message' => 'producto_categorias desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'producto_categorias no pudo ser desactivada'
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
                    'message' => 'producto_categorias activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'producto_categorias no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
