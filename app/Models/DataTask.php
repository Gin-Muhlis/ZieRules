<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataTask extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'task_id',
        'student_id',
        'teacher_id',
        'date',
        'description',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'data_tasks';

    protected $casts = [
        'date' => 'date',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
