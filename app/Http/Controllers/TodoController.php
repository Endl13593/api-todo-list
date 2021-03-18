<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\TodoTaskStoreRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Http\Resources\TodoResource;
use App\Http\Resources\TodoTaskResource;
use App\Models\Todo;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return TodoResource::collection(auth()->user()->todos);
    }

    /**
     * @param Todo $todo
     * @return TodoResource
     * @throws AuthorizationException
     */
    public function show(Todo $todo): TodoResource
    {
        $this->authorize('view', $todo);

        $todo->load('tasks');
        return new TodoResource($todo);
    }

    /**
     * @param TodoStoreRequest $request
     * @return TodoResource
     */
    public function store(TodoStoreRequest $request): TodoResource
    {
        $input = $request->validated();
        $todos = auth()->user()->todos()->create($input);

        return new TodoResource($todos);
    }

    /**
     * @param TodoUpdateRequest $request
     * @param Todo $todo
     * @return TodoResource
     * @throws AuthorizationException
     */
    public function update(TodoUpdateRequest $request, Todo $todo): TodoResource
    {
        $this->authorize('update', $todo);

        $input = $request->validated();

        $todo->fill($input);
        $todo->save();

        return new TodoResource($todo->fresh());
    }

    /**
     * @param Todo $todo
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(Todo $todo)
    {
        $this->authorize('destroy', $todo);

        $todo->delete();
    }

    /**
     * @param TodoTaskStoreRequest $request
     * @param Todo $todo
     * @return TodoTaskResource
     * @throws AuthorizationException
     */
    public function addTask(TodoTaskStoreRequest $request, Todo $todo): TodoTaskResource
    {
        $this->authorize('addTask', $todo);

        $input = $request->validated();
        $todoTask = $todo->tasks()->create($input);

        return new TodoTaskResource($todoTask);
    }
}
