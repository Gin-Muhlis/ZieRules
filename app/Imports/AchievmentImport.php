<?php

namespace App\Imports;

use App\Models\Achievment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AchievmentImport implements ToCollection, WithHeadingRow
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
            Achievment::create([
                'name' => $row['name'],
                'point' => $row['point']
            ]);
        }
    }
}