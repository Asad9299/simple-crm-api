<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

    /**
     * Add a common structure for all success responses.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($response)
    {
        return $response->setData([
            'code'    => 200,
            'message' => $this->message ?? 'Operation completed successfully.',
            'data'    => $response->getData(),
        ]);
    }

    /**
     * Handle error responses.
     *
     * @param  string  $message
     * @param  array|null  $errors
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function errorResponse($message = 'Something went wrong', $errors = null, $statusCode = 400)
    {
        return response()->json([
            'code'    => $statusCode,
            'message' => $message,
            'errors'  => $errors,
        ], $statusCode);
    }
}
