<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TransactionResource
 * @property int id
 * @property int source_wallet_id
 * @property int destination_wallet_id
 * @property float amount
 * @property string type_description
 * @property string description
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @package App\Resources
 */
class TransactionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'source_wallet_id' => $this->source_wallet_id,
            'destination_wallet_id' => $this->destination_wallet_id,
            'amount' => $this->amount,
            'type_description' => $this->type_description,
            'description' => $this->description,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString()
        ];
    }
}
