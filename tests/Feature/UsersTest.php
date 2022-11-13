<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @dataProvider create_provider
     */
    public function test_create(array $input, int $expected)
    {
        $response = $this->postJson('/api/users', $input);

        $this->assertEquals($expected, $response->getStatusCode());
    }

    public function test_email_unique()
    {
        $input = ['name' => 'Nail Yapparov', 'password' => 'admin123', 'email' => 'nail.95.kz@mail.ru'];
        $response = $this->postJson('/api/users', $input);
        $response->assertStatus(200);

        $response = $this->postJson('/api/users', $input);
        $response->assertStatus(422);
    }

    public function test_update()
    {
        $user = User::factory()->create();

        $changedName = 'Changed';
        $response = $this->putJson('/api/users/' . $user->id, [
            'name' => $changedName,
            'password' => $user->password
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('data.name', $changedName);
    }

    public function test_get()
    {
        $user = User::factory()->create();
        $response = $this->getJson('/api/users/' . $user->id);
        $response->assertStatus(200);
        $response->assertJsonPath('data.name', $user->name);

        $response = $this->getJson('/api/users/');
        $response->assertStatus(200);
    }

    public function test_delete()
    {
        $user = User::factory()->create();
        $response = $this->deleteJson('/api/users/' . $user->id);
        $response->assertStatus(200);
        $response->assertJsonPath('data', true);
    }

    public function create_provider()
    {
        return [
            'successfully_added' => [
                'input' => [
                    'name' => 'Nail Yapparov',
                    'password' => 'admin123',
                    'email' => 'nail.95.kz@mail.ru',
                ],
                'expected' => 200,
            ],
            'failed_during_add' => [
                'input' => [
                    'name' => 'Nail Yapparov',
                    'password' => '1',
                    'email' => 'nail.95.kz@mail.ru',
                ],
                'expected' => 422,
            ],
        ];
    }
}
