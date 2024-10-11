<?php

namespace App\Imports;

use App\Models\ClassStudent;
use App\Models\Homeroom;
use App\Models\Teacher;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithValidation;
use DateTime;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class TeacherImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'unique:teachers,email', 'email'],
            'image' => ['nullable', 'image', 'max:1024'],
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

        try {
            foreach ($rows as $key => $row) {
                $validator = Validator::make($row->toArray(), [
                    'name' => ['required', 'max:255', 'string'],
                    'email' => ['required', 'unique:teachers,email', 'email'],
                    'gender' => ['required', 'in:laki-laki,perempuan'],
                    'role' => ['required', 'in:guru-mapel,wali-kelas'],
                    'class' => ['string', 'nullable'],
                ], [
                    'name.required' => 'Nama siswa tidak boleh kosong',
                    'name.max' => 'Nama siswa tidak boleh melebihi 255 karakter',
                    'name.string' => 'Nama siswa harus berupa string',
                    'email.required' => 'email siswa tidak boleh kosong',
                    'email.unique' => 'email telah digunakan, tidak diperbolehkan sama',
                    'email.email' => 'email tidak valid',
                    'gender.required' => 'Gender siswa tidak boleh kosong',
                    'gender.in' => 'Gender siswa tidak valid',
                    'role.required' => 'Role tidak boleh kosong',
                    'role.in' => 'Role tidak valid',
                ]);

                if ($validator->fails()) {
                    abort(500, 'Terjadi kesalahan dengan data yang diimport');
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
        } catch (Exception $e) {
            abort('500', $e->getMessage());
        }
    }

    private function generatePassword()
    {
        $now = new DateTime();
        $time = (string) $now->getTimestamp();
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