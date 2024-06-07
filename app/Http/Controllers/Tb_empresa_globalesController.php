<?php

namespace App\Http\Controllers;

use App\Models\Tb_empresa_globales;
use Illuminate\Http\Request;

class Tb_empresa_globalesController extends Controller
{
    public function index(Request $request)
    {
        $empresa = Tb_empresa_globales::orderBy('nombre','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'empresa' => $empresa
        ];
    }

    public function indexOne(Request $request)
    {
        $empresa = Tb_empresa_globales::orderBy('nombre','desc')
        ->where('tb_empresa_globales.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'empresa' => $empresa
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_empresa_globales=new Tb_empresa_globales();
            $tb_empresa_globales->nombre=$request->nombre;
            $tb_empresa_globales->direccion=$request->direccion;
            $tb_empresa_globales->mision=$request->mision;
            $tb_empresa_globales->vision=$request->vision;
            $tb_empresa_globales->estado=1;

            if ($tb_empresa_globales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Empresa creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Empresa no pudo ser creada'
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
            $tb_empresa_globales=Tb_empresa_globales::findOrFail($request->id);
            $tb_empresa_globales=new Tb_empresa_globales();
            $tb_empresa_globales->nombre=$request->nombre;
            $tb_empresa_globales->direccion=$request->direccion;
            $tb_empresa_globales->mision=$request->mision;
            $tb_empresa_globales->vision=$request->vision;
            $tb_empresa_globales->estado=1;

            if ($tb_empresa_globales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Empresa actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Empresa no pudo ser actualizada'
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
            $Tb_empresa_globales=Tb_empresa_globales::findOrFail($request->id);
            $Tb_empresa_globales->estado='0';

            if ($Tb_empresa_globales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Empresa desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Empresa no pudo ser desactivada'
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
            $tb_empresa_globales=Tb_empresa_globales::findOrFail($request->id);
            $tb_empresa_globales->estado='1';

            if ($tb_empresa_globales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Empresa activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Empresa no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
