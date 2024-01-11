<?php

namespace App\Imports;

use Exception;
use App\Models\Student;
use App\Models\ClassStudent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

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
        try {
            DB::beginTransaction();
            $listImage = [];
            // HANDLE IMAGE START
            $spreadsheet = IOFactory::load(request()->file('file'));
            $i = 0;

            foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $drawing) {
                if ($drawing instanceof MemoryDrawing) {
                    ob_start();
                    call_user_func(
                        $drawing->getRenderingFunction(),
                        $drawing->getImageResource()
                    );
                    $imageContents = ob_get_contents();
                    ob_end_clean();
                    switch ($drawing->getMimeType()) {
                        case MemoryDrawing::MIMETYPE_PNG:
                            $extension = 'png';
                            break;
                        case MemoryDrawing::MIMETYPE_GIF:
                            $extension = 'gif';
                            break;
                        case MemoryDrawing::MIMETYPE_JPEG:
                            $extension = 'jpg';
                            break;
                    }
                } else {
                    $zipReader = fopen($drawing->getPath(), 'r');
                    $imageContents = '';
                    while (!feof($zipReader)) {
                        $imageContents .= fread($zipReader, 1024);
                    }
                    fclose($zipReader);
                    $extension = $drawing->getExtension();
                }

                $myFileName = time() . ++$i . '.' . $extension;
                $storage_path = storage_path('app/public/students');
                file_put_contents($storage_path . $myFileName, $imageContents);
                $image_path = $storage_path . $myFileName;


                $image_data = str_replace('E:\GIN WEB\GIN WEB\project\ZieRules\ZieRules\storage\app/', '', $image_path);

                $list_image[] = $image_data;

            }
            // HANDLE IMAGE END
            foreach ($rows as $key => $row) {
                $row = $row->toArray();

                $validator = Validator::make($row, [
                    'name' => ['required', 'max:255', 'string'],
                    'nis' => ['required', 'unique:students,nis', 'digits:9', 'numeric'],
                    'gender' => ['required', 'in:laki-laki,perempuan'],
                    'class' => ['required'],
                ], [
                    'name.required' => 'Nama siswa tidak boleh kosong',
                    'name.max' => 'Nama siswa tidak boleh melebihi 255 karakter',
                    'name.string' => 'Nama siswa harus berupa string',
                    'nis.required' => 'NIS siswa tidak boleh kosong',
                    'nis.digits' => 'NIS siswa harus 9 digit',
                    'nis.numeric' => 'NIS siswa harus berupa angka',
                    'password.required' => 'Password tidak boleh kosong',
                    'gender.required' => 'Gender siswa tidak boleh kosong',
                    'gender.in' => 'Gender siswa tidak valid',
                ]);

                if ($validator->fails()) {
                    abort(500, $validator->errors()->first());
                }
                $class = ClassStudent::whereCode($row['class'])->first();

                if (!isset($class)) {
                    abort(500, 'Terjadi kesalahan karena ada data kelas yang tidak ditemukan');
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
                    'image' => $list_image[$key] ?? 'public/default.jpg'
                ]);

                $student->assignRole('siswa');
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            abort('500', $e->getMessage());
        }
    }

    private function generatePassword()
    {
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

    private function generateCode($nis)
    {
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
