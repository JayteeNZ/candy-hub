<?php

namespace GetCandy\Http\Controllers\Api\Products;

use GetCandy\Exceptions\InvalidLanguageException;
use GetCandy\Exceptions\MinimumRecordRequiredException;
use GetCandy\Http\Controllers\Api\BaseController;
use GetCandy\Http\Requests\Api\ProductVariants\CreateRequest;
use GetCandy\Http\Requests\Api\ProductVariants\DeleteRequest;
use GetCandy\Http\Requests\Api\ProductVariants\UpdateRequest;
use GetCandy\Http\Transformers\Fractal\Products\ProductTransformer;
use GetCandy\Http\Transformers\Fractal\Products\ProductVariantTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductVariantController extends BaseController
{
    /**
     * Handles the request to show all product families
     * @param  Request $request
     * @return Json
     */
    public function index(Request $request)
    {
        $paginator = app('api')->productVariants()->getPaginatedData($request->per_page);
        return $this->respondWithCollection($paginator, new ProductVariantTransformer);
    }

    /**
     * Handles the request to show a product family based on hashed ID
     * @param  String $id
     * @return Json
     */
    public function show($id)
    {
        try {
            $product = app('api')->productFamilies()->getByHashedId($id);
        } catch (ModelNotFoundException $e) {
            return $this->errorNotFound();
        }
        return $this->respondWithItem($product, new ProductVariantTransformer);
    }

    /**
     * Handles the request to create the variants
     * @param  CreateRequest $request
     * @return Json
     */
    public function store($product, CreateRequest $request)
    {
        try {
            $result = app('api')->productVariants()->create($product, $request->variants);
        } catch (HttpException $e) {
            return $this->errorUnprocessable($e->getMessage());
        } catch (NotFoundHttpException $e) {
            return $this->errorNotFound();
        }
        return $this->respondWithItem($result, new ProductTransformer);
    }

    /**
     * Handles the request to update a product family
     * @param  String        $id
     * @param  UpdateRequest $request
     * @return Json
     */
    public function update($id, UpdateRequest $request)
    {
        try {
            $result = app('api')->productVariants()->update($id, $request->all());
        } catch (NotFoundHttpException $e) {
            return $this->errorNotFound();
        } catch (InvalidLanguageException $e) {
            return $this->errorUnprocessable($e->getMessage());
        } catch (ModelNotFoundException $e) {
            return $this->errorNotFound();
        }
        return $this->respondWithItem($result, new ProductVariantTransformer);
    }



    /**
     * Handles the request to delete a product family
     * @param  String        $id
     * @param  DeleteRequest $request
     * @return Json
     */
    public function destroy($id, DeleteRequest $request)
    {
        try {
            $result = app('api')->productFamilies()->delete($id);
        } catch (MinimumRecordRequiredException $e) {
            return $this->errorUnprocessable($e->getMessage());
        } catch (NotFoundHttpException $e) {
            return $this->errorNotFound();
        }
        return $this->respondWithNoContent();
    }
}
