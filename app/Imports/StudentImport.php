<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $class = ClassStudent::whereName($row[5])->firstOrFail();
        return new Student([
            'nis' => $row[0],
            'name' => $row[1],
            'password' => Hash::make($row[2]),
            'password_show' => $row[2],
            'image' => $row[3],
            'gender' => $row[4],
            'class_id' => $class->id
        ]);
    }
}
