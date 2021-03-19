<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoTaskUpdateRequest;
use App\Http\Resources\TodoTaskResource;
use App\Models\TodoTask;
use Illuminate\Auth\Access\AuthorizationException;

class TodoTaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @param TodoTaskUpdateRequest $request
     * @param TodoTask $todoTask
     * @return TodoTaskResource
     * @throws AuthorizationException
     */
    public function update(TodoTaskUpdateRequest $request, TodoTask $todoTask): TodoTaskResource
    {
        $this->authorize('update', $todoTask);

        $input = $request->validated();
        $todoTask->fill($input);
        $todoTask->save();

        return new TodoTaskResource($todoTask);
    }

    /**
     * @param TodoTask $todoTask
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(TodoTask $todoTask)
    {
        $this->authorize('update', $todoTask);
        $todoTask->delete();
    }
}
