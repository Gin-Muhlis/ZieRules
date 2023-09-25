<?php

namespace App\Imports;

use App\Models\Violation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ViolationImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            Violation::create([
                'name' => $row['name'],
                'point' => $row['point']
            ]);
        }
    }
}
