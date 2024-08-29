<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tb_oferta;
use App\Http\Resources\DatosGeneralesResource;
use Illuminate\Support\Facades\DB;



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
            // Verificar si ya existe una oferta para el producto dado
            $existingOffer = Tb_oferta::where('product_id', $request->product_id)->first();

            if ($existingOffer) {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ya existe una oferta para este producto.'
                ], 400);
            }

            // Crear la nueva oferta
            $tb_oferta = new Tb_oferta();
            $tb_oferta->product_id = $request->product_id;
            $tb_oferta->asociados_finca_id = $request->asociados_finca_id;
            $tb_oferta->start_date = $request->start_date;
            $tb_oferta->estado = 1; // Establecer la nueva oferta como activa
            $tb_oferta->end_date = \Carbon\Carbon::parse($tb_oferta->start_date)->addDays(30);
            $tb_oferta->cantidad = $request->cantidad;
            $tb_oferta->medida_unidades_id = $request->medida_unidades_id;
            $tb_oferta->contacto_visible = $request->contacto_visible;
            $tb_oferta->save();

            return response()->json([
                'estado' => 'Ok',
                'message' => 'La oferta ha sido creada con éxito'
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
            // Validar la entrada
            $request->validate([
                'id' => 'nullable|integer|exists:tb_ofertas,id', // id es opcional para crear una nueva oferta
                'product_id' => 'required|integer|exists:tb_productos,id',
                'asociados_finca_id' => 'required|integer|exists:tb_asociados_fincas,id',
                'start_date' => 'required|date',
                'cantidad' => 'required|integer',
                'medida_unidades_id' => 'required|integer|exists:tb_medida_unidades,id',
                'contacto_visible' => 'required|boolean',
            ]);

            DB::beginTransaction();

            // Desactivar cualquier oferta activa para el producto
            $activeOffer = Tb_oferta::where('estado', 1)
                ->where('product_id', $request->product_id)
                ->first();

            if ($activeOffer) {
                // Desactivar la oferta activa existente
                $activeOffer->estado = 0;
                $activeOffer->end_date = now(); // Fecha actual como fecha de finalización

                if (!$activeOffer->save()) {
                    DB::rollBack();
                    return response()->json([
                        'estado' => 'Error',
                        'message' => 'No se pudo desactivar la oferta activa existente'
                    ], 500);
                }
            }

            if ($request->id) {
                // Si se proporciona un ID, actualizar la oferta existente
                $offer = Tb_oferta::find($request->id);

                if ($offer) {
                    // Actualizar los campos de la oferta existente
                    $offer->product_id = $request->product_id;
                    $offer->asociados_finca_id = $request->asociados_finca_id;
                    $offer->start_date = $request->start_date;
                    $offer->cantidad = $request->cantidad;
                    $offer->medida_unidades_id = $request->medida_unidades_id;
                    $offer->contacto_visible = $request->contacto_visible;
                    $offer->end_date = \Carbon\Carbon::parse($request->start_date)->addDays(30); // Fecha de finalización 30 días después de la fecha de inicio

                    // Activar la oferta modificada
                    $offer->estado = 1;

                    if (!$offer->save()) {
                        DB::rollBack();
                        return response()->json([
                            'estado' => 'Error',
                            'message' => 'No se pudo actualizar la oferta'
                        ], 500);
                    }
                } else {
                    DB::rollBack();
                    return response()->json([
                        'estado' => 'Error',
                        'message' => 'La oferta no existe'
                    ], 404);
                }
            } else {
                // Crear una nueva oferta si no se proporciona un ID
                $newOferta = new Tb_oferta();
                $newOferta->product_id = $request->product_id;
                $newOferta->asociados_finca_id = $request->asociados_finca_id;
                $newOferta->start_date = $request->start_date;
                $newOferta->estado = 1; // La nueva oferta siempre se crea como activa
                $newOferta->end_date = \Carbon\Carbon::parse($request->start_date)->addDays(30); // Fecha de finalización 30 días después de la fecha de inicio
                $newOferta->cantidad = $request->cantidad;
                $newOferta->medida_unidades_id = $request->medida_unidades_id;
                $newOferta->contacto_visible = $request->contacto_visible;

                if (!$newOferta->save()) {
                    DB::rollBack();
                    throw new \Exception('No se pudo guardar la nueva oferta');
                }
            }

            DB::commit();

            return response()->json([
                'estado' => 'Ok',
                'message' => 'La oferta se actualizó y la oferta existente fue desactivada exitosamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Ocurrió un error interno',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
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
                'message' => 'La oferta ha sido activada con éxito'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'message' => 'La oferta no fue activada '
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
                'message' => 'La oferta ha sido desactivada con éxito'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'estado' => 'Error',
                'message' => 'La oferta no fue desactivada'
            ], 500);
        }
    }

    public function detallado()
    {
        return DatosGeneralesResource::collection(Tb_oferta::with(['product.productoCategoria'])->get());
    }
}