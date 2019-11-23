<?php

namespace App\Exports;

use App\Models\FangOwner;
use Maatwebsite\Excel\Concerns\FromCollection;

class FangownerExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return FangOwner::all();
    }
}
