<?php

namespace App\Services\Company;

use App\Models\Company;

class CompanyService
{
    public function __construct() {}
    
    public function exists(string $companyName): bool
    {
        // ишем компанию по ее названию
        $targetCompany = Company::where('name', $companyName)->first();
        if ($targetCompany) {
            return true;
        }
        return false;
    }
    
    public function create($adminId, $companyName): Company|null
    {
        // создаем новую компанию для нужного админа
        $company = new Company();
        $company->admin_id = $adminId;
        $company->name = $companyName;
        $company->save();
        
        return $company;
    }
}
