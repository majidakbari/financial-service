<?php

namespace Tests\Unit\Repositories\BaseRepository\Common;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Schema\Blueprint;

abstract class BaseTestCase extends TestCase
{
    public StubRepository $stubRepository;

    public function setUp(): void
    {
        parent::setUp();

        Config::set('database.connections.in-memory-test-db', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'charset' => 'utf8',
            'prefix' => '',
        ]);

        Schema::connection('in-memory-test-db')->create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('author')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        $this->stubRepository = resolve(StubRepository::class);
    }

    public function tearDown(): void
    {
        Schema::connection('in-memory-test-db')->drop('books');

        parent::tearDown();
    }
}
