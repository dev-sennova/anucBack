<?php

namespace App\Http\Controllers;

use App\Models\Tb_tipo_predio;
use Illuminate\Http\Request;

class Tb_tipo_predioController extends Controller
{
    public function index(Request $request)
    {
        $tipo_predio = Tb_tipo_predio::orderBy('tipo_predio','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'tipo_predio' => $tipo_predio
        ];
    }

    public function indexOne(Request $request)
    {
        $tipo_predio = Tb_tipo_predio::orderBy('tipo_predio','desc')
        ->where('tb_tipo_predio.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'tipo_predio' => $tipo_predio
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_tipo_predio=new Tb_tipo_predio();
            $tb_tipo_predio->tipo_predio=$request->tipo_predio;
            $tb_tipo_predio->estado=1;

            if ($tb_tipo_predio->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El tipo de predio ha sido creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El tipo de predio no fue creado'
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
            $tb_tipo_predio=Tb_tipo_predio::findOrFail($request->id);
            $tb_tipo_predio->tipo_predio=$request->tipo_predio;
            $tb_tipo_predio->estado='1';

            if ($tb_tipo_predio->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El tipo de predio se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El tipo de predio no fue actualizado'
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
            $tb_tipo_predio=Tb_tipo_predio::findOrFail($request->id);
            $tb_tipo_predio->estado='0';

            if ($tb_tipo_predio->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El tipo de predio ha sido desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El tipo de predio no fue desactivado'
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
            $tb_tipo_predio=Tb_tipo_predio::findOrFail($request->id);
            $tb_tipo_predio->estado='1';

            if ($tb_tipo_predio->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El tipo de predio ha sido activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El tipo de predio no fue activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
