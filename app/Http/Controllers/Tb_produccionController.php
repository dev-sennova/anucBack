<?php

namespace App\Http\Controllers;

use App\Models\Tb_asociados;
use App\Models\Tb_produccion;
use Illuminate\Http\Request;

class Tb_produccionController extends Controller
{
    public function index(Request $request)
    {
        $produccion = Tb_produccion::orderBy('produccion','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'produccion' => $produccion
        ];
    }

    public function indexOne(Request $request)
    {
        $produccion = Tb_produccion::orderBy('produccion','desc')
        ->where('tb_produccion.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'produccion' => $produccion
        ];
    }

    public function indexByAsociado(Request $request)
    {
        $produccion = Tb_asociados::join("tb_asociados_fincas","tb_asociados_fincas.asociado","=","tb_asociados.id")
        ->join("tb_produccion","tb_asociados_fincas.id","=","tb_produccion.asociados_finca")
        ->join("tb_productos","tb_produccion.producto","=","tb_productos.id")
        ->select('tb_produccion.asociados_finca as idAsociado','tb_produccion.id as idProduccion','tb_produccion.produccion','tb_produccion.periodicidad',
        'tb_produccion.medida','tb_produccion.estado as estadoProduccion','tb_productos.id as idProducto','tb_productos.producto',
        'tb_productos.imagenProducto')
        ->where('tb_asociados.id','=',$request->id)
        ->where('tb_produccion.estado','=',1)
        ->get();

        return [
            'estado' => 'Ok',
            'produccion' => $produccion
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_produccion=new Tb_produccion();
            $tb_produccion->produccion=$request->produccion;
            $tb_produccion->producto=$request->producto;
            $tb_produccion->periodicidad=$request->periodicidad;
            $tb_produccion->medida=$request->medida;
            $tb_produccion->asociados_finca=$request->asociados_finca;
            $tb_produccion->estado=1;

            if ($tb_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'La produccion ha sido creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La produccion no fue creada'
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
            $tb_produccion=Tb_produccion::findOrFail($request->id);
            $tb_produccion->produccion=$request->produccion;
            $tb_produccion->producto=$request->producto;
            $tb_produccion->periodicidad=$request->periodicidad;
            $tb_produccion->medida=$request->medida;
            $tb_produccion->asociados_finca=$request->asociados_finca;
            $tb_produccion->estado='1';

            if ($tb_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'La produccion se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La produccion no fue actualizada'
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
            $tb_produccion=Tb_produccion::findOrFail($request->id);
            $tb_produccion->estado='0';

            if ($tb_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'La produccion ha sido desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La produccion no fue desactivada'
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
            $tb_produccion=Tb_produccion::findOrFail($request->id);
            $tb_produccion->estado='1';

            if ($tb_produccion->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'La produccion ha sido activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La produccion no fue activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
