<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserRepositiory extends BaseRepository
{
    public static function getModelFqcn(): Model|string
    {
        return User::class;
    }

    public function create(string $name, string $password, string $email): Model
    {
        return self::getModelFqcn()::create([
            'name' => $name,
            'password' => Hash::make($password),
            'email' => $email,
        ]);
    }

    public function update(int $id, string $name, string $password): Model|bool
    {
        $user = self::getModelFqcn()::findOrFail($id);

        $result = $user->update([
            'name' => $name,
            'password' => Hash::make($password),
        ]);

        return $result ? $user : false;
    }
}
