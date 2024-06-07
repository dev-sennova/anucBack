<?php

namespace App\Http\Controllers;

use App\Models\Tb_familiares;
use Illuminate\Http\Request;

class Tb_familiaresController extends Controller
{
    public function index(Request $request)
    {
        $familiares = Tb_familiares::orderBy('familiares','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'familiares' => $familiares
        ];
    }

    public function indexOne(Request $request)
    {
        $familiares = Tb_familiares::orderBy('familiares','desc')
        ->where('tb_familiares.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'familiares' => $familiares
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_familiares=new Tb_familiares();
            $tb_familiares->asociado=$request->asociado;
            $tb_familiares->persona=$request->persona;
            $tb_familiares->parentesco=$request->parentesco;
            $tb_familiares->estado=1;

            if ($tb_familiares->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'familiares creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'familiares no pudo ser creada'
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
            $tb_familiares=Tb_familiares::findOrFail($request->id);
            $tb_familiares->asociado=$request->asociado;
            $tb_familiares->persona=$request->persona;
            $tb_familiares->parentesco=$request->parentesco;
            $tb_familiares->estado='1';

            if ($tb_familiares->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'familiares actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'familiares no pudo ser actualizada'
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
            $tb_familiares=Tb_familiares::findOrFail($request->id);
            $tb_familiares->estado='0';

            if ($tb_familiares->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'familiares desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'familiares no pudo ser desactivada'
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
            $tb_familiares=Tb_familiares::findOrFail($request->id);
            $tb_familiares->estado='1';

            if ($tb_familiares->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'familiares activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'familiares no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
