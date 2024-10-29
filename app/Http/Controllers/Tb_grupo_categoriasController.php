<?php

namespace App\Http\Controllers;

use App\Models\Tb_grupo_categorias;
use Illuminate\Http\Request;

class Tb_grupo_categoriasController extends Controller
{
    public function index(Request $request)
    {
        $grupo_categorias = Tb_grupo_categorias::join("tb_grupos","tb_grupo_categorias.idGrupo","=","tb_grupos.id")
        ->join("tb_productos","tb_grupo_categorias.idProducto","=","tb_productos.id")
        ->orderBy('tb_grupo_categorias.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'grupo_categorias' => $grupo_categorias
        ];
    }

    public function indexOne(Request $request)
    {
        $grupo_categorias = Tb_grupo_categorias::join("tb_grupos","tb_grupo_categorias.idGrupo","=","tb_grupos.id")
        ->join("tb_productos","tb_grupo_categorias.idProducto","=","tb_productos.id")
        ->orderBy('tb_grupo_categorias.id','asc')
        ->where('tb_grupo_categorias.idGrupo','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'grupo_categorias' => $grupo_categorias
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_grupo_categorias=new Tb_grupo_categorias();
            $tb_grupo_categorias->idProducto=$request->idProducto;
            $tb_grupo_categorias->idGrupo=$request->idGrupo;

            if ($tb_grupo_categorias->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'La agrupacion ha sido creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La agrupacion no fue creada'
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
            $tb_grupo_categorias=Tb_grupo_categorias::findOrFail($request->id);
            $tb_grupo_categorias->idProducto=$request->idProducto;
            $tb_grupo_categorias->idGrupo=$request->idGrupo;

            if ($tb_grupo_categorias->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'La agrupación se actualizó con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'La agrupación no fue actualizada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function indexGrupoUsuario(Request $request)
    {
        $grupo_categorias = Tb_grupo_categorias::join("tb_grupos","tb_grupo_categorias.idGrupo","=","tb_grupos.id")
        ->join("tb_productos","tb_grupo_categorias.idProducto","=","tb_productos.id")
        ->where('tb_grupos.id','=',$request->idGrupo)
        ->orderBy('tb_grupo_categorias.id','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'grupo_categorias' => $grupo_categorias
        ];
    }
}
