<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoryAchievment extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['student_id', 'teacher_id', 'achievment_id', 'date'];

    protected $searchableFields = ['*'];

    protected $table = 'history_achievments';

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

    public function achievment()
    {
        return $this->belongsTo(Achievment::class);
    }
}
