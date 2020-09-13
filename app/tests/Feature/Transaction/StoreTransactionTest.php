<?php

namespace Tests\Feature\Transaction;

use Tests\TestCase;
use App\Entities\Wallet;
use App\Entities\Transaction;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StoreTransactionTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    /**
     * @group feature
     * @group transaction
     */
    public function testRequestIsNotAcceptable()
    {
        $response = $this->postJson(route('api.transaction.store'), [], [
            'accept' => $this->faker->randomElement(['text/html', 'application/xml', 'application/pdf'])
        ]);

        $response->assertStatus(Response::HTTP_NOT_ACCEPTABLE)->assertJson([
            'error' => 'InvalidAcceptHeaderException',
            'message' => trans('error.InvalidAcceptHeaderException')
        ]);
    }

    /**
     * @group feature
     * @group transaction
     */
    public function testMethodIsNotAllowed()
    {
        $response = $this->json(
            $this->faker->randomElement(['get', 'put', 'patch', 'delete']),
            route('api.transaction.store')
        );
        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED)->assertJson([
            'error' => 'MethodNotAllowedHttpException',
            'message' => trans('error.MethodNotAllowedHttpException')
        ]);
    }

    /**
     * @group feature
     * @group transaction
     */
    public function testInsufficientCredit()
    {
        $wallets = Wallet::factory(2)->create();

        $response = $this->postJson(route('api.transaction.store'), [
            'source_wallet_id' => $wallets->first()->getKey(),
            'destination_wallet_id' => $wallets->last()->getKey(),
            'amount' => $wallets->first()->balance + $this->faker->numberBetween(1, 10000)
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertJson([
            'error' => 'InsufficientCreditException',
            'message' => trans('error.InsufficientCreditException')
        ]);
    }

    /**
     * @group feature
     * @group transaction
     */
    public function testTransferToSourceWallet()
    {
        $wallet = Wallet::factory()->create();

        $response = $this->postJson(route('api.transaction.store'), [
            'source_wallet_id' => $wallet->getKey(),
            'destination_wallet_id' => $wallet->getKey(),
            'amount' => $wallet->balance
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJsonStructure([
            'message' => ['destination_wallet_id'],
        ]);
    }

    /**
     * @group feature
     * @group transaction
     */
    public function testWrongWalletId()
    {
        $response = $this->postJson(route('api.transaction.store'), [
            'source_wallet_id' => $this->faker->uuid,
            'destination_wallet_id' => $this->faker->uuid,
            'amount' => $this->faker->numberBetween(1, 100000)
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJsonStructure([
            'message' => ['source_wallet_id', 'destination_wallet_id'],
        ]);
    }

    /**
     * @group feature
     * @group transaction
     */
    public function testInActiveWallets()
    {
        $wallets = Wallet::factory(2)->inactive()->create();

        $response = $this->postJson(route('api.transaction.store'), [
            'source_wallet_id' => $wallets->first()->getKey(),
            'destination_wallet_id' => $wallets->last()->getKey(),
            'amount' => $wallets->first()->balance
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJsonStructure([
            'message' => ['source_wallet_id', 'destination_wallet_id'],
        ]);
    }

    /**
     * @group feature
     * @group transaction
     */
    public function testWrongAmount()
    {
        $wallets = Wallet::factory(2)->create();

        $response = $this->postJson(route('api.transaction.store'), [
            'source_wallet_id' => $wallets->first()->getKey(),
            'destination_wallet_id' => $wallets->last()->getKey(),
            'amount' => $this->faker->randomElement([$this->faker->name, $this->faker->rgbColorAsArray])
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJsonStructure([
            'message' => ['amount'],
        ]);
    }

    /**
     * @group feature
     * @group transaction
     */
    public function testNonTextDescription()
    {
        $wallets = Wallet::factory(2)->create();

        $response = $this->postJson(route('api.transaction.store'), [
            'source_wallet_id' => $wallets->first()->getKey(),
            'destination_wallet_id' => $wallets->last()->getKey(),
            'amount' => $wallets->first()->balance,
            'description' => $this->faker->rgbColorAsArray
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJsonStructure([
            'message' => ['description'],
        ]);
    }

    /**
     * @group feature
     * @group transaction
     */
    public function testSuccess()
    {
        $wallets = Wallet::factory(2)->create();
        $companyWallet = Wallet::factory()->create();
        $commissionRate = $this->faker->numberBetween(1, 10);
        config()->set('logic.company_wallet_id', $companyWallet->getKey());
        config()->set('logic.commission_rate', $commissionRate);
        $sourceWallet = $wallets->first();
        $destinationWallet = $wallets->last();
        $data = [
            'source_wallet_id' => $sourceWallet->getKey(),
            'destination_wallet_id' => $destinationWallet->getKey(),
            'amount' => $wallets->first()->balance,
            'description' => $this->faker->text
        ];

        $response = $this->postJson(route('api.transaction.store'), $data);

        $response->assertSuccessful();

        $commission = number_format($data['amount'] * $commissionRate / 100, 2);

        $this->assertDatabaseHas('transactions', array_merge($data, [
            'amount' => $data['amount'] - $commission, 'type' => Transaction::TYPE_TRANSFER_CODE
        ]));

        $this->assertDatabaseHas('transactions', [
            'source_wallet_id' => $data['source_wallet_id'],
            'destination_wallet_id' => $companyWallet->getKey(),
            'amount' => $commission,
            'type' => Transaction::TYPE_COMMISSION_CODE,
            'description' => null
        ]);

        $this->assertDatabaseHas('wallets', [
            'id' => $sourceWallet->getKey(),
            'balance' => $sourceWallet->balance - $data['amount']
        ]);
        $this->assertDatabaseHas('wallets', [
            'id' => $destinationWallet->getKey(),
            'balance' => $destinationWallet->balance + $data['amount'] - $commission
        ]);
        $this->assertDatabaseHas('wallets', [
            'id' => $companyWallet->getKey(),
            'balance' => $companyWallet->balance + $commission
        ]);
    }
}
