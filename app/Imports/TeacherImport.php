<?php

namespace App\Imports;

use App\Models\ClassStudent;
use App\Models\Homeroom;
use App\Models\Teacher;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithValidation;

class TeacherImport implements ToModel, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:teachers,email', 'email'],
            'password' => ['required'],
            'image' => ['nullable', 'image', 'max:1024'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'role' => ['required', 'in:guru-mapel,wali-kelas'],
            'class' => ['string', 'nullable'],
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
            'email' => ['required', 'unique:teachers,email', 'email'],
            'password' => ['required'],
            'image' => ['nullable', 'image', 'max:1024'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'role' => ['required', 'in:guru-mapel,wali-kelas'],
            'class' => ['string', 'nullable'],
        ]);

        if ($validator->fails()) {
            return null;
        }
        $teacher = new Teacher([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
            'password_show' => $row['password'],
            'gender' => $row['gender']
        ]);

        $teacher->assignRole($row['role']);

        if ($teacher->hasRole('wali-kelas')) {
            $class = ClassStudent::whereName($row['class'])->first();

            if (!isset($class)) {
                return null;
            }

            Homeroom::create([
                'teacher_id' => $teacher->id,
                'class_id' => $class->id
            ]);
        }

        return $teacher;
    }
}