<?php

namespace Tests\Unit\Repositories\BaseRepository;

use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\Unit\Repositories\BaseRepository\Common\BaseTestCase;
use Tests\Unit\Repositories\BaseRepository\Common\Stub;

class UpdateTest extends BaseTestCase
{
    private Stub $model;

    public function setUp(): void
    {
        parent::setUp();

        $this->model = new Stub();
        $this->model->name = 'Computer Networks';
        $this->model->author = 'Andrew S. Tanenbaum';
        $this->model->description = 'Appropriate for courses titled Computer Networking or ...';
        $this->model->save();
    }

    /**
     * Test update method in repository.
     *
     * @param $executable
     * @param $expected
     * @param $fillable
     * @return void
     * @dataProvider dataProvider
     * @group unit
     * @group repository
     * @group in-memory-database
     *
     * @throws BindingResolutionException
     */
    public function testUpdate($executable, $expected, $fillable): void
    {
        if (is_null($fillable)) {
            $this->stubRepository->update($executable, $this->model);
        } else {
            $this->stubRepository->update($executable, $this->model, $fillable);
        }

        $this->assertEquals(
            $expected,
            Stub::query()
                ->first(['id', 'name', 'author', 'description'])
                ->toArray(),
        );
    }

    public function dataProvider(): array
    {
        return [
            [
                // test case 1
                [
                    'name' => 'Head first design patterns',
                    'author' => 'Kathy Sierra, Elisabeth Freeman',
                ],
                [
                    'id' => 1,
                    'name' => 'Head first design patterns',
                    'author' => 'Kathy Sierra, Elisabeth Freeman',
                    'description' => 'Appropriate for courses titled Computer Networking or ...',
                ],
                null,
            ],
            [
                // test case 2
                [
                    'name' => 'Harry Potter',
                ],
                [
                    'id' => 1,
                    'name' => 'Harry Potter',
                    'author' => 'Andrew S. Tanenbaum',
                    'description' => 'Appropriate for courses titled Computer Networking or ...',
                ],
                null,
            ],
            [
                // test case 3
                [
                    'name' => 'Introduction to Algorithms',
                    'author' => 'CLRS',
                    'description' => 'Some description',
                ],
                [
                    'id' => 1,
                    'name' => 'Introduction to Algorithms',
                    'author' => 'CLRS',
                    'description' => 'Appropriate for courses titled Computer Networking or ...',
                ],
                null,
            ],
            [
                // test case 4
                [
                    'name' => 'Head first design patterns',
                    'author' => 'Kathy Sierra, Elisabeth Freeman',
                ],
                [
                    'id' => 1,
                    'name' => 'Head first design patterns',
                    'author' => 'Andrew S. Tanenbaum',
                    'description' => 'Appropriate for courses titled Computer Networking or ...',
                ],
                ['name'],
            ],
            [
                // test case 5
                [
                    'name' => 'Harry Potter',
                ],
                [
                    'id' => 1,
                    'name' => 'Harry Potter',
                    'author' => 'Andrew S. Tanenbaum',
                    'description' => 'Appropriate for courses titled Computer Networking or ...',
                ],
                ['name', 'author', 'description'],
            ],
            [
                // test case 6
                [
                    'name' => 'Introduction to Algorithms',
                    'author' => 'CLRS',
                    'description' => 'Some description',
                ],
                [
                    'id' => 1,
                    'name' => 'Introduction to Algorithms',
                    'author' => 'CLRS',
                    'description' => 'Some description',
                ],
                ['name', 'author', 'description'],
            ],
        ];
    }
}
