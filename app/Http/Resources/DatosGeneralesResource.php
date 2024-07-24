<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DatosGeneralesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
            return [
                'id' => $this->id,
                'nombre_producto' => $this->product,
                'medida_unidad' => $this->medidaUnides->unidad,
                'id_asociado' => $this->asociadosFinca->asociados->id,
                'nombre_asociado' => $this->asociadosFinca->asociados->personas->nombres . ' ' . $this->asociadosFinca->asociados->personas->apellidos,
                'contacto_asociado' => $this->asociadosFinca->asociados->personas->telefono,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'estado' => $this->estado,
                'cantidad' => $this->cantidad,
                'contacto_visible' => $this->contacto_visible,

            ];


    }
}
