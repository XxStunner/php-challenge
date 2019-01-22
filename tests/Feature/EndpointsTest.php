<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Plan;
use App\Models\User_\Payment;

class EndpointsTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;
    use WithFaker;
    /**
     * Test if the route returns a 200 code and list the plans.
     * @return void
     */
    public function testPlans() {
        $total = 3;
        
        factory(Plan::class, $total)->create();

        $response = $this->get('/api/plans');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonCount($total, 'items');
    }
    /**
     * Test if the route returns a 200 code and list the payments.
     * @return void
     */
    public function testPayments() {
        $total = 5;

        factory(Payment::class, $total)->create();

        $response = $this->get('/api/payments');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonCount($total, 'items');
    }
    /**
     * Test if the route returns a 200 code and show the created payment.
     * @return void
     */
    public function testPaymentsById() {
        $payment = factory(Payment::class)->create();

        $response = $this->get("/api/payments/{$payment->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ]);
    }
    /**
     * Test if the route returns a 200 code and list the user payments.
     * @return void
     */
    public function testPaymentsByUser() {
        $total = 3;

        $user = factory(User::class)->create();

        factory(Payment::class, $total)->create([
            'user_id' => $user->id
        ]);

        $response = $this->get("/api/users/{$user->id}/payments");

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonCount($total, 'items');
    }
    /**
     * Test if the route returns a 200 and returns that the email is already on the database or not.
     * @return void
     */
    public function testCheckEmailSuccess() {
        $response = $this->get("/api/checkemail?email={$this->faker->unique()->safeEmail}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ]);
    }
    /**
     * Test if the route returns a 400 because the email param is missing.
     * @return void
     */
    public function testCheckEmailFailure() {
        $response = $this->get("/api/checkemail");

        $response
            ->assertStatus(400)
            ->assertJson([
                'status' => 'failure'
            ]);
    }
    /**
     * Test if the route returns a 200 and create the user.
     * @return void
     */
    public function testRegisterSuccess() {
        $this->faker->addProvider(new \Faker\Provider\pt_BR\PhoneNumber($this->faker));
        $this->faker->addProvider(new \Faker\Provider\pt_BR\Person($this->faker));

        $phones = [];

        for($i = 0; $i < rand(1, 10); $i++)
            $phones[] = $this->faker->phone(false);

        $response = $this->json('POST', '/api/register', [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'doc' => $this->faker->cpf(false),
            'address_street' => $this->faker->streetName,
            'address_complement' => $this->faker->secondaryAddress,
            'address_neighborhood' => $this->faker->citySuffix,
            'address_city' => $this->faker->city,
            'address_state' => $this->faker->stateAbbr,
            'phones' => $phones
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true
            ]);
    }
    /**
     * Test if the route returns a 400 because the user need atleast one phone.
     * @return void
     */
    public function testRegisterFailure() {
        $this->faker->addProvider(new \Faker\Provider\pt_BR\PhoneNumber($this->faker));
        $this->faker->addProvider(new \Faker\Provider\pt_BR\Person($this->faker));

        $response = $this->json('POST', '/api/register', [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'doc' => $this->faker->cpf(false),
            'address_street' => $this->faker->streetName,
            'address_complement' => $this->faker->secondaryAddress,
            'address_neighborhood' => $this->faker->citySuffix,
            'address_city' => $this->faker->city,
            'address_state' => $this->faker->stateAbbr,
            'phones' => []
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'created' => false
            ]);
    }
    /**
     * Test if the route returns a 200 and complete the payment.
     * @return void
     */
    public function testChargeSuccess() {
        $user = factory(User::class)->create();
        $plan = factory(Plan::class)->create();

        $response = $this->json('POST', '/api/charge', [
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'price' => $plan->price,
            'card_number' => '2672872851579012',
            'ccv' => '123',
            'status' => ''
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ]);
    }
    /**
     * Test if the route returns a 400 because the credit_number is invalid.
     * @return void
     */
    public function testChargeFailure() {
        $user = factory(User::class)->create();
        $plan = factory(Plan::class)->create();

        $response = $this->json('POST', '/api/charge', [
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'price' => $plan->price,
            'card_number' => '7339526258668625',
            'ccv' => '555',
            'status' => ''
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'status' => 'failure'
            ]);
    }
}
