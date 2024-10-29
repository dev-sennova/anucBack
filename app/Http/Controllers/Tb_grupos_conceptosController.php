<?php

namespace App\Http\Controllers;

use App\Models\Tb_grupos_conceptos;
use Illuminate\Http\Request;

class Tb_grupos_conceptosController extends Controller
{
    public function index(Request $request)
    {
        $grupos_conceptos = Tb_grupos_conceptos::orderBy('grupos_conceptos','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'grupos_conceptos' => $grupos_conceptos
        ];
    }

    public function indexOne(Request $request)
    {
        $grupos_conceptos = Tb_grupos_conceptos::orderBy('grupos_conceptos','desc')
        ->where('tb_grupos_conceptos.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'grupos_conceptos' => $grupos_conceptos
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_grupos_conceptos=new Tb_grupos_conceptos();
            $tb_grupos_conceptos->grupo=$request->grupo;
            $tb_grupos_conceptos->estado=1;

            if ($tb_grupos_conceptos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'grupos_conceptos ha sido creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'grupos_conceptos no fue creado'
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
            $tb_grupos_conceptos=Tb_grupos_conceptos::findOrFail($request->id);
            $tb_grupos_conceptos->grupo=$request->grupo;
            $tb_grupos_conceptos->estado='1';

            if ($tb_grupos_conceptos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'grupos_conceptos se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'grupos_conceptos no fue actualizado'
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
            $tb_grupos_conceptos=Tb_grupos_conceptos::findOrFail($request->id);
            $tb_grupos_conceptos->estado='0';

            if ($tb_grupos_conceptos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'grupos_conceptos ha sido desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'grupos_conceptos no fue desactivado'
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
            $tb_grupos_conceptos=Tb_grupos_conceptos::findOrFail($request->id);
            $tb_grupos_conceptos->estado='1';

            if ($tb_grupos_conceptos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'grupos_conceptos ha sido activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'grupos_conceptos no fue activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
