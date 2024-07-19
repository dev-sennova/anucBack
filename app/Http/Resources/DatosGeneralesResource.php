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
                'nombre_asociado' => $this->asociadosFinca->asociados->personas, 
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'estado' => $this->estado,
            ];
        


    }
}
