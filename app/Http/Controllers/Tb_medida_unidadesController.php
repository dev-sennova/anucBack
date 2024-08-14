<?php

namespace App\Http\Controllers;

use App\Models\Tb_medida_unidades;
use Illuminate\Http\Request;

class Tb_medida_unidadesController extends Controller
{
    public function index(Request $request)
    {
        $medida_unidades = Tb_medida_unidades::orderBy('unidad','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'medida_unidades' => $medida_unidades
        ];
    }

    public function indexOne(Request $request)
    {
        $medida_unidades = Tb_medida_unidades::orderBy('unidad','desc')
        ->where('tb_medida_unidades.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'medida_unidades' => $medida_unidades
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_medida_unidades=new Tb_medida_unidades();
            $tb_medida_unidades->unidad=$request->unidad;
            $tb_medida_unidades->estado=1;

            if ($tb_medida_unidades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Las medidas de unidades han sido creadas con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Las medidas de unidades no fueron ser creadas'
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
            $tb_medida_unidades=Tb_medida_unidades::findOrFail($request->id);
            $tb_medida_unidades->unidad=$request->unidad;
            $tb_medida_unidades->estado='1';

            if ($tb_medida_unidades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Las medidas de unidades se actualizaron con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Las medidas de unidades no fueron actualizadas'
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
            $tb_medida_unidades=Tb_medida_unidades::findOrFail($request->id);
            $tb_medida_unidades->estado='0';

            if ($tb_medida_unidades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Las medidas de unidades han sido desactivadas con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Las medidas de unidades no fueron desactivadas'
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
            $tb_medida_unidades=Tb_medida_unidades::findOrFail($request->id);
            $tb_medida_unidades->estado='1';

            if ($tb_medida_unidades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Las medidas de unidades han sido activadas con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Las medidas de unidades no fueron activadas'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
