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
            // Verificar si el asociado ya tiene una oferta activa sin importar el producto
            $existingOffer = Tb_oferta::where('asociados_finca_id', $request->asociados_finca_id)
                ->where('estado', 1) // Solo ofertas activas
                ->first();

            if ($existingOffer) {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ya tienes una oferta creada. No puedes crear más de una oferta activa.'
                ], 400);
            }

            // Validar que al menos una opción de contacto visible esté activa
            if ($request->telefono_visible==0 && $request->whatsapp_visible==0 && $request->correo_visible==0) {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Debes activar al menos una opción de contacto (teléfono, WhatsApp o correo).'
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
            $tb_oferta->telefono_visible = $request->telefono_visible;
            $tb_oferta->telefono = $request->telefono;
            $tb_oferta->whatsapp_visible = $request->whatsapp_visible;
            $tb_oferta->whatsapp = $request->whatsapp;
            $tb_oferta->correo_visible = $request->correo_visible;
            $tb_oferta->correo = $request->correo;
            $tb_oferta->precio = $request->precio;
            $tb_oferta->descripcion = $request->descripcion;
            $tb_oferta->imagenProducto = $request->imagenProducto;
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
        // Validar la entrada incluyendo la imagen en base64, precio y descripción
        $validatedData = $request->validate([
            'id' => 'nullable|integer|exists:tb_ofertas,id', // ID es opcional para editar una oferta existente
            'product_id' => 'required|integer|exists:tb_productos,id',
            'asociados_finca_id' => 'required|integer|exists:tb_asociados_fincas,id',
            'start_date' => 'required|date',
            'cantidad' => 'required|integer',
            'medida_unidades_id' => 'required|integer|exists:tb_medida_unidades,id',
            'telefono_visible' => 'required|boolean',
            'telefono' => 'nullable|string',
            'whatsapp_visible' => 'required|boolean',
            'whatsapp' => 'nullable|string',
            'correo_visible' => 'required|boolean',
            'correo' => 'nullable|string',
            'imagenProducto' => 'nullable|string', // Validar la imagen como un string de base64
            'precio' => 'required|numeric|min:0', // Validar precio como número positivo
            'descripcion' => 'nullable|string|max:500', // Validar descripción como string con un máximo de 500 caracteres
        ]);

        // Validar que al menos una opción de contacto visible esté activa
        if ($request->telefono_visible==0 && $request->whatsapp_visible==0 && $request->correo_visible==0) {
            return response()->json([
                'estado' => 'Error',
                'message' => 'Debes activar al menos una opción de contacto (teléfono, WhatsApp o correo).'
            ], 400);
        }

        DB::beginTransaction();

        // Verificar si ya existe una oferta activa para el producto del asociado
        $activeOffer = Tb_oferta::where('estado', 1)
            ->where('product_id', $request->product_id)
            ->where('asociados_finca_id', $request->asociados_finca_id)
            ->first();

        if ($activeOffer) {
            // Si existe una oferta activa, permitir la edición
            if ($request->filled('id') && $request->id == $activeOffer->id) {
                // Actualizar la oferta existente
                $offer = $activeOffer; // Tomar la oferta activa

                // Actualizar los campos de la oferta existente
                $offer->start_date = $request->start_date;
                $offer->cantidad = $request->cantidad;
                $offer->medida_unidades_id = $request->medida_unidades_id;
                $offer->telefono_visible = $request->telefono_visible;
                $offer->telefono = $request->telefono;
                $offer->whatsapp_visible = $request->whatsapp_visible;
                $offer->whatsapp = $request->whatsapp;
                $offer->correo_visible = $request->correo_visible;
                $offer->correo = $request->correo;
                $offer->end_date = \Carbon\Carbon::parse($request->start_date)->addDays(30); // Actualizar fecha de finalización
                $offer->precio = $request->precio; // Actualizar el precio
                $offer->descripcion = $request->descripcion; // Actualizar la descripción

                if ($request->filled('imagenProducto')) {
                    $offer->imagenProducto = $request->imagenProducto; // Actualizar la imagen en base64
                }

                if (!$offer->save()) {
                    DB::rollBack();
                    return response()->json([
                        'estado' => 'Error',
                        'message' => 'No se pudo actualizar la oferta existente'
                    ], 500);
                }
            } else {
                // Si el usuario intenta crear otra oferta, devolver un mensaje de error
                DB::rollBack();
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Ya tienes una oferta activa para este producto. Edítala si deseas realizar cambios.'
                ], 400);
            }
        } else {
            // Crear una nueva oferta si no existe una activa

            // Validar que al menos una opción de contacto visible esté activa
            if ($request->telefono_visible==0 && $request->whatsapp_visible==0 && $request->correo_visible==0) {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Debes activar al menos una opción de contacto (teléfono, WhatsApp o correo).'
                ], 400);
            }

            $newOferta = new Tb_oferta();
            $newOferta->product_id = $request->product_id;
            $newOferta->asociados_finca_id = $request->asociados_finca_id;
            $newOferta->start_date = $request->start_date;
            $newOferta->estado = 1; // La nueva oferta siempre se crea como activa
            $newOferta->end_date = \Carbon\Carbon::parse($request->start_date)->addDays(30); // Fecha de finalización 30 días después de la fecha de inicio
            $newOferta->cantidad = $request->cantidad;
            $newOferta->medida_unidades_id = $request->medida_unidades_id;
            $newOferta->telefono_visible = $request->telefono_visible;
            $newOferta->telefono = $request->telefono;
            $newOferta->whatsapp_visible = $request->whatsapp_visible;
            $newOferta->whatsapp = $request->whatsapp;
            $newOferta->correo_visible = $request->correo_visible;
            $newOferta->correo = $request->correo;
            $newOferta->precio = $request->precio; // Guardar el precio
            $newOferta->descripcion = $request->descripcion; // Guardar la descripción

            if ($request->filled('imagenProducto')) {
                $newOferta->imagenProducto = $request->imagenProducto; // Guardar la imagen en base64
            }

            if (!$newOferta->save()) {
                DB::rollBack();
                throw new \Exception('No se pudo guardar la nueva oferta');
            }
        }

        DB::commit();

        return response()->json([
            'estado' => 'Ok',
            'message' => 'La oferta se actualizó y/o creó exitosamente'
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Capturar errores de validación y devolverlos
        return response()->json([
            'error' => 'Errores de validación',
            'messages' => $e->errors(), // Detalles de los errores de validación
        ], 422);
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

    public function ofertasActivas()
    {
            # Modelo::join('tablaqueseune',basicamente un on)
            $ofertas_activas = Tb_oferta::join("tb_productos","tb_ofertas.product_id","=","tb_productos.id")
            ->join("tb_asociados_fincas","tb_ofertas.asociados_finca_id","=","tb_asociados_fincas.id")
            ->join("tb_medida_unidades","tb_ofertas.medida_unidades_id","=","tb_medida_unidades.id")
            ->join("tb_asociados","tb_asociados_fincas.asociado","=","tb_asociados.id")
            ->join("tb_personas","tb_asociados.persona","=","tb_personas.id")
            ->where("tb_ofertas.estado","=",1)
            ->select(
                "tb_ofertas.*",
                "tb_productos.*",
                "tb_asociados_fincas.*",
                "tb_medida_unidades.*",
                "tb_asociados.*",
                //"tb_asociado_permisos.instagram as permisoinstagram", // Alias para evitar conflicto
                "tb_personas.*"
            )
            ->get();

            return [
                'estado' => 'Ok',
                'ofertas_activas' => $ofertas_activas
            ];
    }
}
