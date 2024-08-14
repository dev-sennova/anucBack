<?php

namespace App\Http\Controllers;

use App\Models\Tb_tipo_documento;
use Illuminate\Http\Request;

class Tb_tipo_documentosController extends Controller
{
    public function index(Request $request)
    {
        $tipo_documento = Tb_tipo_documento::orderBy('tipo_documento','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'tipo_documento' => $tipo_documento
        ];
    }

    public function indexOne(Request $request)
    {
        $tipo_documento = Tb_tipo_documento::orderBy('tipo_documento','desc')
        ->where('tb_tipo_documento.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'tipo_documento' => $tipo_documento
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_tipo_documento=new Tb_tipo_documento();
            $tb_tipo_documento->tipo_documento=$request->tipo_documento;
            $tb_tipo_documento->estado=1;

            if ($tb_tipo_documento->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El tipo de documento ha sido creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El tipo de documento no fue creado'
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
            $tb_tipo_documento=Tb_tipo_documento::findOrFail($request->id);
            $tb_tipo_documento->tipo_documento=$request->tipo_documento;
            $tb_tipo_documento->estado='1';

            if ($tb_tipo_documento->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El tipo de documento se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El tipo de documento no fue actualizado'
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
            $tb_tipo_documento=Tb_tipo_documento::findOrFail($request->id);
            $tb_tipo_documento->estado='0';

            if ($tb_tipo_documento->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El tipo de documento ha sido desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El tipo de documento no fue desactivado'
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
            $tb_tipo_documento=Tb_tipo_documento::findOrFail($request->id);
            $tb_tipo_documento->estado='1';

            if ($tb_tipo_documento->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El tipo de documento ha sido activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El tipo de documento no fue activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}

