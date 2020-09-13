<?php

namespace Tests\Unit\Repositories\BaseRepository\Common;

use App\Repositories\Common\BaseRepository;

class StubRepository extends BaseRepository
{
    protected array $fillable = [
        'name', 'author'
    ];

    protected function model(): string
    {
        return Stub::class;
    }
}
