<?php

namespace Modules\Companies\Services;

use Illuminate\Http\Request;
use Modules\Companies\Entities\Company;
use Modules\Companies\Http\Requests\CompanyRequest;

class CompaniesService
{
    public function search(Request $request): array
    {
        $companies = [];

        // we can have a filter ( scope ) here
        // probably more filters, in the future
        if ($request->has('q')) {
            $companies = Company::query()->searchByName($request->q)->get()->toArray();
        }

        return $companies;
    }

    public function store(CompanyRequest $companyRequest)
    {
        $data = $companyRequest->validated();
        Company::create($companyRequest->validated());
    }

    public function getCompanies(Request $request)
    {
        $body = json_decode($request->body, true);

        $companies = Company::query()->with('city');

        // need to deal with filters, next thing to do
        $companies = $companies->skip($body['skip'])->take($body['take'])->get()->toArray();

        // think of better approach
        $data = [
            'data' => $companies,
            'total' => Company::count(),
        ];

        return $data;
    }
}
