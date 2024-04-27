<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'bus_id' => $this->bus_id,
            'driver_id' => $this->driver_id,
            'contact_name' => $this->contact_name,
            'contact_phone' => $this->contact_phone,
            'start_rent_date' => $this->start_rent_date,
            'total_rent_days' => $this->total_rent_days,
            'bus' => new BusResource($this->buses),
            'driver' => new DriverResource($this->drivers)
        ];
    }
}
