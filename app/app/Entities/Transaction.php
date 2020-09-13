<?php

namespace App\Entities;

use Carbon\Carbon;

/**
 * Class Transaction
 * @property int id
 * @property int source_wallet_id
 * @property int destination_wallet_id
 * @property float amount
 * @property int type
 * @property string description
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @package App\Entities
 */
class Transaction
{
    public const TYPE_COMMISSION = 1;
    public const TYPE_TRANSFER = 2;
}
