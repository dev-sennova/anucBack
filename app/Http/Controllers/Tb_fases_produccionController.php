<?php

namespace App\Http\Controllers;

use App\Models\Tb_fases_produccion;
use Illuminate\Http\Request;

class Tb_fases_produccionController extends Controller
{
    public function index(Request $request)
    {
        $fases_produccion = Tb_fases_produccion::orderBy('nombre_fase','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'fases_produccion' => $fases_produccion
        ];
    }

    public function indexOne(Request $request)
    {
        $fases_produccion = Tb_fases_produccion::orderBy('nombre_fase','asc')
        ->where('tb_fases_produccion.idGrupo','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'fases_produccion' => $fases_produccion
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_fases_produccion=new Tb_fases_produccion();
            $tb_fases_produccion->nombre_fase=$request->nombre_fase;
            $tb_fases_produccion->descripcion=$request->descripcion;
            $tb_fases_produccion->idGrupo=$request->idGrupo;
            $tb_fases_produccion->estado=1;

            if ($tb_fases_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'fases produccion ha sido creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'fases produccion no fue creado'
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
            $tb_fases_produccion=Tb_fases_produccion::findOrFail($request->id);
            $tb_fases_produccion->nombre_fase=$request->nombre_fase;
            $tb_fases_produccion->descripcion=$request->descripcion;
            $tb_fases_produccion->idGrupo=$request->idGrupo;
            $tb_fases_produccion->estado='1';

            if ($tb_fases_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'fases_produccion se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'fases_produccion no fue actualizado'
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
            $tb_fases_produccion=Tb_fases_produccion::findOrFail($request->id);
            $tb_fases_produccion->estado='0';

            if ($tb_fases_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'fases_produccion ha sido desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'fases_produccion no fue desactivado'
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
            $tb_fases_produccion=Tb_fases_produccion::findOrFail($request->id);
            $tb_fases_produccion->estado='1';

            if ($tb_fases_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'fases_produccion ha sido activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'fases_produccion no fue activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
