<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Tb_productos;
use App\Models\Tb_asociados;
use App\Models\Tb_asociados_fincas;
use App\Models\Tb_produccion;
use App\Models\Tb_detallado_produccion;

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

        $productos = DB::select("
            select aso.id as idAsociado, tpr.id as idProducto, tpr.producto as producto, tg.id as idGrupo, tg.grupo as grupo,
            tg.descripcion as descripcionGrupo
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
            'productos' => $productos
        ];
    }

}
