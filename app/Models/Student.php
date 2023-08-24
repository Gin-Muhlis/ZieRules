<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasRoles;
    use HasFactory;
    use Searchable;
    use HasApiTokens;

    protected $fillable = [
        'nis',
        'name',
        'password',
        'password_show',
        'image',
        'gender',
        'class_id',
        'code',
    ];

    protected $guard_name = 'web';
    protected $guard = 'student_api';

    protected $searchableFields = ['*'];

    protected $hidden = ['password', 'password_show'];

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

    public function historyViolations()
    {
        return $this->hasMany(HistoryViolation::class);
    }

    public function historyAchievments()
    {
        return $this->hasMany(HistoryAchievment::class);
    }

    public function historyTasks()
    {
        return $this->hasMany(HistoryTask::class);
    }

    public function studentAbsences()
    {
        return $this->hasMany(StudentAbsence::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }
}
