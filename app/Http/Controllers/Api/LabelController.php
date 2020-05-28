<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\LabelRequest;
use App\Http\Resources\Label\LabelCollection;
use App\Http\Resources\Label\LabelResource;
use App\Label;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LabelController extends ApiBaseController
{
    private $label;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Label $label)
    {
        $this->middleware(['auth:api']);
        $this->label = $label;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response['data'] =  (new LabelCollection(Label::paginate()))->response()->getData(true);

        return $this->success($response, 'Labels List', Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LabelRequest $request)
    {
        try{       
            $this->label = $this->label->create(['user_id' => Auth::id(), 'name' => $request->name]);
        }
        catch (Exception $e) {
            logger($e);
            return $this->error('', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        $response['data'] = new LabelResource($this->label);

        return $this->success($response, 'New label created', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        $response['data'] = new LabelResource($label);

        return $this->success($response, 'Label details', Response::HTTP_OK);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(LabelRequest $request, Label $label)
    {
        try{       
            $label->update(['user_id' => Auth::id(), 'name' => $request->name]);
        }
        catch (Exception $e) {
            logger($e);
            return $this->error('', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        $response['data'] = new LabelResource($label);

        return $this->success($response, 'Label updated', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        $label->delete();
        return $this->success(['data' => []], 'Label deleted', Response::HTTP_OK);
    }
}
