<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoryScan extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['teacher_id', 'student_id'];

    protected $searchableFields = ['*'];

    protected $table = 'history_scans';

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
