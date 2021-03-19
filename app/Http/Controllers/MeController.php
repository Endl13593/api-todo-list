<?php

namespace App\Http\Controllers;

use App\Exceptions\UserHasBeenTakenException;
use App\Http\Requests\MeUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(): UserResource
    {
        return new UserResource(auth()->user());
    }

    /**
     * @param MeUpdateRequest $request
     * @return UserResource
     * @throws UserHasBeenTakenException
     */
    public function update(MeUpdateRequest $request): UserResource
    {
        $input = $request->validated();
        $user = User::whereId(auth()->id())->first();
        $user = (new UserService())->update($user, $input);

        return new UserResource($user);
    }

    public function logout()
    {
        auth()->logout();
    }
}
