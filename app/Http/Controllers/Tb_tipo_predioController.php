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
                    'message' => 'Tipo de predio fue creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Tipo de predio no pudo ser creado'
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
                    'message' => 'Tipo de predio se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Tipo de predio no pudo ser actualizado'
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
                    'message' => 'Tipo de predio fue desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Tipo de predio no pudo ser desactivado'
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
                    'message' => 'Tipo de predio fue activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Tipo de predio no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
