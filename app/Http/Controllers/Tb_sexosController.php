<?php

namespace App\Http\Controllers;

use App\Models\Tb_sexo;
use Illuminate\Http\Request;

class Tb_sexosController extends Controller
{
    public function index(Request $request)
    {
        $sexo = Tb_sexo::orderBy('sexo','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'sexo' => $sexo
        ];
    }

    public function indexOne(Request $request)
    {
        $sexo = Tb_sexo::orderBy('sexo','desc')
        ->where('tb_sexo.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'sexo' => $sexo
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_sexo=new Tb_sexo();
            $tb_sexo->sexo=$request->sexo;
            $tb_sexo->estado=1;

            if ($tb_sexo->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Sexo fue creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Sexo no pudo ser creado'
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
            $tb_sexo=Tb_sexo::findOrFail($request->id);
            $tb_sexo->sexo=$request->sexo;
            $tb_sexo->estado='1';

            if ($tb_sexo->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Sexo se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Sexo no pudo ser actualizado'
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
            $tb_sexo=Tb_sexo::findOrFail($request->id);
            $tb_sexo->estado='0';

            if ($tb_sexo->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Sexo fue desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Sexo no pudo ser desactivado'
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
            $tb_sexo=Tb_sexo::findOrFail($request->id);
            $tb_sexo->estado='1';

            if ($tb_sexo->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Sexo fue activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Sexo no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
