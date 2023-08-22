<?php

namespace App\Imports;

use App\Models\ClassStudent;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentImport implements ToModel, WithHeadingRow, WithValidation
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
    public function model(array $row)
    {
        $validator = Validator::make($row, [
            'name' => ['required', 'max:255', 'string'],
            'nis' => ['required', 'unique:students,nis', 'digits:9', 'numeric'],
            'password' => ['required'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'class' => ['required'],
        ]);

        if ($validator->fails()) {
            return null;
        }

        $class = ClassStudent::whereName($row['class'])->first();

        if (!isset($class)) {
            return null;
        }

        return new Student([
            'nis' => $row['nis'],
            'name' => $row['name'],
            'password' => Hash::make($row['password']),
            'password_show' => $row['password'],
            'gender' => $row['gender'],
            'class_id' => $class->id,
        ]);
    }
}