<?php

namespace Tests\Unit\Repositories\BaseRepository;

use Tests\Unit\Repositories\BaseRepository\Common\Stub;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\Unit\Repositories\BaseRepository\Common\BaseTestCase;

class FindTest extends BaseTestCase
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
     * Test repository find method (normal behavior).
     *
     * @return void
     * @group unit
     * @group repository
     * @group in-memory-database
     * @throws BindingResolutionException
     */
    public function testFind(): void
    {
        $result = $this->stubRepository->find($this->model->id);

        $this->assertEquals($this->model->toArray(), $result->toArray());
    }

    /**
     * Test repository find method (not found).
     *
     * @return void
     * @group unit
     * @group repository
     * @group in-memory-database
     * @throws BindingResolutionException
     */
    public function testFindNotFound(): void
    {
        $result = $this->stubRepository->find(10);

        $this->assertEquals(null, $result);
    }

    /**
     * Test repository find method (on a column).
     *
     * @return void
     * @group unit
     * @group repository
     * @group in-memory-database
     * @throws BindingResolutionException
     */
    public function testFindBy(): void
    {
        $result = $this->stubRepository->findBy('name', 'Computer Networks');

        $this->assertEquals($this->model->toArray(), $result->toArray());
    }

    /**
     * Test repository find method (on a column with select params).
     *
     * @return void
     * @group unit
     * @group repository
     * @group in-memory-database
     * @throws BindingResolutionException
     */
    public function testFindByWithColumns(): void
    {
        $result = $this->stubRepository->findBy('name', 'Computer Networks', ['name', 'author', 'description']);

        $this->assertEquals(
            [
                'name' => 'Computer Networks',
                'author' => 'Andrew S. Tanenbaum',
                'description' => 'Appropriate for courses titled Computer Networking or ...',
            ],
            $result->toArray(),
        );
    }

    /**
     * Test repository find method (not found on a column).
     *
     * @return void
     * @group unit
     * @group repository
     * @group in-memory-database
     * @throws BindingResolutionException
     */
    public function testFindByNotFound(): void
    {
        $result = $this->stubRepository->findBy('name', 'Operating Systems');

        $this->assertEquals(null, $result);
    }
}
