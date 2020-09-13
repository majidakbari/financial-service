<?php

namespace Tests\Unit\Repositories\BaseRepository;

use Illuminate\Database\Eloquent\Model;
use Tests\Unit\Repositories\BaseRepository\Common\Stub;
use Tests\Unit\Repositories\BaseRepository\Common\BaseTestCase;

class SaveTest extends BaseTestCase
{
    /**
     * Test create resource via repository.
     *
     * @param Model $object
     * @group unit
     * @group repository
     * @group in-memory-database
     *
     * @dataProvider dataProvider
     */
    public function testSave(Model $object): void
    {
        $this->stubRepository->save($object);
        $this->assertDatabaseHas('books', $object->getAttributes(), 'in-memory-test-db');
    }

    public function dataProvider(): array
    {
        return [
            [
                (new Stub())->fillable(['name', 'author', 'description'])->fill([
                    'name' => 'Head first design patterns',
                    'author' => null,
                    'description' => null,
                ]),
            ],
            [
                (new Stub())->fillable(['name', 'author', 'description'])->fill([
                    'name' => 'Harry Potter',
                    'author' => 'Kathy Sierra, Elisabeth Freeman',
                    'description' => null,
                ]),
            ],
            [
                (new Stub())->fillable(['name', 'author', 'description'])->fill([
                    'name' => 'Introduction to Algorithms',
                    'author' => 'CLRS',
                    'description' => 'Some description',
                ]),
            ],
        ];
    }
}
