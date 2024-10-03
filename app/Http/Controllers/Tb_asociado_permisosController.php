<?php

namespace App\Http\Controllers;

use App\Models\Tb_asociado_permisos;
use Illuminate\Http\Request;

class Tb_asociado_permisosController extends Controller
{
    public function index(Request $request)
    {
        $asociado_permisos = Tb_asociado_permisos::orderBy('id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'asociado_permisos' => $asociado_permisos
        ];
    }

    public function indexOne(Request $request)
    {
        $asociado_permisos = Tb_asociado_permisos::orderBy('id','desc')
        ->where('tb_asociado_permisos.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'asociado_permisos' => $asociado_permisos
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $asociado_permisos=new Tb_asociado_permisos();
            $asociado_permisos->asociado=$request->asociado;
            $asociado_permisos->correo=$request->correo;
            $asociado_permisos->telefono=$request->telefono;
            $asociado_permisos->whatsapp=$request->whatsapp;
            $asociado_permisos->facebook=$request->facebook;
            $asociado_permisos->instagram=$request->instagram;

            if ($asociado_permisos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Los permisos han sido creados con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Los permisos no fueron creados'
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
            $asociado_permisos=Tb_asociado_permisos::findOrFail($request->id);
            $asociado_permisos->correo=$request->correo;
            $asociado_permisos->telefono=$request->telefono;
            $asociado_permisos->whatsapp=$request->whatsapp;
            $asociado_permisos->facebook=$request->facebook;
            $asociado_permisos->instagram=$request->instagram;

            if ($asociado_permisos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Los permisos se actualizaron con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Los permisos no fueron actualizados'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
