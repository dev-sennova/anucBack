<?php

namespace App\Http\Controllers;

use App\Models\Tb_productos;
use Illuminate\Http\Request;

class Tb_productosController extends Controller
{
    public function index(Request $request)
    {
        $productos = Tb_productos::orderBy('producto','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'productos' => $productos
        ];
    }

    public function indexOne(Request $request)
    {
        $productos = Tb_productos::orderBy('producto','desc')
        ->where('tb_productos.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'productos' => $productos
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_productos=new Tb_productos();
            $tb_productos->producto=$request->producto;
            $tb_productos->categoria=$request->categoria;
            $tb_productos->estado=1;

            if ($tb_productos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Productos creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Productos no pudo ser creada'
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
            $tb_productos=Tb_productos::findOrFail($request->id);
            $tb_productos->producto=$request->producto;
            $tb_productos->categoria=$request->categoria;
            $tb_productos->estado='1';

            if ($tb_productos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Productos actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Productos no pudo ser actualizada'
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
            $tb_productos=Tb_productos::findOrFail($request->id);
            $tb_productos->estado='0';

            if ($tb_productos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Productos desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Productos no pudo ser desactivada'
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
            $tb_productos=Tb_productos::findOrFail($request->id);
            $tb_productos->estado='1';

            if ($tb_productos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Productos activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Productos no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
