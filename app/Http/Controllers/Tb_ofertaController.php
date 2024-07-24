<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tb_oferta;
use App\Http\Resources\DatosGeneralesResource;



class Tb_ofertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $ofertas = Tb_oferta::orderBy('id', 'asc')
        ->get();

        return response()->json([
            'estado' => 'Ok',
            'ofertas' => $ofertas
        ], 200);
    
    }

    public function indexOne(Request $request)
    {
        $ofertas = Tb_oferta::orderBy('id', 'desc')
        ->where('id', $request->id)
        ->get();

        return response()->json([
            'estado' => 'Ok',
            'ofertas' => $ofertas
        ], 200);
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $tb_oferta = new Tb_oferta();
            $tb_oferta->product_id = $request->product_id;
            $tb_oferta->asociados_finca_id = $request->asociados_finca_id;
            $tb_oferta->start_date = $request->start_date;
            $tb_oferta->estado = 1;
            // Suponiendo que la duración es de 30 días
            $tb_oferta->end_date = \Carbon\Carbon::parse($tb_oferta->start_date)->addDays(30);
            $tb_oferta->save();

            return response()->json([
                'estado' => 'Ok',
                'message' => 'Oferta creada con éxito'
            ]);
        } catch (\Exception $e) {
            $errorMessage = 'Ocurrió un error interno: ' . $e->getMessage();
            $errorDetails = [
                'message' => $errorMessage,
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ];

            return response()->json($errorDetails, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $tb_oferta = Tb_oferta::findOrFail($request->id);
            $tb_oferta->product_id = $request->product_id;
            $tb_oferta->asociados_finca_id = $request->asociados_finca_id;
            $tb_oferta->estado = 1;

            if ($tb_oferta->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Oferta actualizada con éxito'
                ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Oferta no pudo ser actualizada'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }
    }

    /**
     * Activate the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function activate(Request $request)
    {
        try {
            $tb_oferta = Tb_oferta::findOrFail($request->id);
            $tb_oferta->estado = 1;
            $tb_oferta->save();

            return response()->json([
                'estado' => 'Ok',
                'message' => 'Oferta activada con éxito'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'message' => 'No se pudo activar la oferta'
            ], 500);
        }
    }

    /**
     * Deactivate the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate(Request $request)
    {
        try {
            $tb_oferta = Tb_oferta::findOrFail($request->id);
            $tb_oferta->estado = 0;
            $tb_oferta->save();

            return response()->json([
                'estado' => 'Ok',
                'message' => 'Oferta desactivada con éxito'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'message' => 'No se pudo desactivar la oferta'
            ], 500);
        }
    }

    public function detallado()
    {
        return DatosGeneralesResource::collection(Tb_oferta::all());
    }

}
