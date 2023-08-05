<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataViolation extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'student_id',
        'violation_id',
        'teacher_id',
        'date',
        'description',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'data_violations';

    protected $casts = [
        'date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function violation()
    {
        return $this->belongsTo(Violation::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
