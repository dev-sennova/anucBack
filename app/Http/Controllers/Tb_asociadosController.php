<?php

namespace App\Http\Controllers;

use App\Models\Tb_asociados;
use App\Models\Tb_familiares;
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

    public function indexOneDetalle(Request $request)
    {
        $asociado = Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->where('tb_asociados.id','=',$request->id)
        ->get();

        $produccion = Tb_asociados::join("tb_asociados_fincas","tb_asociados_fincas.asociado","=","tb_asociados.id")
        ->join("tb_fincas","tb_asociados_fincas.finca","=","tb_fincas.id")
        ->join("tb_veredas","tb_fincas.vereda","=","tb_veredas.id")
        ->join("tb_produccion","tb_asociados_fincas.id","=","tb_produccion.asociados_finca")
        ->join("tb_productos","tb_produccion.producto","=","tb_productos.id")
        ->where('tb_asociados.id','=',$request->id)
        ->get();

        $familiares = Tb_familiares::join("tb_personas","tb_familiares.persona","=","tb_personas.id")
        ->where('tb_familiares.asociado','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'asociado' => $asociado,
            'familiares' => $familiares,
            'produccion' => $produccion
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
