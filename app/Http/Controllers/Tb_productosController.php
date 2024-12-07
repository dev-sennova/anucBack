<?php

namespace App\Http\Controllers;

use App\Models\Tb_grupo_categorias;
use App\Models\Tb_productos;
use Illuminate\Http\Request;

class Tb_productosController extends Controller
{
    public function index(Request $request)
    {
        $productos = Tb_productos::orderBy('producto','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'productos' => $productos
        ];
    }

    public function indexOne(Request $request)
    {
        $productos = Tb_productos::orderBy('producto','desc')
        ->where('tb_productos.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'productos' => $productos
        ];
    }

    public function indexImagen(Request $request)
    {
        $productos = Tb_productos::where('tb_productos.id','=',$request->id)
        ->select('tb_productos.imagenProducto')
        ->get();

        return [
            'estado' => 'Ok',
            'productos' => $productos
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_productos=new Tb_productos();
            $tb_productos->producto=$request->producto;
            $tb_productos->imagenProducto=$request->imagenProducto;
            $tb_productos->categoria=$request->categoria;
            $tb_productos->estado=1;

            if ($tb_productos->save()) {

                $idProducto=$tb_productos->id;

                $new_grupo_categorias = new Tb_grupo_categorias();
                $new_grupo_categorias->idGrupo=$request->grupo;
                $new_grupo_categorias->idProducto=$idProducto;

                if($new_grupo_categorias->save()){
                    return response()->json([
                        'estado' => 'Ok',
                        'message' => 'Los productos han sido creados con éxito'
                       ]);
                }else {
                    return response()->json([
                        'estado' => 'Error',
                        'message' => 'La asociacion no fue creada'
                       ]);
                }
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Los productos no fueron creados'
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
            $tb_productos=Tb_productos::findOrFail($request->id);
            $tb_productos->producto=$request->producto;
            $tb_productos->imagenProducto=$request->imagenProducto;
            $tb_productos->categoria=$request->categoria;
            $tb_productos->estado='1';

            if ($tb_productos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Los productos se actualizaron con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Los productos no fueron actualizados'
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
            $tb_productos=Tb_productos::findOrFail($request->id);
            $tb_productos->estado='0';

            if ($tb_productos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Los productos han sido desactivados con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Los productos no fueron desactivados'
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
            $tb_productos=Tb_productos::findOrFail($request->id);
            $tb_productos->estado='1';

            if ($tb_productos->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Los productos han sido activados con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Los productos no fueron activados'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
