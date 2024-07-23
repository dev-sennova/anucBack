<?php

namespace App\Http\Controllers;

use App\Models\Tb_produccion;
use Illuminate\Http\Request;

class Tb_produccionController extends Controller
{
    public function index(Request $request)
    {
        $produccion = Tb_produccion::orderBy('produccion','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'produccion' => $produccion
        ];
    }

    public function indexOne(Request $request)
    {
        $produccion = Tb_produccion::orderBy('produccion','desc')
        ->where('tb_produccion.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'produccion' => $produccion
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_produccion=new Tb_produccion();
            $tb_produccion->produccion=$request->produccion;
            $tb_produccion->producto=$request->producto;
            $tb_produccion->periodicidad=$request->periodicidad;
            $tb_produccion->medida=$request->medida;
            $tb_produccion->asociados_finca=$request->asociados_finca;
            $tb_produccion->estado=1;

            if ($tb_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'produccion creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'produccion no pudo ser creada'
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
            $tb_produccion=Tb_produccion::findOrFail($request->id);
            $tb_produccion->produccion=$request->produccion;
            $tb_produccion->producto=$request->producto;
            $tb_produccion->periodicidad=$request->periodicidad;
            $tb_produccion->medida=$request->medida;
            $tb_produccion->asociados_finca=$request->asociados_finca;
            $tb_produccion->estado='1';

            if ($tb_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'produccion actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'produccion no pudo ser actualizada'
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
            $tb_produccion=Tb_produccion::findOrFail($request->id);
            $tb_produccion->estado='0';

            if ($tb_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'produccion desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'produccion no pudo ser desactivada'
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
            $tb_produccion=Tb_produccion::findOrFail($request->id);
            $tb_produccion->estado='1';

            if ($tb_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'produccion activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'produccion no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
