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
                    'message' => 'Sexo ha sido creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Sexo no fue creado'
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
                    'message' => 'Sexo no fue actualizado'
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
                    'message' => 'Sexo ha sido desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Sexo no fue desactivado'
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
                    'message' => 'Sexo ha sido activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Sexo no fue activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
