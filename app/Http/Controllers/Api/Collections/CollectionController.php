<?php

namespace GetCandy\Http\Controllers\Api\Collections;

use GetCandy\Http\Controllers\Api\BaseController;
use GetCandy\Http\Requests\Api\Collections\CreateRequest;
use GetCandy\Http\Requests\Api\Collections\DeleteRequest;
use GetCandy\Http\Requests\Api\Collections\UpdateRequest;
use GetCandy\Http\Transformers\Fractal\Collections\CollectionTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CollectionController extends BaseController
{
    /**
     * Returns a listing of channels
     * @return Json
     */
    public function index(Request $request)
    {
        $paginator = app('api')->collections()->getPaginatedData($request->per_page);
        return $this->respondWithCollection($paginator, new CollectionTransformer);
    }

    /**
     * Handles the request to show a channel based on it's hashed ID
     * @param  String $id
     * @return Json
     */
    public function show($id)
    {
        try {
            $channel = app('api')->collections()->getByHashedId($id);
        } catch (ModelNotFoundException $e) {
            return $this->errorNotFound();
        }
        return $this->respondWithItem($channel, new CollectionTransformer);
    }

    /**
     * Handles the request to create a new channel
     * @param  CreateRequest $request
     * @return Json
     */
    public function store(CreateRequest $request)
    {
        $result = app('api')->collections()->create($request->all());
        return $this->respondWithItem($result, new CollectionTransformer);
    }

    /**
     * Handles the request to update  a channel
     * @param  String        $id
     * @param  UpdateRequest $request
     * @return Json
     */
    public function update($id, UpdateRequest $request)
    {
        try {
            $result = app('api')->collections()->update($id, $request->all());
        } catch (NotFoundHttpException $e) {
            return $this->errorNotFound();
        }
        return $this->respondWithItem($result, new CollectionTransformer);
    }

    /**
     * Handles the request to delete a channel
     * @param  String        $id
     * @param  DeleteRequest $request
     * @return Json
     */
    public function destroy($id, DeleteRequest $request)
    {

        try {
            $result = app('api')->collections()->delete($id);
        } catch (NotFoundHttpException $e) {
            return $this->errorNotFound();
        }
        return $this->respondWithNoContent();
    }
}
