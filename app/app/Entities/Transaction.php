<?php

namespace App\Entities;

use Carbon\Carbon;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;

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
class Transaction extends Model
{
    public const TYPE_COMMISSION_CODE = 1;
    public const TYPE_COMMISSION_DESCRIPTION = 'commission';
    public const TYPE_TRANSFER_CODE = 2;
    public const TYPE_TRANSFER_DESCRIPTION  = 'Transfer';

    protected $appends = [
        'type_description'
    ];

    public function getTypeDescriptionAttribute(): string
    {
        switch ($this->type) {
            case self::TYPE_COMMISSION_CODE:
                return self::TYPE_COMMISSION_DESCRIPTION;
                break;
            case self::TYPE_TRANSFER_CODE:
                return self::TYPE_TRANSFER_DESCRIPTION;
                break;
            default:
                throw new InvalidArgumentException();
        }
    }
}
