<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataAchievment extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'achievment_id',
        'student_id',
        'teacher_id',
        'date',
        'description',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'data_achievments';

    protected $casts = [
        'date' => 'date',
    ];

    public function achievment()
    {
        return $this->belongsTo(Achievment::class);
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
