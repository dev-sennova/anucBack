<?php

namespace App\Http\Controllers;

use App\Models\Tb_detallado_produccion;
use Illuminate\Http\Request;

class Tb_detallado_produccionController extends Controller
{
    public function index(Request $request)
    {
        $detallado_produccion = Tb_detallado_produccion::orderBy('idHojaCostos','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'detallado_produccion' => $detallado_produccion
        ];
    }

    public function indexOne(Request $request)
    {
        $detallado_produccion = Tb_detallado_produccion::orderBy('idHojaCostos','desc')
        ->where('tb_detallado_produccion.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'detallado_produccion' => $detallado_produccion
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_detallado_produccion=new Tb_detallado_produccion();
            $tb_detallado_produccion->cantidad=$request->cantidad;
            $tb_detallado_produccion->detalle=$request->detalle;
            $tb_detallado_produccion->valorUnitario=$request->valorUnitario;
            $tb_detallado_produccion->idConcepto=$request->idConcepto;
            $tb_detallado_produccion->idFase=$request->idFase;
            $tb_detallado_produccion->idHojaCostos=$request->idHojaCostos;
            $tb_detallado_produccion->estado=1;

            if ($tb_detallado_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Detallado produccion ha sido creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Detallado produccion no fue creado'
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
            $tb_detallado_produccion=Tb_detallado_produccion::findOrFail($request->id);
            $tb_detallado_produccion->cantidad=$request->cantidad;
            $tb_detallado_produccion->detalle=$request->detalle;
            $tb_detallado_produccion->valorUnitario=$request->valorUnitario;
            $tb_detallado_produccion->idConcepto=$request->idConcepto;
            $tb_detallado_produccion->idFase=$request->idFase;
            $tb_detallado_produccion->idHojaCostos=$request->idHojaCostos;
            $tb_detallado_produccion->estado='1';

            if ($tb_detallado_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Detallado produccion se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Detallado produccion no fue actualizado'
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
            $tb_detallado_produccion=Tb_detallado_produccion::findOrFail($request->id);
            $tb_detallado_produccion->estado='0';

            if ($tb_detallado_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Detallado produccion ha sido desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Detallado produccion no fue desactivado'
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
            $tb_detallado_produccion=Tb_detallado_produccion::findOrFail($request->id);
            $tb_detallado_produccion->estado='1';

            if ($tb_detallado_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Detallado produccion ha sido activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Detallado produccion no fue activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
