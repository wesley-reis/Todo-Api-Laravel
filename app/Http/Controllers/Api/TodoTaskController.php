<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TodoTaskUpdateRequest;
use App\Http\Resources\TodoTaskResource;
use App\Models\TodoTask;
use App\Http\Controllers\Controller;

class TodoTaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function update(TodoTask $todoTask, TodoTaskUpdateRequest $request)
    {
        //aplicando o police
        $this->authorize('update', $todoTask);

        $input = $request->validated();

        $todoTask->fill($input);
        $todoTask->save();

        return new TodoTaskResource($todoTask);
    }

    public function destroy(TodoTask $todoTask)
    {
        //aplicando o police
        $this->authorize('destroy', $todoTask);

        $todoTask->delete();
    }
}
