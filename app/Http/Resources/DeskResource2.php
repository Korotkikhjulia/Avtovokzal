<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeskResource2 extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'number_trip'=> $this->number_trip,
            'departure_date'=>$this->departure_date,
            'arrival_date'=>$this->arrive_date,
            'bus_id'=>$this->bus_id,
        ];
    }
}
