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
                    'message' => 'asociado creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'asociado no pudo ser creada'
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
                    'message' => 'asociado actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'asociado no pudo ser actualizada'
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
                    'message' => 'asociado desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'asociado no pudo ser desactivada'
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
                    'message' => 'asociado activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'asociado no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
