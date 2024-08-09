<?php

namespace App\Http\Controllers;

use App\Models\Tb_asociados;
use Illuminate\Http\Request;

class Tb_asociadosController extends Controller
{
    public function index(Request $request)
    {
        $asociado = Tb_asociados::orderBy('asociado','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'asociado' => $asociado
        ];
    }

    public function indexOne(Request $request)
    {
        $asociado = Tb_asociados::orderBy('asociado','desc')
        ->where('tb_asociados.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'asociado' => $asociado
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_asociados=new Tb_asociados();
            $tb_asociados->persona=$request->persona;
            $tb_asociados->categoria=$request->categoria;
            $tb_asociados->estado=1;

            if ($tb_asociados->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El asociado ha sido creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El asociado no fue creado'
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
            $tb_asociados=Tb_asociados::findOrFail($request->id);
            $tb_asociados->persona=$request->persona;
            $tb_asociados->categoria=$request->categoria;
            $tb_asociados->estado='1';

            if ($tb_asociados->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El asociado se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El asociado no fue actualizado'
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
            $tb_asociados=Tb_asociados::findOrFail($request->id);
            $tb_asociados->estado='0';

            if ($tb_asociados->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El asociado ha sido desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El asociado no fue desactivado'
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
            $tb_asociados=Tb_asociados::findOrFail($request->id);
            $tb_asociados->estado='1';

            if ($tb_asociados->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El asociado ha sido activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El asociado no fue activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
