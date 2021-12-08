<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;

/**
 *
 */
class TodoController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return TodoResource::collection(auth()->user()->todos);
    }

    /**
     * @param TodoStoreRequest $request
     * @return TodoResource
     */
    public function store(TodoStoreRequest $request)
    {
        $input = $request->validated();

        if (empty($input['status'])){
            $status = $input['status'] = 'Pendente';
        }

        $todo = auth()->user()->todos()->create($input);

        return new TodoResource($todo);

    }

    public function update(Todo $todo, TodoUpdateRequest $request)
    {

        $input = $request->validated();

        if (!empty($input['status'])){
            $status = $input['status'] = 'Pendente';
        }

        $todo->fill($input);
        $todo->save();

        return new TodoResource($todo->fresh());
    }
}
