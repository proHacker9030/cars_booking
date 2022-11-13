<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarBookRequest;
use App\Repositories\CarBookRepository;

class CarBookController extends Controller
{
    public function __construct(private CarBookRepository $carBookRepository)
    {
    }

    public function book(CarBookRequest $request)
    {
        $book = $this->carBookRepository->createBook(
            $request->input('user_id'),
            $request->input('car_id')
        );

        return response()->json(['data' => $book]);
    }

    public function deleteBook(CarBookRequest $request)
    {
        $result = $this->carBookRepository->deleteBook(
            $request->input('user_id'),
            $request->input('car_id')
        );

        return response()->json(['data' => $result]);
    }
}
