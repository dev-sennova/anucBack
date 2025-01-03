<?php

namespace App\Http\Controllers;

use App\Models\Tb_asociados;
use App\Models\Tb_asociados_fincas;
use App\Models\Tb_familiares;
use App\Models\Tb_oferta;
use App\Models\User;
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
        /*
        $idAsociado = User::first()
        ->join("tb_personas", "users.identificacion", "=", "tb_personas.identificacion")
        ->join("tb_asociados", "tb_asociados.persona", "=", "tb_personas.id")
        ->where('users.id', '=', $request->id)
        ->pluck("tb_asociados.id")
        ->first();
        */

        $asociado = Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->where('tb_asociados.id','=',$request->id)
        ->get();

        $permisos = Tb_asociados::join("tb_asociado_permisos","tb_asociados.id","=","tb_asociado_permisos.asociado")
        ->where('tb_asociados.id','=',$request->id)
        ->get();

        $finca = Tb_asociados::join("tb_asociados_fincas","tb_asociados_fincas.asociado","=","tb_asociados.id")
        ->join("tb_fincas","tb_asociados_fincas.finca","=","tb_fincas.id")
        ->join("tb_veredas","tb_fincas.vereda","=","tb_veredas.id")
        ->select('tb_asociados.id as idAsociado','tb_fincas.id as idFinca','tb_fincas.nombre','tb_fincas.extension','tb_fincas.vereda as idVereda',
        'tb_veredas.vereda as nombreVereda')
        ->where('tb_asociados.id','=',$request->id)
        ->get();

        $produccion = Tb_asociados::join("tb_asociados_fincas","tb_asociados_fincas.asociado","=","tb_asociados.id")
        ->join("tb_fincas","tb_asociados_fincas.finca","=","tb_fincas.id")
        ->join("tb_produccion","tb_asociados_fincas.id","=","tb_produccion.asociados_finca")
        ->join("tb_productos","tb_produccion.producto","=","tb_productos.id")
        ->select('tb_produccion.asociados_finca as idAsociado','tb_produccion.id as idProduccion','tb_produccion.produccion','tb_produccion.periodicidad',
        'tb_produccion.medida','tb_produccion.estado as estadoProduccion','tb_productos.id as idProducto','tb_productos.producto',
        'tb_productos.imagenProducto')
        ->where('tb_asociados_fincas.asociado','=',$request->id)
        ->get();

        $familiares = Tb_familiares::join("tb_personas","tb_familiares.persona","=","tb_personas.id")
        ->where('tb_familiares.asociado','=',$request->id)
        ->select('tb_personas.id','tb_personas.identificacion','tb_personas.nombres','tb_personas.apellidos','tb_personas.telefono',
        'tb_personas.correo','tb_personas.fecha_nacimiento', 'tb_personas.estado', 'tb_personas.tipo_documento', 'tb_personas.sexo',
        'tb_personas.estado_civil','tb_familiares.id as idFamiliar','tb_familiares.asociado','tb_familiares.parentesco','tb_familiares.persona')
        ->get();

        return [
            'estado' => 'Ok',
            'asociado' => $asociado,
            'permisos' => $permisos,
            'familiares' => $familiares,
            'finca' => $finca,
            'produccion' => $produccion
        ];
    }

    public function indexOneOfertas(Request $request)
    {
        $asociado = Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->where('tb_asociados.id','=',$request->id)
        ->get();

        $permisos = Tb_asociados::join("tb_asociado_permisos","tb_asociados.id","=","tb_asociado_permisos.asociado")
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
        "tb_ofertas.descripcion","tb_ofertas.precio","tb_ofertas.telefono_visible","tb_ofertas.telefono","tb_ofertas.whatsapp_visible",
        "tb_ofertas.whatsapp","tb_ofertas.correo_visible","tb_ofertas.correo","tb_ofertas.cantidad","tb_ofertas.product_id",
        "tb_ofertas.asociados_finca_id","tb_ofertas.medida_unidades_id","tb_productos.producto")
        ->get();


        $produccionInactiva = Tb_oferta::join("tb_productos","tb_ofertas.product_id","=","tb_productos.id")
        ->where('tb_ofertas.asociados_finca_id','=',$tb_asociados_finca->id)
        ->where('tb_ofertas.estado','=',0)
        ->select("tb_ofertas.id","tb_ofertas.imagenProducto","tb_ofertas.start_date","tb_ofertas.end_date","tb_ofertas.estado",
        "tb_ofertas.descripcion","tb_ofertas.precio","tb_ofertas.telefono_visible","tb_ofertas.telefono","tb_ofertas.whatsapp_visible",
        "tb_ofertas.whatsapp","tb_ofertas.correo_visible","tb_ofertas.correo","tb_ofertas.cantidad","tb_ofertas.product_id",
        "tb_ofertas.asociados_finca_id","tb_ofertas.medida_unidades_id","tb_productos.producto")
        ->orderBy('tb_ofertas.end_date',"DESC")
        ->get();


        return [
            'estado' => 'Ok',
            'asociado' => $asociado,
            'permisos' => $permisos,
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
            $tb_asociados->fotoAsociado = $request->fotoAsociado; // Guardar la imagen en base64
            $tb_asociados->persona=$request->persona;
            $tb_asociados->categoria=$request->categoria;
            $tb_asociados->habeasData=$request->habeasData;
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
            $tb_asociados->fotoAsociado = $request->fotoAsociado; // Guardar la imagen en base64
            $tb_asociados->persona=$request->persona;
            $tb_asociados->categoria=$request->categoria;
            $tb_asociados->habeasData=$request->habeasData;
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

    public function updatePassword(Request $request){
        try {
            $user=User::findOrFail($request->id);
            $user->password=bcrypt($request->password);

            if ($user->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'La password se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La password no fue actualizado'
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

    public function indexAllDetalle()
    {
        $listaasociados = Tb_asociados::get();

        $resultado=[];

        foreach ($listaasociados as $global) {

            $idAsociadoGlobal = $global->id;

            $asociado = Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
            ->where('tb_asociados.id','=',$idAsociadoGlobal)
            ->select('tb_asociados.id as idAsociado','tb_personas.id as idPersona','tb_personas.identificacion','tb_personas.nombres',
            'tb_personas.apellidos')
            ->get();

            $produccion = Tb_asociados::join("tb_asociados_fincas","tb_asociados_fincas.asociado","=","tb_asociados.id")
            ->join("tb_fincas","tb_asociados_fincas.finca","=","tb_fincas.id")
            ->join("tb_veredas","tb_fincas.vereda","=","tb_veredas.id")
            ->join("tb_produccion","tb_asociados_fincas.id","=","tb_produccion.asociados_finca")
            ->join("tb_productos","tb_produccion.producto","=","tb_productos.id")
            ->select('tb_fincas.id as idFinca','tb_fincas.nombre','tb_produccion.id as idProduccion','tb_productos.id as idProducto',
            'tb_productos.producto')
            ->where('tb_asociados.id','=',$idAsociadoGlobal)
            ->get();

            $familiares = Tb_familiares::join("tb_personas","tb_familiares.persona","=","tb_personas.id")
            ->where('tb_familiares.asociado','=',$idAsociadoGlobal)
            ->select('tb_personas.id as idPersona','tb_personas.identificacion','tb_personas.nombres','tb_personas.apellidos',
            'tb_familiares.id as idFamiliar','tb_familiares.parentesco')
            ->get();

            $resultado[] = [
                'asociado' => $asociado,
                'familiares' => $familiares,
                'produccion' => $produccion
            ];
        }


        return [
            'estado' => 'Ok',
            'resultados' => $resultado
        ];
    }

    public function indexFamiliaresDetalle(Request $request)
    {
        $familiares = Tb_familiares::join("tb_personas","tb_familiares.persona","=","tb_personas.id")
        ->where('tb_familiares.asociado','=',$request->id)
        ->select('tb_personas.identificacion','tb_personas.nombres','tb_personas.apellidos','tb_personas.telefono',
        'tb_personas.correo','tb_personas.fecha_nacimiento', 'tb_familiares.estado', 'tb_personas.tipo_documento', 'tb_personas.sexo',
        'tb_personas.estado_civil','tb_familiares.id as idFamiliar','tb_familiares.asociado','tb_familiares.parentesco','tb_familiares.persona')
        ->get();

        return [
            'estado' => 'Ok',
            'familiares' => $familiares
        ];
    }

    public function indexOneContacto(Request $request)
    {
        $permisos = Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->join("tb_asociado_permisos","tb_asociados.id","=","tb_asociado_permisos.asociado")
        ->where('tb_asociados.id','=',$request->id)
        ->select('tb_personas.telefono','tb_personas.correo','tb_personas.whatsapp','tb_personas.facebook','tb_personas.instagram',
        'tb_asociado_permisos.telefono as permisoTelefono','tb_asociado_permisos.correo as permisoCorreo','tb_asociado_permisos.whatsapp as permisoWhatsapp',
        'tb_asociado_permisos.facebook as permisoFacebook','tb_asociado_permisos.instagram as permisoInstagram')
        ->get();

        return [
            'estado' => 'Ok',
            'permisos' => $permisos
        ];
    }

}
