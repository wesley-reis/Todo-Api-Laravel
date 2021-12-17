<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Http\Requests\MeAvatarRequest;
use App\Http\Requests\MeUptadeRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use App\Services\AvatarService;

class MeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return new UserResource(auth()->user());
    }

    public function update(MeUptadeRequest $request)
    {
        $input = $request->validated();

        $user = (new UserService())->update( auth()->user(), $input);

        return new UserResource($user);
    }

}
