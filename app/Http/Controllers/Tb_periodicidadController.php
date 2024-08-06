<?php

namespace App\Http\Controllers;

use App\Models\Tb_periodicidad;
use Illuminate\Http\Request;

class Tb_periodicidadController extends Controller
{
    public function index(Request $request)
    {
        $periodicidad = Tb_periodicidad::orderBy('periodicidad','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'periodicidad' => $periodicidad
        ];
    }

    public function indexOne(Request $request)
    {
        $periodicidad = Tb_periodicidad::orderBy('periodicidad','desc')
        ->where('tb_periodicidad.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'periodicidad' => $periodicidad
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_periodicidad=new Tb_periodicidad();
            $tb_periodicidad->periodicidad=$request->periodicidad;
            $tb_periodicidad->estado=1;

            if ($tb_periodicidad->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Periodicidad fuecreado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Periodicidad no pudo ser creado'
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
            $tb_periodicidad=Tb_periodicidad::findOrFail($request->id);
            $tb_periodicidad->periodicidad=$request->periodicidad;
            $tb_periodicidad->estado='1';

            if ($tb_periodicidad->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Periodicidad se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Periodicidad no pudo ser actualizado'
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
            $tb_periodicidad=Tb_periodicidad::findOrFail($request->id);
            $tb_periodicidad->estado='0';

            if ($tb_periodicidad->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Periodicidad fue desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Periodicidad no pudo ser desactivado'
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
            $tb_periodicidad=Tb_periodicidad::findOrFail($request->id);
            $tb_periodicidad->estado='1';

            if ($tb_periodicidad->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Periodicidad fue activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Periodicidad no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
