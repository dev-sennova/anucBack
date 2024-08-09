<?php

namespace App\Http\Controllers;

use App\Models\Tb_novedades;
use Illuminate\Http\Request;

class Tb_novedadesController extends Controller
{
    public function index(Request $request)
    {
        $novedades = Tb_novedades::orderBy('novedades','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'novedades' => $novedades
        ];
    }

    public function indexOne(Request $request)
    {
        $novedades = Tb_novedades::orderBy('novedades','desc')
        ->where('tb_novedades.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'novedades' => $novedades
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_novedades=new Tb_novedades();
            $tb_novedades->novedad=$request->novedad;
            $tb_novedades->asociado=$request->asociado;
            $tb_novedades->estado=1;

            if ($tb_novedades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Las novedades han sido creadas con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Las novedades no fueron creadas'
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
            $tb_novedades=Tb_novedades::findOrFail($request->id);
            $tb_novedades->novedad=$request->novedad;
            $tb_novedades->asociado=$request->asociado;
            $tb_novedades->estado='1';

            if ($tb_novedades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Las novedades se actualizaron con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Las novedades no fueron actualizadas'
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
            $tb_novedades=Tb_novedades::findOrFail($request->id);
            $tb_novedades->estado='0';

            if ($tb_novedades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Las novedades han sido desactivadas con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Las novedades no fueron desactivadas'
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
            $tb_novedades=Tb_novedades::findOrFail($request->id);
            $tb_novedades->estado='1';

            if ($tb_novedades->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Las novedades han sido activadas con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Las novedades no fueron activadas'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
