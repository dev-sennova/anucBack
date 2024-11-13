<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Tb_productos;
use App\Models\Tb_asociados;
use App\Models\Tb_asociados_fincas;
use App\Models\Tb_produccion;
use App\Models\Tb_detallado_produccion;
use App\Models\Tb_hoja_de_costos;

class CosteoController extends Controller
{
    //
    public function categoriasPorUsuario(Request $request)
    {
        $id = $request->id;

        $categorias = DB::select("
            select distinct tg.id as idGrupo, tg.grupo as grupo, tg.descripcion as descripcionGrupo
            from tb_asociados aso
            join tb_asociados_fincas taf on aso.id = taf.asociado
            join tb_produccion tp on taf.id = tp.asociados_finca
            join tb_productos tpr on tp.producto = tpr.id
            join tb_grupo_categorias tgc on tgc.idProducto = tpr.id
            join tb_grupos tg on tgc.idGrupo = tg.id
            WHERE aso.id = ?
        ", [$id]);

        return [
            'estado' => 'Ok',
            'categorias' => $categorias
        ];
    }

    public function productosPorUsuario(Request $request)
    {
        $id = $request->id;

        $productos = Tb_asociados::join('tb_asociados_fincas','tb_asociados.id','=','tb_asociados_fincas.asociado')
        ->join('tb_produccion','tb_asociados_fincas.id','=','tb_produccion.asociados_finca')
        ->join('tb_productos','tb_produccion.producto','=','tb_productos.id')
        ->join('tb_grupo_categorias','tb_productos.id','=','tb_grupo_categorias.idProducto')
        ->join('tb_grupos','tb_grupo_categorias.idGrupo','=','tb_grupos.id')
        ->select('tb_asociados.id as idAsociado', 'tb_productos.id as idProducto', 'tb_productos.producto as producto',
        'tb_grupos.id as idGrupo', 'tb_grupos.grupo as grupo', 'tb_grupos.descripcion as descripcionGrupo')
        ->where('tb_asociados.id','=',$id)
        ->get();

        return [
            'estado' => 'Ok',
            'productos' => $productos
        ];
    }

    public function hojasPorGrupo(Request $request)
    {
        $idGrupo = $request->idGrupo;
        $idAsociado = $request->idAsociado;

        $hojas_por_grupo = Tb_hoja_de_costos::join('tb_grupo_categorias','tb_hoja_de_costos.idProducto','=','tb_grupo_categorias.idProducto')
        ->join('tb_grupos','tb_grupo_categorias.idGrupo','=','tb_grupos.id')
        ->join('tb_productos','tb_hoja_de_costos.idProducto','=','tb_productos.id')
        ->select('tb_hoja_de_costos.id as idHoja', 'tb_hoja_de_costos.fechaInicio','tb_hoja_de_costos.fechaFin',
        'tb_hoja_de_costos.descripcion','tb_hoja_de_costos.unidad','tb_hoja_de_costos.cantidad','tb_hoja_de_costos.esperado',
        'tb_hoja_de_costos.idAsociado','tb_productos.id as idProducto', 'tb_productos.producto as producto',
        'tb_grupos.id as idGrupo', 'tb_grupos.grupo as grupo', 'tb_grupos.descripcion as descripcionGrupo')
        ->where('tb_grupos.id','=',$idGrupo)
        ->where('tb_hoja_de_costos.idAsociado','=',$idAsociado)
        ->get();

        return [
            'estado' => 'Ok',
            'hojas_por_grupo' => $hojas_por_grupo
        ];
    }

    public function detalladoHoja(Request $request)
    {
        $id = $request->id;

        $detallado_hoja = Tb_detallado_produccion::join('tb_fases_produccion','tb_fases_produccion.id','=','tb_detallado_produccion.idFase')
        ->join('tb_conceptos','tb_detallado_produccion.idConcepto','=','tb_conceptos.id')
        ->select('tb_detallado_produccion.id as idDetallado', 'tb_detallado_produccion.cantidad', 'tb_detallado_produccion.valorUnitario',
        'tb_fases_produccion.id as idFase', 'tb_fases_produccion.nombre_fase', 'tb_conceptos.id as idConcepto','tb_conceptos.concepto')
        ->where('tb_detallado_produccion.idHojaCostos','=',$id)
        ->get();

        return [
            'estado' => 'Ok',
            'detallado_hoja' => $detallado_hoja
        ];
    }

}
