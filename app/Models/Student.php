<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'image',
        'gender',
        'password_show',
        'user_id',
        'class_id',
    ];

    protected $searchableFields = ['*'];

    protected $hidden = ['password_show'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassStudent::class, 'class_id');
    }

    public function dataViolations()
    {
        return $this->hasMany(DataViolation::class);
    }

    public function dataAchievments()
    {
        return $this->hasMany(DataAchievment::class);
    }

    public function dataTasks()
    {
        return $this->hasMany(DataTask::class);
    }

    public function historyScans()
    {
        return $this->hasMany(HistoryScan::class);
    }
}
