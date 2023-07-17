<?php

namespace App\Actions\FilamentCompanies;

use App\Models\Company;
use App\Models\Folder;
use Wallo\FilamentCompanies\Contracts\DeletesCompanies;

class DeleteCompany implements DeletesCompanies
{
    /**
     * Delete the given company.
     */
    public function delete(Company $company): void
    {
        $folders = Folder::where('company_id',$company->id)->get();
        foreach ($folders as $folder){
            if (!empty($folder->embedded_id)){
                deleteVector($folder->embedded_id);
            }
        }

        $company->purge();
    }
}
