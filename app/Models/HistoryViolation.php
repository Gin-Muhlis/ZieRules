<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoryViolation extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['student_id', 'teacher_id', 'violation_id', 'date'];

    protected $searchableFields = ['*'];

    protected $table = 'history_violations';

    protected $casts = [
        'date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function violation()
    {
        return $this->belongsTo(Violation::class);
    }
}
