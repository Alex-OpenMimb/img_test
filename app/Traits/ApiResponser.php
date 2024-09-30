<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

trait ApiResponser
{
    protected function response($data, $code)
    {
        return response()->json(['data' => $data], $code);
    }

    protected function successResponse($data, $message = null, $code = 200)
    {
        return response()->json([
            'data'          => $data,
            'message'       => $message,
            'response'      => true,
            'code'          => $code,
        ]);
    }

    protected function errorResponse($message, $code, $response = false)
    {
        return response()->json([
            'error'         => $message,
            'response'      => $response,
            'code'          => $code,
        ]);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        if ($collection->isEmpty()) {
            return $this->response(['data' => $collection], $code);
        }
        $collection = $this->filterData($collection);
        $collection = $this->sortBy($collection);
        // $collection = $this->paginate($collection);
        return $this->response($collection, $code);
    }

    protected function showOne(Model $instance, $code = 200)
    {
        return $this->response($instance, $code);
    }

    protected function token($message, $response = true ,$code = 200)
    {
        return response()->json([
            'status'    => $message,
            'response'  => $response,
            'code'      => $code,
        ]);
    }

    protected function showMessage($message, $code = 200, $response = true)
    {
        return response()->json([
            'message'       => $message,
            'response'      => $response,
            'code'          => $code,
        ]);
    }

    protected function sortBy(Collection $collection) {
        if (request()->has('password')){
            return $collection;
        }
        if (request()->has('sort_by')){
            $attribute = request()->sort_by;
            $collection = $collection->sortBy->{$attribute};
        }
        return $collection->values();
    }

    protected function filterData(Collection $collection) {
        foreach (request()->query() as $key => $value){
            $attribute = $key;
            if (isset($attribute, $value)){
                if ($attribute != 'sort_by' and $attribute != 'page' and $attribute != 'per_page'){
                    $collection = $collection->where($attribute, $value);
                }
            }
        }
        return $collection;
    }
}
