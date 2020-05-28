<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\TaskRequest;
use App\Http\Resources\Task\TaskCollection;
use App\Http\Resources\Task\TaskResource;
use App\Task;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends ApiBaseController
{
    private $task;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->middleware(['auth:api']);
        $this->task = $task;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response['data'] =  (new TaskCollection(Task::paginate()))->response()->getData(true);

        return $this->success($response, 'Tasks List', Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        try{       
            $this->task->createModel($request->validated());
        }
        catch (Exception $e) {
            logger($e);
            return $this->error('', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        $response['data'] = new TaskResource($this->task);

        return $this->success($response, 'New task created', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $response['data'] = new TaskResource($task);

        return $this->success($response, 'Task details', Response::HTTP_OK);   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Task $task)
    {
        try{       
            $task->updateModel($request->validated());
        }
        catch (Exception $e) {
            logger($e);
            return $this->error('', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        $response['data'] = new TaskResource($task);

        return $this->success($response, 'Task updated', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return $this->success(['data' => []], 'Task deleted', Response::HTTP_OK);
    }
}
