<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarRequest;
use App\Models\Car;
use App\Repositories\CarRepository;
use http\Exception\RuntimeException;

class CarController extends Controller
{
    public function __construct(private CarRepository $carRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['data' => Car::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CarRequest $request)
    {
        $user = $this->carRepository->create(
            $request->input('brand'),
            $request->input('model')
        );

        return response()->json(['data' => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        return response()->json(['data' => Car::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CarRequest $request, int $id)
    {
        $result = $this->carRepository->update(
            $id,
            $request->input('brand'),
            $request->input('model'),
        );
        if (!$result) {
            throw new RuntimeException('Ошибка обновления автомобиля');
        }

        return response()->json(['data' => $result]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $result = Car::destroy($id);
        if (!$result) {
            throw new RuntimeException('Ошибка удаления автомобиля');
        }

        return response()->json(['data' => true]);
    }
}
