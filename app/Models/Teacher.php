<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'image', 'gender', 'user_id'];

    protected $searchableFields = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function homerooms()
    {
        return $this->hasMany(Homeroom::class);
    }

    public function historyScans()
    {
        return $this->hasMany(HistoryScan::class);
    }
}
