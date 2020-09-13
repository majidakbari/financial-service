<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @property int id
 * @property string name
 * @property string email
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @package App\Entities
 */
class User extends Authenticatable
{
    use HasFactory;
}
