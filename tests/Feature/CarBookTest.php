<?php

namespace Tests\Feature;

use App\Models\Car;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\User;
use Tests\TestCase;

class CarBookTest extends TestCase
{
    use DatabaseMigrations;

    public function test_book()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $response = $this->postJson('/api/book/cars', ['car_id' => $car->id, 'user_id' => $user->id]);
        $response->assertStatus(200);
        $response->assertJsonPath('data.user_id', $user->id);
        $response->assertJsonPath('data.car_id', $car->id);
    }

    public function test_delete_book()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();
        $input = ['car_id' => $car->id, 'user_id' => $user->id];

        $response = $this->postJson('/api/book/cars', $input);
        $response->assertStatus(200);

        $response = $this->deleteJson('/api/book/cars', $input);
        $response->assertStatus(200);
        $response->assertJsonPath('data', true);

        $response = $this->deleteJson('/api/book/cars', $input);
        $response->assertStatus(404);
    }

    public function test_double_book()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $car = Car::factory()->create();
        $input = ['car_id' => $car->id, 'user_id' => $user->id];

        $response = $this->postJson('/api/book/cars', $input);
        $response->assertStatus(200);

        $response = $this->postJson('/api/book/cars', $input);
        $response->assertStatus(403);

        $response = $this->postJson('/api/book/cars',  ['car_id' => $car->id, 'user_id' => $user2->id]);
        $response->assertStatus(403);
    }

    public function test_get_user_car()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();
        $input = ['car_id' => $car->id, 'user_id' => $user->id];

        $response = $this->postJson('/api/book/cars', $input);
        $response->assertStatus(200);

        $response = $this->getJson('/api/users/'.$user->id.'/car');
        $response->assertStatus(200);

        $response = $this->deleteJson('/api/book/cars', $input);
        $response->assertStatus(200);
        $response->assertJsonPath('data', true);

        $response = $this->getJson('/api/users/'.$user->id.'/car');
        $response->assertStatus(404);
    }
}
