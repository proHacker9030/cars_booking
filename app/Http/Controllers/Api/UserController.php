<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\UserRepositiory;
use http\Exception\RuntimeException;

class UserController extends Controller
{
    public function __construct(private UserRepositiory $userRepositiory)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['data' => User::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $user = $this->userRepositiory->create(
            $request->input('name'),
            $request->input('password'),
            $request->input('email')
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
        return response()->json(['data' => User::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, int $id)
    {
        $result = $this->userRepositiory->update(
            $id,
            $request->input('name'),
            $request->input('password'),
        );
        if (!$result) {
            throw new RuntimeException('Ошибка обновления пользователя');
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
        $result = User::destroy($id);
        if (!$result) {
            throw new RuntimeException('Ошибка удаления пользователя');
        }

        return response()->json(['data' => true]);
    }

    public function getCar(int $id)
    {
        $user = User::with('car')->findOrFail($id);
        if (is_null($user->car)) {
            abort(404, 'Автомобиль не найден у пользователя');
        }

        return response()->json(['data' => $user->car]);
    }
}
