<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\TodoTaskStoreRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Http\Resources\TodoResource;
use App\Http\Resources\TodoTaskResource;
use App\Models\Todo;
use Countable;
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


    public function show(Todo $todo)
    {
        //aplicando o police
        $this->authorize('view', $todo);

        $todo->load('tasks');
        return new TodoResource($todo);
    }

    /**
     * @param TodoStoreRequest $request
     * @return TodoResource
     */
    public function store(TodoStoreRequest $request)
    {
        $input = $request->validated();

            $todo = auth()->user()->todos()->create($input);

        return new TodoResource($todo);

    }

    public function update(Todo $todo, TodoUpdateRequest $request)
    {
        //aplicando o police
        $this->authorize('update', $todo);

        $input = $request->validated();

    
        $todo->fill($input);
        $todo->save();

        return new TodoResource($todo->fresh());
    }

    public function destroy(Todo $todo)
    {
        //aplicando o police
        $this->authorize('destroy', $todo);

        $todo->delete();
    }

    public function addTask(Todo $todo, TodoTaskStoreRequest $request)
    {
        //aplicando o police
        $this->authorize('addTask', $todo);

        $input = $request->validated();
        $todoTask = $todo->tasks()->create($input);

        return new TodoTaskResource($todoTask);
    }
}
