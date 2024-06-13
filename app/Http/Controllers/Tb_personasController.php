<?php

namespace App\Http\Controllers;

use App\Models\Tb_personas;
use Illuminate\Http\Request;

class Tb_personasController extends Controller
{
    public function index(Request $request)
    {
        $personas = Tb_personas::orderByRaw('CONCAT(nombres, " ", apellidos) ASC')
        ->get();

        return [
            'estado' => 'Ok',
            'personas' => $personas
        ];
    }

    public function indexOne(Request $request)
    {
        $personas = Tb_personas::orderByRaw('CONCAT(nombres, " ", apellidos) ASC')
        ->where('tb_personas.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'personas' => $personas
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_personas=new Tb_personas();
            $tb_personas->identificacion=$request->identificacion;
            $tb_personas->nombres=$request->nombres;
            $tb_personas->apellidos=$request->apellidos;
            $tb_personas->telefono=$request->telefono;
            $tb_personas->fecha_nacimiento=$request->fecha_nacimiento;
            $tb_personas->tipo_documento=$request->tipo_documento;
            $tb_personas->sexo=$request->sexo;
            $tb_personas->estado_civil=$request->estado_civil;
            $tb_personas->estado=1;

            if ($tb_personas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'personas creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'personas no pudo ser creada'
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
            $tb_personas=Tb_personas::findOrFail($request->id);
            $tb_personas->identificacion=$request->identificacion;
            $tb_personas->nombres=$request->nombres;
            $tb_personas->apellidos=$request->apellidos;
            $tb_personas->telefono=$request->telefono;
            $tb_personas->fecha_nacimiento=$request->fecha_nacimiento;
            $tb_personas->tipo_documento=$request->tipo_documento;
            $tb_personas->sexo=$request->sexo;
            $tb_personas->estado_civil=$request->estado_civil;
            $tb_personas->estado='1';

            if ($tb_personas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'personas actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'personas no pudo ser actualizada'
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
            $tb_personas=Tb_personas::findOrFail($request->id);
            $tb_personas->estado='0';

            if ($tb_personas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'personas desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'personas no pudo ser desactivada'
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
            $tb_personas=Tb_personas::findOrFail($request->id);
            $tb_personas->estado='1';

            if ($tb_personas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'personas activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'personas no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
