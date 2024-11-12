<?php

namespace App\Http\Controllers;

use App\Models\Tb_generalidades_produccion;
use Illuminate\Http\Request;

class Tb_generalidades_produccionController extends Controller
{
    public function index(Request $request)
    {
        $generalidades_produccion = Tb_generalidades_produccion::orderBy('idGrupo','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'generalidades_produccion' => $generalidades_produccion
        ];
    }

    public function indexOne(Request $request)
    {
        $generalidades_produccion = Tb_generalidades_produccion::orderBy('idGrupo','desc')
        ->where('tb_generalidades_produccion.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'generalidades_produccion' => $generalidades_produccion
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_generalidades_produccion=new Tb_generalidades_produccion();
            $tb_generalidades_produccion->pregunta_1=$request->pregunta_1;
            $tb_generalidades_produccion->pregunta_2=$request->pregunta_2;
            $tb_generalidades_produccion->pregunta_3=$request->pregunta_3;
            $tb_generalidades_produccion->pregunta_4=$request->pregunta_4;
            $tb_generalidades_produccion->pregunta_5=$request->pregunta_5;
            $tb_generalidades_produccion->pregunta_6=$request->pregunta_6;
            $tb_generalidades_produccion->idGrupo=$request->idGrupo;
            $tb_generalidades_produccion->estado=1;

            if ($tb_generalidades_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'generalidades_produccion ha sido creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'generalidades_produccion no fue creado'
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
            $tb_generalidades_produccion=Tb_generalidades_produccion::findOrFail($request->id);
            $tb_generalidades_produccion->pregunta_1=$request->pregunta_1;
            $tb_generalidades_produccion->pregunta_2=$request->pregunta_2;
            $tb_generalidades_produccion->pregunta_3=$request->pregunta_3;
            $tb_generalidades_produccion->pregunta_4=$request->pregunta_4;
            $tb_generalidades_produccion->pregunta_5=$request->pregunta_5;
            $tb_generalidades_produccion->pregunta_6=$request->pregunta_6;
            $tb_generalidades_produccion->idGrupo=$request->idGrupo;
            $tb_generalidades_produccion->estado='1';

            if ($tb_generalidades_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'generalidades_produccion se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'generalidades_produccion no fue actualizado'
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
            $tb_generalidades_produccion=Tb_generalidades_produccion::findOrFail($request->id);
            $tb_generalidades_produccion->estado='0';

            if ($tb_generalidades_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'generalidades_produccion ha sido desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'generalidades_produccion no fue desactivado'
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
            $tb_generalidades_produccion=Tb_generalidades_produccion::findOrFail($request->id);
            $tb_generalidades_produccion->estado='1';

            if ($tb_generalidades_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'generalidades_produccion ha sido activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'generalidades_produccion no fue activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
