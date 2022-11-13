<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Model;

class CarRepository extends BaseRepository
{
    public static function getModelFqcn(): Model|string
    {
        return Car::class;
    }

    public function create(string $brand, string $model): Car
    {
        return self::getModelFqcn()::create([
            'brand' => $brand,
            'model' => $model,
        ]);
    }

    public function update(int $id, string $brand, string $model): Model|bool
    {
        $car = self::getModelFqcn()::findOrFail($id);

        $result = $car->update([
            'brand' => $brand,
            'model' => $model,
        ]);

        return $result ? $car : false;
    }
}
