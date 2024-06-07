<?php

namespace App\Http\Controllers;

use App\Models\Tb_categorias;
use Illuminate\Http\Request;

class Tb_categoriasController extends Controller
{
    public function index(Request $request)
    {
        $categoria = Tb_categorias::orderBy('categoria','asc')
        ->get();

        return [
            'estado' => 'Ok',
            'categoria' => $categoria
        ];
    }

    public function indexOne(Request $request)
    {
        $categoria = Tb_categorias::orderBy('categoria','desc')
        ->where('tb_categorias.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'categoria' => $categoria
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_categorias=new Tb_categorias();
            $tb_categorias->categoria=$request->categoria;
            $tb_categorias->estado=1;

            if ($tb_categorias->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Categoria creada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Categoria no pudo ser creada'
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
            $tb_categorias=Tb_categorias::findOrFail($request->id);
            $tb_categorias->categoria=$request->categoria;
            $tb_categorias->estado='1';

            if ($tb_categorias->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Categoria actualizada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Categoria no pudo ser actualizada'
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
            $tb_categorias=Tb_categorias::findOrFail($request->id);
            $tb_categorias->estado='0';

            if ($tb_categorias->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Categoria desactivada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Categoria no pudo ser desactivada'
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
            $tb_categorias=Tb_categorias::findOrFail($request->id);
            $tb_categorias->estado='1';

            if ($tb_categorias->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Categoria activada con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Categoria no pudo ser activada'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
