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
        'tb_fases_produccion.id as idFase', 'tb_fases_produccion.nombre_fase', 'tb_conceptos.id as idConcepto','tb_conceptos.concepto','tb_detallado_produccion.idHojaCostos')
        ->where('tb_detallado_produccion.idHojaCostos','=',$id)
        ->get();

        return [
            'estado' => 'Ok',
            'detallado_hoja' => $detallado_hoja
        ];
    }

    public function calculoHoja(Request $request)
    {
        $id = $request->id;

        $hoja_de_costos = Tb_hoja_de_costos::join('tb_grupo_categorias','tb_hoja_de_costos.idProducto','=','tb_grupo_categorias.idProducto')
        ->join('tb_grupos','tb_grupo_categorias.idGrupo','=','tb_grupos.id')
        ->join('tb_productos','tb_hoja_de_costos.idProducto','=','tb_productos.id')
        ->select('tb_hoja_de_costos.id as idHoja', 'tb_hoja_de_costos.fechaInicio','tb_hoja_de_costos.fechaFin','tb_hoja_de_costos.descripcion',
        'tb_hoja_de_costos.unidad','tb_hoja_de_costos.cantidad','tb_hoja_de_costos.esperado','tb_productos.producto as producto')
        ->where('tb_hoja_de_costos.id','=',$id)
        ->get();

        $totalcosto = 0;
        $costounidad = 0;

        foreach ($hoja_de_costos as $global) {
            $idHoja = $global->idHoja;
            $fechaInicio = $global->fechaInicio;
            $fechaFin = $global->fechaFin;
            $descripcion = $global->descripcion;
            $unidad = $global->unidad;
            $cantidad = $global->cantidad;
            $esperado = $global->esperado;
            $producto = $global->producto;
        }

        // Obtener todas las fases relacionadas con la hoja de costos
        $listado_fases = Tb_detallado_produccion::join('tb_fases_produccion', 'tb_fases_produccion.id', '=', 'tb_detallado_produccion.idFase')
            ->select('tb_fases_produccion.id as idFase', 'tb_fases_produccion.nombre_fase as nombreFase')
            ->where('tb_detallado_produccion.idHojaCostos', $id)
            ->groupBy('tb_fases_produccion.id', 'tb_fases_produccion.nombre_fase')
            ->orderBy('tb_fases_produccion.nombre_fase', 'ASC')
            ->get();

        $resultado = [];

        foreach ($listado_fases as $fase) {
            $idFase = $fase->idFase;
            $nombreFase = $fase->nombreFase;
            $acumuladoFase = 0;

            // Obtener los grupos de conceptos para la fase actual
            $grupo_conceptos = Tb_detallado_produccion::join('tb_conceptos', 'tb_detallado_produccion.idConcepto', '=', 'tb_conceptos.id')
                ->join('tb_grupos_conceptos', 'tb_grupos_conceptos.id', '=', 'tb_conceptos.idGrupo')
                ->select('tb_grupos_conceptos.id as idGrupoConcepto', 'tb_grupos_conceptos.grupo as nombreGrupoConcepto')
                ->where('tb_detallado_produccion.idHojaCostos', $id)
                ->where('tb_detallado_produccion.idFase', $idFase)
                ->groupBy('tb_grupos_conceptos.id', 'tb_grupos_conceptos.grupo')
                ->orderBy('tb_grupos_conceptos.grupo', 'ASC')
                ->get();

            $grupos = [];

            foreach ($grupo_conceptos as $grupo) {
                $idGrupoConcepto = $grupo->idGrupoConcepto;
                $nombreGrupoConcepto = $grupo->nombreGrupoConcepto;
                $acumuladoAgrupacion = 0;

                // Obtener los detalles agrupados para el grupo actual
                $agrupado_hoja = Tb_detallado_produccion::join('tb_conceptos', 'tb_detallado_produccion.idConcepto', '=', 'tb_conceptos.id')
                    ->join('tb_grupos_conceptos', 'tb_grupos_conceptos.id', '=', 'tb_conceptos.idGrupo')
                    ->select(
                        'tb_detallado_produccion.id as idDetallado',
                        'tb_detallado_produccion.cantidad',
                        'tb_detallado_produccion.valorUnitario',
                        DB::raw('tb_detallado_produccion.cantidad * tb_detallado_produccion.valorUnitario as subtotal'),
                        'tb_conceptos.id as idConcepto',
                        'tb_conceptos.concepto'
                    )
                    ->where('tb_detallado_produccion.idHojaCostos', $id)
                    ->where('tb_detallado_produccion.idFase', $idFase)
                    ->where('tb_grupos_conceptos.id', $idGrupoConcepto)
                    ->get();

                foreach ($agrupado_hoja as $agrupacion) {
                    $subtotalAgrupacion = $agrupacion->subtotal;
                    $acumuladoAgrupacion=$acumuladoAgrupacion+$subtotalAgrupacion;
                }

                $acumuladoFase=$acumuladoFase+$acumuladoAgrupacion;

                $grupos[] = [
                    'idGrupoConcepto' => $idGrupoConcepto,
                    'nombreGrupoConcepto' => $nombreGrupoConcepto,
                    'acumuladoAgrupacion' => $acumuladoAgrupacion,
                    'agrupado_hoja' => $agrupado_hoja
                ];
            }

            $totalcosto=$totalcosto+$acumuladoFase;

            $resultado[] = [
                'idFase' => $idFase,
                'nombreFase' => $nombreFase,
                'acumuladoFase' => $acumuladoFase,
                'gruposConceptos' => $grupos
            ];
        }

        $costounidad=$totalcosto/$esperado;

        return response()->json([
            'estado' => 'Ok',
            'idHoja' => $idHoja,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'descripcion' => $descripcion,
            'unidad' => $unidad,
            'cantidad' => $cantidad,
            'esperado' => $esperado,
            'producto' => $producto,
            'totalcosto' => $totalcosto,
            'costounidad' => $costounidad,
            'detallado_hoja' => $resultado
        ]);
    }

}
