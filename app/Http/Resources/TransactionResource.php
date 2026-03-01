<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'from' => $this->payer->name,
            'to' => $this->payee->name,
            'value' => formatPrice($this->value),
            'status' => $this->status,
            'date' => $this->created_at->format('d/m/Y H:i:s'),
        ];
    }
}
