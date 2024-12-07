<?php

namespace App\Http\Controllers;

use App\Models\Tb_grupos;
use Illuminate\Http\Request;

class Tb_gruposController extends Controller
{
    public function index(Request $request)
    {
        $grupo = Tb_grupos::orderBy('grupo','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'grupos' => $grupo
        ];
    }

    public function indexOne(Request $request)
    {
        $grupo = Tb_grupos::orderBy('grupo','desc')
        ->where('Tb_grupos.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'grupo' => $grupo
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_grupos=new Tb_grupos();
            $tb_grupos->grupo=$request->grupo;
            $tb_grupos->descripcion=$request->descripcion;
            $tb_grupos->estado=1;

            if ($tb_grupos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El grupo ha sido creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El grupo no fue creado'
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
            $tb_grupos=Tb_grupos::findOrFail($request->id);
            $tb_grupos->grupo=$request->grupo;
            $tb_grupos->descripcion=$request->descripcion;
            $tb_grupos->estado='1';

            if ($tb_grupos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El grupo se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El grupo no fue actualizado'
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
            $tb_grupos=Tb_grupos::findOrFail($request->id);
            $tb_grupos->estado='0';

            if ($tb_grupos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El grupo ha sido desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El grupo no fue desactivado'
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
            $tb_grupos=Tb_grupos::findOrFail($request->id);
            $tb_grupos->estado='1';

            if ($tb_grupos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El grupo ha sido activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El grupo no fue activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
