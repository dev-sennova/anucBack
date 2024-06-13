<?php

namespace App\Http\Controllers;

use App\Models\Tb_estado_civil;
use Illuminate\Http\Request;

class Tb_estado_civilController extends Controller
{
    public function index(Request $request)
    {
        $estado_civil = Tb_estado_civil::orderBy('estado_civil','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'estado_civil' => $estado_civil
        ];
    }

    public function indexOne(Request $request)
    {
        $estado_civil = Tb_estado_civil::orderBy('estado_civil','desc')
        ->where('tb_estado_civil.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'estado_civil' => $estado_civil
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_estado_civil=new Tb_estado_civil();
            $tb_estado_civil->estado_civil=$request->estado_civil;
            $tb_estado_civil->estado=1;

            if ($tb_estado_civil->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Estado Civil creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Estado Civil no pudo ser creado'
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
            $tb_estado_civil=Tb_estado_civil::findOrFail($request->id);
            $tb_estado_civil->estado_civil=$request->estado_civil;
            $tb_estado_civil->estado='1';

            if ($tb_estado_civil->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Estado Civil actualizado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Estado Civil no pudo ser actualizado'
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
            $tb_estado_civil=Tb_estado_civil::findOrFail($request->id);
            $tb_estado_civil->estado='0';

            if ($tb_estado_civil->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Estado Civil desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Estado Civil no pudo ser desactivado'
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
            $tb_estado_civil=Tb_estado_civil::findOrFail($request->id);
            $tb_estado_civil->estado='1';

            if ($tb_estado_civil->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Estado Civil activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Estado Civil no pudo ser activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
