<?php

namespace App\Http\Services;

use App\Utils\TelerikDataSourceResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GridDataService
{
    private readonly TelerikDataSourceResult $telerik;
    public function __construct(TelerikDataSourceResult $telerik)
    {
        $this->telerik = $telerik;
    }

    public function getData(Request $request): JsonResponse
    {
        try {
            $decodedParams = json_decode($request->body, false, 512);
            $columns = $decodedParams->columns;
            $dataSource = $decodedParams->dataSource;

            $data = $this->telerik->read($dataSource, $columns, $decodedParams);
            return new JsonResponse($data, 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return new JsonResponse([], 400);
        }
    }
}
