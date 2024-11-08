<?php

namespace App\Http\Controllers;

use App\Models\Tb_hoja_de_costos;
use Illuminate\Http\Request;

class Tb_hoja_de_costosController extends Controller
{
    public function index(Request $request)
    {
        $hoja_de_costos = Tb_hoja_de_costos::orderBy('id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'hoja_de_costos' => $hoja_de_costos
        ];
    }

    public function indexOne(Request $request)
    {
        $hoja_de_costos = Tb_hoja_de_costos::orderBy('id','desc')
        ->where('tb_hoja_de_costos.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'hoja_de_costos' => $hoja_de_costos
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_hoja_de_costos=new Tb_hoja_de_costos();
            $tb_hoja_de_costos->idProducto=$request->idProducto;
            $tb_hoja_de_costos->idAsociado=$request->idAsociado;
            $tb_hoja_de_costos->fecha=$request->fecha;
            $tb_hoja_de_costos->estado=1;

            if ($tb_hoja_de_costos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Hoja de costos ha sido creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Hoja de costos no fue creada'
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
            $tb_hoja_de_costos=Tb_hoja_de_costos::findOrFail($request->id);
            $tb_hoja_de_costos->idProducto=$request->idProducto;
            $tb_hoja_de_costos->idAsociado=$request->idAsociado;
            $tb_hoja_de_costos->fecha=$request->fecha;
            $tb_hoja_de_costos->estado='1';

            if ($tb_hoja_de_costos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'hoja_de_costos se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Hoja de costos no fue actualizada'
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
            $tb_hoja_de_costos=Tb_hoja_de_costos::findOrFail($request->id);
            $tb_hoja_de_costos->estado='0';

            if ($tb_hoja_de_costos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Hoja de costos ha sido desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Hoja de costos no fue desactivada'
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
            $tb_hoja_de_costos=Tb_hoja_de_costos::findOrFail($request->id);
            $tb_hoja_de_costos->estado='1';

            if ($tb_hoja_de_costos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Hoja de costos ha sido activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Hoja de costos no fue activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
