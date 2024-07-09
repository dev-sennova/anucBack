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
                    'message' => 'asociados_finca creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'asociados_finca no pudo ser creada'
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
                    'message' => 'asociados_finca actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'asociados_finca no pudo ser actualizada'
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
                    'message' => 'asociados_finca desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'asociados_finca no pudo ser desactivada'
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
                    'message' => 'asociados_finca activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'asociados_finca no pudo ser activada'
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
        ->join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->join("tb_tipo_documento","tb_personas.tipo_documento","=","tb_tipo_documento.id")
        ->join("tb_sexo","tb_personas.sexo","=","tb_sexo.id")
        ->join("tb_estado_civil","tb_personas.estado_civil","=","tb_estado_civil.id")
        ->join("tb_categorias","tb_asociados.categoria","=","tb_categorias.id")
        ->join("tb_veredas","tb_fincas.vereda","=","tb_veredas.id")
        ->get();

        return [
            'estado' => 'Ok',
            'asociados_finca' => $asociados_finca
        ];
    }

}
