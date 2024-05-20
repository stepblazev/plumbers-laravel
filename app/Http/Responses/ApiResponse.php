<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse extends JsonResponse
{
    /**
     * @param $data
     * @param $status
     * @param $headers
     */
    public function __construct(public $data = null, $status = self::HTTP_OK, $headers = []) {
        parent::__construct($this->makeData(), $status, $headers);
    }

    /**
     * @return array
     */
    private function makeData(): array
    {
        return [
            'success' => true,
            'data' => $this->data,
            'error' => null,
        ];
    }
}