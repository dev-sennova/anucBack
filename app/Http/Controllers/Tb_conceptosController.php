<?php

namespace App\Http\Controllers;

use App\Models\Tb_conceptos;
use Illuminate\Http\Request;

class Tb_conceptosController extends Controller
{
    public function index(Request $request)
    {
        $conceptos = Tb_conceptos::orderBy('concepto','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'conceptos' => $conceptos
        ];
    }

    public function indexOne(Request $request)
    {
        $conceptos = Tb_conceptos::orderBy('concepto','desc')
        ->where('tb_conceptos.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'conceptos' => $conceptos
        ];
    }

    public function indexOneGrupo(Request $request)
    {
        $conceptos = Tb_conceptos::orderBy('concepto','desc')
        ->where('tb_conceptos.idGrupo','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'conceptos' => $conceptos
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_conceptos=new Tb_conceptos();
            $tb_conceptos->concepto=$request->concepto;
            $tb_conceptos->idGrupo=$request->idGrupo;
            $tb_conceptos->estado=1;

            if ($tb_conceptos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'conceptos ha sido creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'conceptos no fue creado'
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
            $tb_conceptos=Tb_conceptos::findOrFail($request->id);
            $tb_conceptos->concepto=$request->concepto;
            $tb_conceptos->idGrupo=$request->idGrupo;
            $tb_conceptos->estado='1';

            if ($tb_conceptos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Concepto se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Concepto no fue actualizado'
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
            $tb_conceptos=Tb_conceptos::findOrFail($request->id);
            $tb_conceptos->estado='0';

            if ($tb_conceptos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Concepto ha sido desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Concepto no fue desactivado'
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
            $tb_conceptos=Tb_conceptos::findOrFail($request->id);
            $tb_conceptos->estado='1';

            if ($tb_conceptos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Concepto ha sido activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Concepto no fue activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
