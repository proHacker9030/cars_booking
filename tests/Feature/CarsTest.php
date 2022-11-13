<?php

namespace Tests\Feature;

use App\Models\Car;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CarsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @dataProvider create_provider
     */
    public function test_create(array $input, int $expected)
    {
        $response = $this->postJson('/api/cars', $input);

        $this->assertEquals($expected, $response->getStatusCode());
    }

    public function test_update()
    {
        /** @var Car $car */
        $car = Car::factory()->create();

        $changedBrand = 'Changed';
        $response = $this->putJson('/api/cars/' . $car->id, [
            'brand' => $changedBrand,
            'model' => $car->brand
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('data.brand', $changedBrand);
    }

    public function test_get()
    {
        $car = Car::factory()->create();
        $response = $this->getJson('/api/cars/' . $car->id);
        $response->assertStatus(200);
        $response->assertJsonPath('data.brand', $car->brand);

        $response = $this->getJson('/api/cars/');
        $response->assertStatus(200);
    }

    public function test_delete()
    {
        $car = Car::factory()->create();
        $response = $this->deleteJson('/api/cars/' . $car->id);
        $response->assertStatus(200);
        $response->assertJsonPath('data', true);
    }

    public function create_provider()
    {
        return [
            'successfully_added' => [
                'input' => [
                    'brand' => 'Mercedes',
                    'model' => 'E420',
                ],
                'expected' => 200,
            ],
            'failed_during_add' => [
                'input' => [
                    'model' => 'E420',
                ],
                'expected' => 422,
            ],
        ];
    }
}
