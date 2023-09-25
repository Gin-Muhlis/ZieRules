<?php

namespace App\Imports;

use App\Models\ClassStudent;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'nis' => ['required', 'unique:students,nis', 'digits:9', 'numeric'],
            'password' => ['required'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'class' => ['required'],
        ];
    }


    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $row = $row->toArray();
         
            $validator = Validator::make($row, [
                'name' => ['required', 'max:255', 'string'],
                'nis' => ['required', 'unique:students,nis', 'digits:9', 'numeric'],
                'password' => ['required'],
                'gender' => ['required', 'in:laki-laki,perempuan'],
                'class' => ['required'],
                'code' => ['required'],
            ]);

            if ($validator->fails()) {
                return null;
            }
            $class = ClassStudent::whereName($row['class'])->first();

            if (!isset($class)) {
                return null;
            }
            Student::create([
                'nis' => $row['nis'],
                'name' => $row['name'],
                'password' => Hash::make($row['password']),
                'password_show' => $row['password'],
                'gender' => $row['gender'],
                'class_id' => $class->id,
                'code' => $row['code'],
                'image' => 'public/default.jpg'
            ]);
        }
    }
}
