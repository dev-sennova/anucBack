<?php

namespace App\Http\Controllers;

use App\Models\Tb_asociados;
use App\Models\Tb_empresa_globales;
use App\Models\Tb_asociados_fincas;
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
        #Consulta por categorias
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
            'fincas_por_hectareas' => $fincas_por_hectareas
        ];
    }
}
