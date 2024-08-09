<?php

namespace App\Http\Controllers;

use App\Models\Tb_ciudades;
use Illuminate\Http\Request;

class Tb_ciudadesController extends Controller
{
    public function index(Request $request)
    {
        $ciudad = Tb_ciudades::orderBy('ciudad','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'ciudad' => $ciudad
        ];
    }

    public function indexOne(Request $request)
    {
        $ciudad = Tb_ciudades::orderBy('ciudad','desc')
        ->where('tb_ciudades.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'ciudad' => $ciudad
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_ciudades=new Tb_ciudades();
            $tb_ciudades->ciudad=$request->ciudad;
            $tb_ciudades->estado=1;

            if ($tb_ciudades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'La ciudad ha sido creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La ciudad no fue creada'
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
            $tb_ciudades=Tb_ciudades::findOrFail($request->id);
            $tb_ciudades->ciudad=$request->ciudad;
            $tb_ciudades->estado='1';

            if ($tb_ciudades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'La ciudad se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La ciudad no fue actualizada'
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
            $tb_ciudades=Tb_ciudades::findOrFail($request->id);
            $tb_ciudades->estado='0';

            if ($tb_ciudades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'La ciudad ha sido desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La ciudad no fue desactivada'
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
            $tb_ciudades=Tb_ciudades::findOrFail($request->id);
            $tb_ciudades->estado='1';

            if ($tb_ciudades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'La ciudad ha sido activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La ciudad no fue activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
