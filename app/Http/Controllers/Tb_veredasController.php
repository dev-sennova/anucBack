<?php

namespace App\Http\Controllers;

use App\Models\Tb_veredas;
use Illuminate\Http\Request;

class Tb_veredasController extends Controller
{
    public function index(Request $request)
    {
        $veredas = Tb_veredas::orderBy('vereda','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'veredas' => $veredas
        ];
    }

    public function indexOne(Request $request)
    {
        $veredas = Tb_veredas::orderBy('vereda','desc')
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
                    'message' => 'Veredas fueron creadas con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Veredas no pudieron ser creadas'
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
                    'message' => 'Veredas se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Veredas no pudieron ser actualizadas'
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
                    'message' => 'Veredas fueron desactivadas con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Veredas no pudieron ser desactivadas'
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
                    'message' => 'Veredas fueron activadas con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Veredas no pudieron ser activadas'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
