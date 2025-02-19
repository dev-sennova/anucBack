<?php

namespace App\Http\Controllers;

use App\Models\Tb_parentesco;
use Illuminate\Http\Request;

class Tb_parentescosController extends Controller
{
    public function index(Request $request)
    {
        $parentesco = Tb_parentesco::orderBy('parentesco','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'parentesco' => $parentesco
        ];
    }

    public function indexOne(Request $request)
    {
        $parentesco = Tb_parentesco::orderBy('parentesco','desc')
        ->where('tb_parentescos.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'parentesco' => $parentesco
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_parentesco=new Tb_parentesco();
            $tb_parentesco->parentesco=$request->parentesco;
            $tb_parentesco->estado=1;

            if ($tb_parentesco->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El parentesco ha sido creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El parentesco no fue creado'
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
            $tb_parentesco=Tb_parentesco::findOrFail($request->id);
            $tb_parentesco->parentesco=$request->parentesco;
            $tb_parentesco->estado='1';

            if ($tb_parentesco->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El parentesco se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El parentesco no fue actualizado'
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
            $tb_parentesco=Tb_parentesco::findOrFail($request->id);
            $tb_parentesco->estado='0';

            if ($tb_parentesco->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El parentesco ha sido desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El parentesco no fue desactivado'
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
            $tb_parentesco=Tb_parentesco::findOrFail($request->id);
            $tb_parentesco->estado='1';

            if ($tb_parentesco->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El parentesco ha sido activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El parentesco no fue activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
