<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Car;
use App\Models\CarBook;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CarBookRepository extends BaseRepository
{
    public static function getModelFqcn(): Model|string
    {
        return CarBook::class;
    }

    public function createBook(int $userId, int $carId): Model
    {
        $model = self::getModelFqcn();
        /** @var CarBook $book */
        $book = $model::where(['user_id' => $userId, 'car_id' => $carId])->firstOrNew();

        if ($book->exists()) {
            abort(403, 'В один момент времени 1 пользователь может управлять только одним автомобилем.');
        }
        if (!User::find($userId)) {
            abort(404, 'Пользователь не найден.');
        }
        if (!Car::find($carId)) {
            abort(404, 'Автомобиль не найден.');
        }

        $book->user_id = $userId;
        $book->car_id = $carId;
        $book->save();

        return $book;
    }

    public function deleteBook(int $userId, int $carId): bool
    {
        $model = self::getModelFqcn();
        /** @var CarBook $book */
        $book = $model::where(['user_id' => $userId, 'car_id' => $carId])->first();
        if (is_null($book)) {
            abort(404, 'Ошибка удаления брони автомобиля. На пользователя не забронирован данный автомобиль.');
        }

        return $book->delete();
    }
}
