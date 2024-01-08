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

            $password = $this->generatePassword();
            
            $student = Student::create([
                'nis' => $row['nis'],
                'name' => $row['name'],
                'password' => Hash::make($password),
                'password_show' => $password,
                'gender' => $row['gender'],
                'class_id' => $class->id,
                'code' => $this->generateCode($row['nis']),
                'image' => 'public/default.jpg'
            ]);

            $student->assignRole('siswa');
        }
    }

    private function generatePassword() {
        $now = new \DateTime();
        $time = $now->getTimestamp();
        $year = $now->format('Y');
    
        $str = $year . $time;
        $arrayStr = str_split($str);
    
        for ($i = count($arrayStr) - 1; $i > 0; $i--) {
            $n = random_int(0, $i);
            [$arrayStr[$i], $arrayStr[$n]] = [$arrayStr[$n], $arrayStr[$i]];
        }
    
        $password = implode('', array_slice($arrayStr, 0, 9));
    
        return $password;
    }

    private function generateCode($nis) {
        $splitNis = str_split($nis);
    
        for ($i = count($splitNis) - 1; $i > 0; $i--) {
            $n = random_int(0, $i);
            [$splitNis[$i], $splitNis[$n]] = [$splitNis[$n], $splitNis[$i]];
        }
    
        $randomNum = mt_rand(10, 99);
    
        $code = implode('', $splitNis) . $randomNum;
    
        return $code;
    }
}
