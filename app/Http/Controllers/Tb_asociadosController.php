<?php

namespace App\Http\Controllers;

use App\Models\Tb_asociados;
use App\Models\Tb_asociados_fincas;
use App\Models\Tb_familiares;
use App\Models\Tb_oferta;
use Illuminate\Http\Request;

class Tb_asociadosController extends Controller
{
    public function index(Request $request)
    {
        $asociado = Tb_asociados::orderBy('asociado','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'asociado' => $asociado
        ];
    }

    public function indexOne(Request $request)
    {
        $asociado = Tb_asociados::orderBy('asociado','desc')
        ->where('tb_asociados.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'asociado' => $asociado
        ];
    }

    public function indexOneDetalle(Request $request)
    {
        $asociado = Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->where('tb_asociados.id','=',$request->id)
        ->get();

        $produccion = Tb_asociados::join("tb_asociados_fincas","tb_asociados_fincas.asociado","=","tb_asociados.id")
        ->join("tb_fincas","tb_asociados_fincas.finca","=","tb_fincas.id")
        ->join("tb_veredas","tb_fincas.vereda","=","tb_veredas.id")
        ->join("tb_produccion","tb_asociados_fincas.id","=","tb_produccion.asociados_finca")
        ->join("tb_productos","tb_produccion.producto","=","tb_productos.id")
        ->select('tb_asociados.id as idAsociado','tb_fincas.nombre','tb_fincas.vereda','tb_fincas.extension','tb_produccion.id as idProduccion',
        'tb_produccion.produccion','tb_produccion.periodicidad','tb_produccion.medida','tb_produccion.estado as estadoProduccion',
        'tb_productos.id as idProducto','tb_productos.producto','tb_productos.imagenProducto')
        ->where('tb_asociados.id','=',$request->id)
        ->get();

        $familiares = Tb_familiares::join("tb_personas","tb_familiares.persona","=","tb_personas.id")
        ->where('tb_familiares.asociado','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'asociado' => $asociado,
            'familiares' => $familiares,
            'produccion' => $produccion
        ];
    }

    public function indexOneOfertas(Request $request)
    {
        $asociado = Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->where('tb_asociados.id','=',$request->id)
        ->get();

        $tb_asociados_finca=Tb_asociados_fincas::where("tb_asociados_fincas.asociado","=",$request->id)
        ->select("tb_asociados_fincas.id")
        ->first();

        $produccion = Tb_asociados_fincas::join("tb_produccion","tb_produccion.asociados_finca","=","tb_asociados_fincas.id")
        ->join("tb_productos","tb_produccion.producto","=","tb_productos.id")
        ->where('tb_asociados_fincas.id','=',$tb_asociados_finca->id)
        ->select("tb_produccion.id","tb_produccion.produccion","tb_productos.producto","tb_productos.imagenProducto")
        ->get();

        $produccionActiva = Tb_oferta::join("tb_productos","tb_ofertas.product_id","=","tb_productos.id")
        ->where('tb_ofertas.asociados_finca_id','=',$tb_asociados_finca->id)
        ->where('tb_ofertas.estado','=',1)
        ->select("tb_ofertas.id","tb_ofertas.imagenProducto","tb_ofertas.start_date","tb_ofertas.end_date","tb_ofertas.estado",
        "tb_ofertas.contacto_visible","tb_ofertas.cantidad","tb_ofertas.product_id","tb_ofertas.asociados_finca_id",
        "tb_ofertas.medida_unidades_id","tb_productos.producto")
        ->get();

        $produccionInactiva = Tb_oferta::join("tb_productos","tb_ofertas.product_id","=","tb_productos.id")
        ->where('tb_ofertas.asociados_finca_id','=',$tb_asociados_finca->id)
        ->where('tb_ofertas.estado','=',0)
        ->select("tb_ofertas.id","tb_ofertas.imagenProducto","tb_ofertas.start_date","tb_ofertas.end_date","tb_ofertas.estado",
        "tb_ofertas.contacto_visible","tb_ofertas.cantidad","tb_ofertas.product_id","tb_ofertas.asociados_finca_id",
        "tb_ofertas.medida_unidades_id","tb_productos.producto")
        ->orderBy('tb_ofertas.end_date',"DESC")
        ->get();


        return [
            'estado' => 'Ok',
            'asociado' => $asociado,
            'asociados_finca' => $tb_asociados_finca,
            'produccion' => $produccion,
            'ofertasActivas' => $produccionActiva,
            'ofertasInactivas' => $produccionInactiva
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_asociados=new Tb_asociados();
            $tb_asociados->persona=$request->persona;
            $tb_asociados->categoria=$request->categoria;
            $tb_asociados->estado=1;

            if ($tb_asociados->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El asociado ha sido creado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El asociado no fue creado'
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
            $tb_asociados=Tb_asociados::findOrFail($request->id);
            $tb_asociados->persona=$request->persona;
            $tb_asociados->categoria=$request->categoria;
            $tb_asociados->estado='1';

            if ($tb_asociados->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El asociado se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El asociado no fue actualizado'
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
            $tb_asociados=Tb_asociados::findOrFail($request->id);
            $tb_asociados->estado='0';

            if ($tb_asociados->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El asociado ha sido desactivado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El asociado no fue desactivado'
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
            $tb_asociados=Tb_asociados::findOrFail($request->id);
            $tb_asociados->estado='1';

            if ($tb_asociados->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'El asociado ha sido activado con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'El asociado no fue activado'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
