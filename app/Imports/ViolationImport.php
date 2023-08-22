<?php

namespace App\Imports;

use App\Models\Violation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ViolationImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Violation([
            'name' => $row['name'],
            'point' => $row['point']
        ]);
    }
}
