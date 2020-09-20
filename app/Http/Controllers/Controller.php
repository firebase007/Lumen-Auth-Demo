<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Return generic json response with the given data.
     *
     * @param $data
     * @param int $statusCode
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($data, $statusCode = 200, $status = true, $message='success')
    {
        return response($data, $statusCode, $status, $message);
    }

    /**
     * Respond with success.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondSuccess()
    {
        return $this->respond(null, 204, 'success', true);
    }

    /**
     * Respond with failure.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondFailure()
    {
        return $this->respond(null, 500, false, 'error');
    }

    /**
     * Paginate and filter a collection of items
     *
     * @param Collection $collection
     * @param int $offset
     * @return Collection
     */
    protected function paginate(Collection $collection, $offset = 0)
    {
        if (sizeof($collection)) {
            $offset = app('request')->get('offset', $offset);
            $limit = app('request')->get('limit', $collection->first()->getPerPage());

            if (app('request')->has('offset')) {
                $collection = $collection->slice($offset, $limit)->values();
            }
        }
        return $collection;
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }
}
