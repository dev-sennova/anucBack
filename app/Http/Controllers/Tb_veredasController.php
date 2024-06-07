<?php

namespace App\Http\Controllers;

use App\Models\Tb_veredas;
use Illuminate\Http\Request;

class Tb_veredasController extends Controller
{
    public function index(Request $request)
    {
        $veredas = Tb_veredas::orderBy('veredas','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'veredas' => $veredas
        ];
    }

    public function indexOne(Request $request)
    {
        $veredas = Tb_veredas::orderBy('veredas','desc')
        ->where('tb_veredas.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'veredas' => $veredas
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_veredas=new Tb_veredas();
            $tb_veredas->vereda=$request->vereda;
            $tb_veredas->ciudad=$request->ciudad;
            $tb_veredas->estado=1;

            if ($tb_veredas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'veredas creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'veredas no pudo ser creada'
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
            $tb_veredas=Tb_veredas::findOrFail($request->id);
            $tb_veredas->vereda=$request->vereda;
            $tb_veredas->ciudad=$request->ciudad;
            $tb_veredas->estado='1';

            if ($tb_veredas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'veredas actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'veredas no pudo ser actualizada'
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
            $tb_veredas=Tb_veredas::findOrFail($request->id);
            $tb_veredas->estado='0';

            if ($tb_veredas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'veredas desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'veredas no pudo ser desactivada'
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
            $tb_veredas=Tb_veredas::findOrFail($request->id);
            $tb_veredas->estado='1';

            if ($tb_veredas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'veredas activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'veredas no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
