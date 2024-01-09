<?php

namespace App\Imports;

use App\Models\ClassStudent;
use App\Models\Homeroom;
use App\Models\Teacher;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithValidation;
use DateTime;

class TeacherImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:teachers,email', 'email'],
            'image' => ['nullable', 'image', 'max:1024'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'role' => ['required', 'in:guru-mapel,wali-kelas'],
            'class' => ['string', 'nullable'],
        ];
    }
    /**
     * @param Collection $rows
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $validator = Validator::make($row->toArray(), [
                'name' => ['required', 'max:255', 'string'],
                'email' => ['required', 'unique:teachers,email', 'email'],
                'image' => ['nullable', 'image', 'max:1024'],
                'gender' => ['required', 'in:laki-laki,perempuan'],
                'role' => ['required', 'in:guru-mapel,wali-kelas'],
                'class' => ['string', 'nullable'],
            ]);
    
            if ($validator->fails()) {
                return null;
            }
            $teacher = Teacher::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => Hash::make($this->generatePassword()),
                'password_show' => $this->generatePassword(),
                'gender' => $row['gender'],
                'image' => 'public/default.jpg'
            ]);
    
            $teacher->assignRole($row['role']);
    
            if ($teacher->hasRole('wali-kelas')) {
                $class = ClassStudent::whereCode($row['class'])->first();
    
                if (!isset($class)) {
                    return null;
                }
    
                Homeroom::create([
                    'teacher_id' => $teacher->id,
                    'class_id' => $class->id
                ]);
            }
    
        }
        
        
    }

    private function generatePassword() {
        $now = new DateTime();
        $time = (string)$now->getTimestamp();
        $year = $now->format('Y');
    
        $str = $year . $time;
        $arrayStr = str_split($str);
    
        for ($i = count($arrayStr) - 1; $i > 0; $i--) {
            $n = floor(mt_rand(0, $i));
            list($arrayStr[$i], $arrayStr[$n]) = array($arrayStr[$n], $arrayStr[$i]);
        }
    
        $password = implode('', array_splice($arrayStr, 0, 9));
    
        return $password;
    }
    
}