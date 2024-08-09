<?php

namespace App\Http\Controllers;

use App\Models\Tb_asociados;
use App\Models\Tb_empresa_globales;
use App\Models\Tb_asociados_fincas;
use App\Models\Tb_medida_unidades;
use App\Models\Tb_periodicidad;
use App\Models\Tb_produccion;
use App\Models\Tb_producto_categorias;
use App\Models\Tb_productos;
use App\Models\Tb_tipo_predio;
use App\Models\Tb_veredas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $tb_empresa_globales->nit=$request->nit;
            $tb_empresa_globales->horarios=$request->horarios;
            $tb_empresa_globales->mision=$request->mision;
            $tb_empresa_globales->vision=$request->vision;
            $tb_empresa_globales->estado=1;

            if ($tb_empresa_globales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'La empresa ha sido creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La empresa no fue creada'
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
            $tb_empresa_globales->nit=$request->nit;
            $tb_empresa_globales->horarios=$request->horarios;
            $tb_empresa_globales->mision=$request->mision;
            $tb_empresa_globales->vision=$request->vision;
            $tb_empresa_globales->estado=1;

            if ($tb_empresa_globales->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'La empresa se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La empresa no fue actualizada'
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
                    'message' => 'La empresa ha sido desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La empresa no fue desactivada'
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
                    'message' => 'La empresa ha sido activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La empresa no fue activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function estadisticas()
    {

        #-------------------------------------------------------------------------#
        #Consulta total de asociados activos
        $cantidad_asociados= Tb_asociados::where('tb_asociados.estado','=','1')->count();

        #Bloque de consulta por sexo
        $cantidad_masculinos= Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->join("tb_sexo","tb_personas.sexo","=","tb_sexo.id")
        ->where('tb_asociados.estado','=','1')
        ->where('tb_sexo.id','=','1')->count();
        $cantidad_femeninos= Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->join("tb_sexo","tb_personas.sexo","=","tb_sexo.id")
        ->where('tb_asociados.estado','=','1')
        ->where('tb_sexo.id','=','2')->count();
        $cantidad_otro_sexo= Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->join("tb_sexo","tb_personas.sexo","=","tb_sexo.id")
        ->where('tb_asociados.estado','=','1')
        ->where('tb_sexo.id','=','3')->count();
        $porcentaje_masculino=round((intval($cantidad_masculinos)/intval($cantidad_asociados))*100, 2);
        $porcentaje_femenino=round((intval($cantidad_femeninos)/intval($cantidad_asociados))*100, 2);
        $porcentaje_otro_sexo=round((intval($cantidad_otro_sexo)/intval($cantidad_asociados))*100, 2);


        #-------------------------------------------------------------------------#
        #Bloque de consulta por rango de edad
        $esteY = date('Y');

        $min40=intval($esteY)-1950;
        $max40=intval($esteY)-1940;
        $from40 = date('1940-01-01');
        $to50 = date('1949-12-31');

        $entre40y50=Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->where('tb_asociados.estado','=','1')
        ->whereBetween('tb_personas.fecha_nacimiento',[$from40, $to50])->count();

        $min50=intval($esteY)-1960;
        $max50=intval($esteY)-1950;
        $from50 = date('1950-01-01');
        $to60 = date('1959-12-31');

        $entre50y60=Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->where('tb_asociados.estado','=','1')
        ->whereBetween('tb_personas.fecha_nacimiento',[$from50, $to60])->count();

        $min60=intval($esteY)-1970;
        $max60=intval($esteY)-1960;
        $from60 = date('1960-01-01');
        $to70 = date('1969-12-31');

        $entre60y70=Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->where('tb_asociados.estado','=','1')
        ->whereBetween('tb_personas.fecha_nacimiento',[$from60, $to70])->count();

        $min70=intval($esteY)-1980;
        $max70=intval($esteY)-1970;
        $from70 = date('1970-01-01');
        $to80 = date('1979-12-31');

        $entre70y80=Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->where('tb_asociados.estado','=','1')
        ->whereBetween('tb_personas.fecha_nacimiento',[$from70, $to80])->count();

        $min80=intval($esteY)-1990;
        $max80=intval($esteY)-1980;
        $from80 = date('1980-01-01');
        $to90 = date('1989-12-31');

        $entre80y90=Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->where('tb_asociados.estado','=','1')
        ->whereBetween('tb_personas.fecha_nacimiento',[$from80, $to90])->count();

        $min90=intval($esteY)-2000;
        $max90=intval($esteY)-1990;
        $from90 = date('1990-01-01');
        $to00 = date('1999-12-31');

        $entre90y00=Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->where('tb_asociados.estado','=','1')
        ->whereBetween('tb_personas.fecha_nacimiento',[$from90, $to00])->count();

        $min00=intval($esteY)-2010;
        $max00=intval($esteY)-2000;
        $from00 = date('2000-01-01');
        $to10 = date('2009-12-31');

        $entre00y10=Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->where('tb_asociados.estado','=','1')
        ->whereBetween('tb_personas.fecha_nacimiento',[$from00, $to10])->count();

        $fecha_nsnr=Tb_asociados::join("tb_personas","tb_asociados.persona","=","tb_personas.id")
        ->where('tb_asociados.estado','=','1')
        ->where('tb_personas.fecha_nacimiento','=','1901-01-01')->count();


        #-------------------------------------------------------------------------#
        #Consulta por veredas
        $veredas_registradas = Tb_veredas::orderBy('vereda','asc')->get();

        $datos_vereda = [];

        foreach($veredas_registradas as $vereda){
            $id_vereda = $vereda->id;
            $nombre_vereda = $vereda->vereda;

            $total_por_veredas = Tb_asociados::join("tb_asociados_fincas","tb_asociados_fincas.asociado","=","tb_asociados.id")
            ->join("tb_fincas","tb_asociados_fincas.finca","=","tb_fincas.id")
            ->join("tb_veredas","tb_fincas.vereda","=","tb_veredas.id")
            ->where('tb_asociados.estado','=','1')
            ->where('tb_fincas.vereda','=',$id_vereda)
            ->count();

            $porcentaje_vereda = round((intval($total_por_veredas)/intval($cantidad_asociados))*100, 2);

            $datos_vereda[] = [
                'vereda' => $nombre_vereda,
                'cantidad_por_vereda' => $total_por_veredas,
                'porcentaje' => $porcentaje_vereda
            ];
        }

        #-------------------------------------------------------------------------#
        # Consulta para contar las fincas por rango de extensión
        $conteos = DB::table('tb_fincas')
            ->select(
                DB::raw("
                    SUM(CASE WHEN extension = 0 THEN 1 ELSE 0 END) as 'NSNR',
                    SUM(CASE WHEN extension > 0 AND extension < 1 THEN 1 ELSE 0 END) as 'MENOS DE 1',
                    SUM(CASE WHEN extension >= 1 AND extension < 2 THEN 1 ELSE 0 END) as 'ENTRE 1 Y 2',
                    SUM(CASE WHEN extension >= 2 AND extension < 3 THEN 1 ELSE 0 END) as 'ENTRE 2 Y 3',
                    SUM(CASE WHEN extension >= 3 AND extension < 4 THEN 1 ELSE 0 END) as 'ENTRE 3 Y 4',
                    SUM(CASE WHEN extension >= 4 AND extension < 5 THEN 1 ELSE 0 END) as 'ENTRE 4 Y 5',
                    SUM(CASE WHEN extension >= 5 AND extension < 6 THEN 1 ELSE 0 END) as 'ENTRE 5 Y 6',
                    SUM(CASE WHEN extension >= 6 AND extension < 7 THEN 1 ELSE 0 END) as 'ENTRE 6 Y 7',
                    SUM(CASE WHEN extension >= 7 AND extension < 8 THEN 1 ELSE 0 END) as 'ENTRE 7 Y 8',
                    SUM(CASE WHEN extension >= 8 AND extension < 9 THEN 1 ELSE 0 END) as 'ENTRE 8 Y 9',
                    SUM(CASE WHEN extension >= 9 AND extension < 10 THEN 1 ELSE 0 END) as 'ENTRE 9 Y 10',
                    SUM(CASE WHEN extension >= 10 THEN 1 ELSE 0 END) as 'MÁS DE 10'
                ")
            )
            ->first();
        // Formatear el resultado como un array asociativo
        $fincas_por_hectareas = [
            'NSNR' => $conteos->{'NSNR'},
            'MENOS DE 1' => $conteos->{'MENOS DE 1'},
            'ENTRE 1 Y 2' => $conteos->{'ENTRE 1 Y 2'},
            'ENTRE 2 Y 3' => $conteos->{'ENTRE 2 Y 3'},
            'ENTRE 3 Y 4' => $conteos->{'ENTRE 3 Y 4'},
            'ENTRE 4 Y 5' => $conteos->{'ENTRE 4 Y 5'},
            'ENTRE 5 Y 6' => $conteos->{'ENTRE 5 Y 6'},
            'ENTRE 6 Y 7' => $conteos->{'ENTRE 6 Y 7'},
            'ENTRE 7 Y 8' => $conteos->{'ENTRE 7 Y 8'},
            'ENTRE 8 Y 9' => $conteos->{'ENTRE 8 Y 9'},
            'ENTRE 9 Y 10' => $conteos->{'ENTRE 9 Y 10'},
            'MÁS DE 10' => $conteos->{'MÁS DE 10'}
        ];

        #-------------------------------------------------------------------------#
        #Consulta por tipo de predio
        #Consulta total de asociados_fincas activos
        $cantidad_asociados_fincas= Tb_asociados::join("tb_asociados_fincas","tb_asociados_fincas.asociado","=","tb_asociados.id")
        ->join("tb_tipo_predios","tb_asociados_fincas.tipo_predio","=","tb_tipo_predios.id")
        ->where('tb_asociados.estado','=','1')
        ->count();

        $tipos_predios = Tb_tipo_predio::orderBy('tipo_predio','asc')->get();

        $datos_tipos_predio = [];

        foreach($tipos_predios as $predio){
            $id_tipo_predio = $predio->id;
            $tipo_predio = $predio->tipo_predio;

            $total_por_tipos = Tb_asociados::join("tb_asociados_fincas","tb_asociados_fincas.asociado","=","tb_asociados.id")
            ->join("tb_tipo_predios","tb_asociados_fincas.tipo_predio","=","tb_tipo_predios.id")
            ->where('tb_asociados.estado','=','1')
            ->where('tb_asociados_fincas.tipo_predio','=',$id_tipo_predio)
            ->count();

            $porcentaje_tipo_predio = round((intval($total_por_tipos)/intval($cantidad_asociados_fincas))*100, 2);

            $datos_tipos_predio[] = [
                'tipo_predio' => $tipo_predio,
                'cantidad_por_vereda' => $total_por_tipos,
                'porcentaje' => $porcentaje_tipo_predio
            ];
        }

        #-------------------------------------------------------------------------#

        #-------------------------------------------------------------------------#
        #Consulta por categorias
        #Consulta total de asociados_fincas activos
        $cantidad_producciones= Tb_produccion::join("tb_asociados_fincas","tb_produccion.asociados_finca","=","tb_asociados_fincas.id")
        ->join("tb_asociados","tb_asociados_fincas.asociado","=","tb_asociados.id")
        ->where('tb_asociados.estado','=','1')
        ->count();

        $categorias_productos = Tb_producto_categorias::orderBy('categoria','asc')->get();

        $datos_categorias_productos = [];

        foreach($categorias_productos as $categoria){
            $id_categoria = $categoria->id;
            $nombre_categoria = $categoria->categoria;

            //Valor cantidad total de registros por categoria, debe coincidir para detalle_productos, detalle_periodicidad y detalle_unidad_medida
            $total_por_categorias_productos = Tb_asociados::join("tb_asociados_fincas","tb_asociados_fincas.asociado","=","tb_asociados.id")
            ->join("tb_produccion","tb_asociados_fincas.id","=","tb_produccion.asociados_finca")
            ->join("tb_productos","tb_produccion.producto","=","tb_productos.id")
            ->join("tb_producto_categorias","tb_productos.categoria","=","tb_producto_categorias.id")
            ->where('tb_asociados.estado','=','1')
            ->where('tb_producto_categorias.id','=',$id_categoria)
            ->count();

            $porcentaje_categorias_productos = round((intval($total_por_categorias_productos)/intval($cantidad_producciones))*100, 2);

            //abro bloque unidad por categoria
            $detalles_unidad_medida  = [];

            $unidades = Tb_medida_unidades::orderBy('unidad', 'ASC')->get();

            foreach($unidades as $unidad){
                $id_unidades = $unidad->id;
                $nombre_unidades = $unidad->unidad;

                $total_por_categorias_unidades = Tb_asociados::join("tb_asociados_fincas","tb_asociados_fincas.asociado","=","tb_asociados.id")
                ->join("tb_produccion","tb_asociados_fincas.id","=","tb_produccion.asociados_finca")
                ->join("tb_productos","tb_produccion.producto","=","tb_productos.id")
                ->join("tb_producto_categorias","tb_productos.categoria","=","tb_producto_categorias.id")
                ->where('tb_asociados.estado','=','1')
                ->where('tb_productos.categoria','=',$id_categoria)
                ->where('tb_produccion.medida','=',$id_unidades)
                ->count();

                $porcentaje_productos_unidades = round((intval($total_por_categorias_unidades)/intval($total_por_categorias_productos))*100, 2);

                $detalles_unidad_medida[] = [
                    'unidad_medida' => $nombre_unidades,
                    'cantidad_por_fincas' => $total_por_categorias_unidades,
                    'porcentaje' => $porcentaje_productos_unidades
                ];
            }
            //cierro bloque unidad por categoria

            //abro bloque periodicidad por categoria
            $detalles_periodicidad  = [];

            $periodicidades = Tb_periodicidad::orderBy('periodicidad', 'ASC')->get();

            foreach($periodicidades as $periodicidad){
                $id_periodicidad = $periodicidad->id;
                $nombre_periodicidad = $periodicidad->periodicidad;

                $total_por_categorias_periodicidad = Tb_asociados::join("tb_asociados_fincas","tb_asociados_fincas.asociado","=","tb_asociados.id")
                ->join("tb_produccion","tb_asociados_fincas.id","=","tb_produccion.asociados_finca")
                ->join("tb_productos","tb_produccion.producto","=","tb_productos.id")
                ->join("tb_producto_categorias","tb_productos.categoria","=","tb_producto_categorias.id")
                ->where('tb_asociados.estado','=','1')
                ->where('tb_productos.categoria','=',$id_categoria)
                ->where('tb_produccion.periodicidad','=',$id_periodicidad)
                ->count();

                $porcentaje_productos_periodicidad = round((intval($total_por_categorias_periodicidad)/intval($total_por_categorias_productos))*100, 2);

                $detalles_periodicidad[] = [
                    'periodicidad' => $nombre_periodicidad,
                    'cantidad_por_fincas' => $total_por_categorias_periodicidad,
                    'porcentaje' => $porcentaje_productos_periodicidad
                ];
            }

            //abro bloque periodicidad por categoria

            //abro bloque productos por categoria
            $detalles_productos  = [];

            $productos_por_categoria = Tb_productos::where('tb_productos.categoria','=',$id_categoria)->get();

            foreach($productos_por_categoria as $producto){
                $id_producto = $producto->id;
                $nombre_producto = $producto->producto;

                $total_productos_categorias = Tb_asociados::join("tb_asociados_fincas","tb_asociados_fincas.asociado","=","tb_asociados.id")
                ->join("tb_produccion","tb_asociados_fincas.id","=","tb_produccion.asociados_finca")
                ->join("tb_productos","tb_produccion.producto","=","tb_productos.id")
                ->where('tb_asociados.estado','=','1')
                ->where('tb_productos.id','=',$id_producto)
                ->count();

                $porcentaje_productos_categorias = round((intval($total_productos_categorias)/intval($total_por_categorias_productos))*100, 2);

                $detalles_productos[] = [
                    'producto' => $nombre_producto,
                    'cantidad_por_fincas' => $total_productos_categorias,
                    'porcentaje' => $porcentaje_productos_categorias
                ];
            }
            //cierro bloque productos por categoria

            $datos_categorias_productos[] = [
                'categoria' => $nombre_categoria,
                'cantidad_por_fincas' => $total_por_categorias_productos,
                'porcentaje' => $porcentaje_categorias_productos,
                'detalles_productos' => $detalles_productos,
                'detalles_periodicidad' => $detalles_periodicidad,
                'detalles_unidad_medida' => $detalles_unidad_medida
            ];
        }

        #-------------------------------------------------------------------------#
        #Salida de datos
        return [
            'estado' => 'Ok',
            'cantidad_asociados' => $cantidad_asociados,
            'datos_sexo' => [
                'cantidad_masculinos' => $cantidad_masculinos,
                'cantidad_femeninos' => $cantidad_femeninos,
                'cantidad_otro_sexo' => $cantidad_otro_sexo,
                'porcentaje_masculino' => $porcentaje_masculino,
                'porcentaje_femenino' => $porcentaje_femenino,
                'porcentaje_otro_sexo' => $porcentaje_otro_sexo
            ],
            'datos_edad' => [
                'rango_edad_decada_entre40y50' => "Entre ".$max40." y ".$min40." años",
                'cantidad_decada_entre40y50' => $entre40y50,
                'rango_edad_decada_entre50y60' => "Entre ".$max50." y ".$min50." años",
                'cantidad_decada_entre50y60' => $entre50y60,
                'rango_edad_decada_entre60y70' => "Entre ".$max60." y ".$min60." años",
                'cantidad_decada_entre60y70' => $entre60y70,
                'rango_edad_decada_entre70y80' => "Entre ".$max70." y ".$min70." años",
                'cantidad_decada_entre70y80' => $entre70y80,
                'rango_edad_decada_entre80y90' => "Entre ".$max80." y ".$min80." años",
                'cantidad_decada_entre80y90' => $entre80y90,
                'rango_edad_decada_entre90y00' => "Entre ".$max90." y ".$min90." años",
                'cantidad_decada_entre90y00' => $entre90y00,
                'rango_edad_decada_entre00y10' => "Entre ".$max00." y ".$min00." años",
                'cantidad_decada_entre00y10' => $entre00y10,
                'cantidad_fecha_indeterminada' => $fecha_nsnr
            ],
            'datos_vereda' => $datos_vereda,
            'fincas_por_hectareas' => $fincas_por_hectareas,
            'fincas_por_tipo_predio' => $datos_tipos_predio,
            'productos_por_categorias' => $datos_categorias_productos
        ];
    }
}
