<?php

namespace App\Http\Controllers;

use App\Models\Tb_medida_unidades;
use Illuminate\Http\Request;

class Tb_medida_unidadesController extends Controller
{
    public function index(Request $request)
    {
        $medida_unidades = Tb_medida_unidades::orderBy('medida_unidades','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'medida_unidades' => $medida_unidades
        ];
    }

    public function indexOne(Request $request)
    {
        $medida_unidades = Tb_medida_unidades::orderBy('medida_unidades','desc')
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
                    'message' => 'medida_unidades creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'medida_unidades no pudo ser creada'
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
                    'message' => 'medida_unidades actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'medida_unidades no pudo ser actualizada'
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
                    'message' => 'medida_unidades desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'medida_unidades no pudo ser desactivada'
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
                    'message' => 'medida_unidades activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'medida_unidades no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
