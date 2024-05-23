<?php

namespace App\Services\Company;

use App\Models\Company;

class CompanyService
{
    public function __construct() {}
    
    public function exists(string $value, string $column = 'id'): bool
    {
        // ишем компанию по значению в выбранном столбце (по умолчанию - id)
        $targetCompany = Company::where($column, $value)->first();
        if ($targetCompany) {
            return true;
        }
        return false;
    }
}
