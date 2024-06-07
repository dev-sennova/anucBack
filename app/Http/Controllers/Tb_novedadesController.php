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
                    'message' => 'novedades creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'novedades no pudo ser creada'
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
                    'message' => 'novedades actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'novedades no pudo ser actualizada'
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
                    'message' => 'novedades desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'novedades no pudo ser desactivada'
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
                    'message' => 'novedades activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'novedades no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
