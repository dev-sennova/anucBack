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
                    'message' => 'Ciudad fue creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ciudad no pudo ser creada'
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
                    'message' => 'Ciudad se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ciudad no pudo ser actualizada'
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
                    'message' => 'Ciudad fue desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ciudad no pudo ser desactivada'
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
                    'message' => 'Ciudad fue activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ciudad no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
