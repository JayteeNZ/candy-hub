<?php

namespace GetCandy\Http\Controllers\Api;

use GetCandy\Api\Exceptions\MinimumRecordRequiredException;
use GetCandy\Http\Requests\Api\Taxes\CreateRequest;
use GetCandy\Http\Requests\Api\Taxes\DeleteRequest;
use GetCandy\Http\Requests\Api\Taxes\UpdateRequest;
use GetCandy\Http\Transformers\Fractal\TaxTransformer;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaxController extends BaseController
{
    /**
     * Returns a listing of currencies
     * @return Json
     */
    public function index(Request $request)
    {
        $paginator = app('api')->taxes()->getPaginatedData($request->per_page);
        return $this->respondWithCollection($paginator, new TaxTransformer);
    }

    /**
     * Handles the request to show a currency based on it's hashed ID
     * @param  String $id
     * @return Json
     */
    public function show($id)
    {
        try {
            $currency = app('api')->taxes()->getByHashedId($id);
        } catch (ModelNotFoundException $e) {
            return $this->errorNotFound();
        }
        return $this->respondWithItem($currency, new TaxTransformer);
    }

    /**
     * Handles the request to create a new channel
     * @param  CreateRequest $request
     * @return Json
     */
    public function store(CreateRequest $request)
    {
        $result = app('api')->taxes()->create($request->all());
        return $this->respondWithItem($result, new TaxTransformer);
    }

    /**
     * Handles the request to update taxes
     * @param  String        $id
     * @param  UpdateRequest $request
     * @return Json
     */
    public function update($id, UpdateRequest $request)
    {
        try {
            $result = app('api')->taxes()->update($id, $request->all());
        } catch (MinimumRecordRequiredException $e) {
            return $this->errorUnprocessable($e->getMessage());
        } catch (NotFoundHttpException $e) {
            return $this->errorNotFound();
        }
        return $this->respondWithItem($result, new TaxTransformer);
    }

    /**
     * Handles the request to delete a tax
     * @param  String        $id
     * @param  DeleteRequest $request
     * @return Json
     */
    public function destroy($id, DeleteRequest $request)
    {
        try {
            $result = app('api')->taxes()->delete($id);
        } catch (MinimumRecordRequiredException $e) {
            return $this->errorUnprocessable($e->getMessage());
        } catch (NotFoundHttpException $e) {
            return $this->errorNotFound();
        }
        return $this->respondWithNoContent();
    }
}
