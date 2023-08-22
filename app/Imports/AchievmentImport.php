<?php

namespace App\Imports;

use App\Models\Achievment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AchievmentImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Achievment([
            'name' => $row['name'],
            'point' => $row['point']
        ]);
    }
}