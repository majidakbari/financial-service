<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Wallet
 * @property int id
 * @property string name
 * @property float balance
 * @property bool is_active
 * @property int user_id
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @package App\Entities
 */
class Wallet extends Model
{

}
