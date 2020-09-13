<?php

namespace Tests\Unit\Repositories\BaseRepository;

use Tests\Unit\Repositories\BaseRepository\Common\Stub;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\Unit\Repositories\BaseRepository\Common\BaseTestCase;

class ValidateQueryAttributeTest extends BaseTestCase
{
    private Stub $model;
    private Stub $model2;

    private const COMPUTER_PROGRAM_NAME = 'Computer Program';
    private const COMPUTER_NETWORKS_NAME = 'Computer Networks';

    public function setUp(): void
    {
        parent::setUp();

        $this->model = new Stub();
        $this->model->name = self::COMPUTER_NETWORKS_NAME;
        $this->model->author = 'Andrew S. Tanenbaum';
        $this->model->description = 'Appropriate for courses titled Computer Networking or ...';
        $this->model->save();

        $this->model2 = new Stub();
        $this->model2->name = self::COMPUTER_PROGRAM_NAME;
        $this->model2->author = 'Andrew S. Davina';
        $this->model2->description = 'Appropriate for Programmers or ...';
        $this->model2->save();
    }

    /**
     * Test consistent behavior of findBy method called more than once on repo instance
     *
     * @return void
     * @group unit
     * @group repository
     * @group in-memory-database
     *
     * @throws BindingResolutionException
     */
    public function testFindByCalledTwiceReturnsRightResult(): void
    {
        $result = $this->stubRepository->findBy('name', self::COMPUTER_NETWORKS_NAME);
        $result2 = $this->stubRepository->findBy('name', self::COMPUTER_PROGRAM_NAME);

        $this->assertEquals($this->model->toArray(), $result->toArray());
        $this->assertEquals($this->model2->toArray(), $result2->toArray());
    }

    /**
     * Test consistent behavior of other method called more than once on repo instance
     *
     * @return void
     * @group unit
     * @group repository
     * @group in-memory-database
     * @throws BindingResolutionException
     */
    public function testMethodCalledMoreThanOnceReturnsRightResult(): void
    {
        $result = $this->stubRepository->findBy('name', self::COMPUTER_NETWORKS_NAME);
        $result2 = $this->stubRepository->find(2);
        $result3 = Stub::query()->where(['name' => self::COMPUTER_PROGRAM_NAME])->exists();

        $this->assertEquals($this->model->toArray(), $result->toArray());
        $this->assertEquals($this->model2->toArray(), $result2->toArray());
        $this->assertTrue($result3);
    }
}
