<?php

namespace App\Http\Controllers;

use App\Models\Tb_asociados_fincas;
use Illuminate\Http\Request;

class Tb_asociados_fincasController extends Controller
{
    public function index(Request $request)
    {
        $asociados_finca = Tb_asociados_fincas::orderBy('id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'asociados_finca' => $asociados_finca
        ];
    }

    public function indexOne(Request $request)
    {
        $asociados_finca = Tb_asociados_fincas::orderBy('id','desc')
        ->where('tb_asociados_fincas.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'asociados_finca' => $asociados_finca
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_asociados_fincas=new Tb_asociados_fincas();
            $tb_asociados_fincas->finca=$request->finca;
            $tb_asociados_fincas->asociado=$request->asociado;
            $tb_asociados_fincas->tipo_predio=$request->tipo_predio;
            $tb_asociados_fincas->estado=1;

            if ($tb_asociados_fincas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El asociado de la finca ha sido creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El asociado de la finca no fue creado'
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
            $tb_asociados_fincas=Tb_asociados_fincas::findOrFail($request->id);
            $tb_asociados_fincas->finca=$request->finca;
            $tb_asociados_fincas->asociado=$request->asociado;
            $tb_asociados_fincas->tipo_predio=$request->tipo_predio;
            $tb_asociados_fincas->estado='1';

            if ($tb_asociados_fincas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El asociado de la finca se actualizò con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El asociado de la finca no fue actualizado'
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
            $tb_asociados_fincas=Tb_asociados_fincas::findOrFail($request->id);
            $tb_asociados_fincas->estado='0';

            if ($tb_asociados_fincas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El asociado de la finca ha sido desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El asociado de la finca no fue desactivado'
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
            $tb_asociados_fincas=Tb_asociados_fincas::findOrFail($request->id);
            $tb_asociados_fincas->estado='1';

            if ($tb_asociados_fincas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El asociado de la finca ha sido activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El asociado de la finca no fue activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function detallado(Request $request)
    {
        # Modelo::join('tablaqueseune',basicamente un on)
        $asociados_finca = Tb_asociados_fincas::join("tb_fincas","tb_asociados_fincas.finca","=","tb_fincas.id")
        ->join("tb_tipo_predios","tb_asociados_fincas.tipo_predio","=","tb_tipo_predios.id")
        ->join("tb_asociados","tb_asociados_fincas.asociado","=","tb_asociados.id")
        ->join("tb_asociado_permisos","tb_asociado_permisos.asociado","=","tb_asociados.id")
        ->join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->join("tb_tipo_documento","tb_personas.tipo_documento","=","tb_tipo_documento.id")
        ->join("tb_sexo","tb_personas.sexo","=","tb_sexo.id")
        ->join("tb_estado_civil","tb_personas.estado_civil","=","tb_estado_civil.id")
        ->join("tb_categorias","tb_asociados.categoria","=","tb_categorias.id")
        ->join("tb_veredas","tb_fincas.vereda","=","tb_veredas.id")
        ->select(
            "tb_asociados_fincas.*",
            "tb_fincas.*",
            "tb_tipo_predios.*",
            "tb_asociados.*",
            "tb_asociado_permisos.telefono as permisotelefono",
            "tb_asociado_permisos.correo as permisocorreo",
            "tb_asociado_permisos.whatsapp as permisowhatsapp",
            "tb_asociado_permisos.facebook as permisofacebook",
            "tb_asociado_permisos.instagram as permisoinstagram", // Alias para evitar conflicto
            "tb_personas.*",
            "tb_tipo_documento.*",
            "tb_sexo.*",
            "tb_estado_civil.*",
            "tb_categorias.*",
            "tb_veredas.*"
        )
        ->get();

        return [
            'estado' => 'Ok',
            'asociados_finca' => $asociados_finca
        ];
    }

    public function indexByAsociado(Request $request)
    {
        # Modelo::join('tablaqueseune',basicamente un on)
        $asociados_finca = Tb_asociados_fincas::join("tb_fincas","tb_asociados_fincas.finca","=","tb_fincas.id")
        ->join("tb_tipo_predios","tb_asociados_fincas.tipo_predio","=","tb_tipo_predios.id")
        ->join("tb_asociados","tb_asociados_fincas.asociado","=","tb_asociados.id")
        ->join("tb_categorias","tb_asociados.categoria","=","tb_categorias.id")
        ->join("tb_veredas","tb_fincas.vereda","=","tb_veredas.id")
        ->where('tb_asociados_fincas.asociado','=',$request->idAsociado)
        ->select(
            "tb_asociados_fincas.id as idAsociacion",
            "tb_fincas.id as idFinca",
            "tb_fincas.nombre as nombreFinca",
            "tb_fincas.extension",
            "tb_fincas.latitud",
            "tb_fincas.longitud",
            "tb_tipo_predios.id as idTipoPredio",
            "tb_tipo_predios.tipo_predio as tipo_predio",
            "tb_asociados.id as idAsociado",
            "tb_veredas.id as idVereda",
            "tb_veredas.vereda as nombreVereda"
        )
        ->get();

        return [
            'estado' => 'Ok',
            'asociados_finca' => $asociados_finca
        ];
    }

    public function indexOneByAsociado(Request $request)
    {
        # Modelo::join('tablaqueseune',basicamente un on)
        $asociacion_finca = Tb_asociados_fincas::where('tb_asociados_fincas.asociado','=',$request->idAsociado)
        ->get();

        return [
            'estado' => 'Ok',
            'asociacion_finca' => $asociacion_finca
        ];
    }

}
