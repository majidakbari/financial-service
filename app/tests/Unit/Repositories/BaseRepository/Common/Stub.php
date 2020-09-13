<?php

namespace Tests\Unit\Repositories\BaseRepository\Common;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Stub
 * @property int id
 * @property string name
 * @property string author
 * @property string description
 * @package Tests\Unit\Repositories\BaseRepository\Common
 */
class Stub extends Model
{
    protected $table = 'books';
    protected $connection = 'in-memory-test-db';
}
