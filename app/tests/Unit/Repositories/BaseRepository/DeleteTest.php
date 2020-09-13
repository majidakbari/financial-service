<?php

namespace Tests\Unit\Repositories\BaseRepository;

use Exception;
use Tests\Unit\Repositories\BaseRepository\Common\Stub;
use Tests\Unit\Repositories\BaseRepository\Common\BaseTestCase;

class DeleteTest extends BaseTestCase
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
     * Test repository delete method (normal behavior).
     *
     * @group unit
     * @group repository
     * @group in-memory-database
     *
     * @throws Exception
     */
    public function testDelete()
    {
        $this->stubRepository->delete($this->model);

        $this->assertEquals(0, Stub::query()->count());
    }
}
