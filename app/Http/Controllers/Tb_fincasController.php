<?php

namespace App\Http\Controllers;

use App\Models\Tb_fincas;
use Illuminate\Http\Request;

class Tb_fincasController extends Controller
{
    public function index(Request $request)
    {
        $finca = Tb_fincas::orderBy('nombre','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'finca' => $finca
        ];
    }

    public function indexOne(Request $request)
    {
        $finca = Tb_fincas::orderBy('nombre','desc')
        ->where('tb_fincas.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'finca' => $finca
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_fincas=new Tb_fincas();
            $tb_fincas->nombre=$request->nombre;
            $tb_fincas->extension=$request->extension;
            $tb_fincas->latitud=$request->latitud;
            $tb_fincas->longitud=$request->longitud;
            $tb_fincas->vereda=$request->vereda;
            $tb_fincas->estado=1;

            if ($tb_fincas->save()) {
                $idFinca = $tb_fincas->id;
                return response()->json([
                    'estado' => 'Ok',
                    'id' => $idFinca,
                    'message' => 'La finca ha sido creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La finca no fue creada'
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
            $tb_fincas=Tb_fincas::findOrFail($request->id);
            $tb_fincas->nombre=$request->nombre;
            $tb_fincas->extension=$request->extension;
            $tb_fincas->latitud=$request->latitud;
            $tb_fincas->longitud=$request->longitud;
            $tb_fincas->vereda=$request->vereda;
            $tb_fincas->estado='1';

            if ($tb_fincas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'La finca se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La finca no fue actualizada'
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
            $tb_fincas=Tb_fincas::findOrFail($request->id);
            $tb_fincas->estado='0';

            if ($tb_fincas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'La finca ha sido desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La finca no fue desactivada'
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
            $tb_fincas=Tb_fincas::findOrFail($request->id);
            $tb_fincas->estado='1';

            if ($tb_fincas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'La finca ha sido activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La finca no fue activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
