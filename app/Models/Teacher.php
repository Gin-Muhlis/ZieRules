<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasRoles;
    use HasFactory;
    use Searchable;
    use HasApiTokens;

    protected $fillable = [
        'email',
        'name',
        'password',
        'password_show',
        'image',
        'gender',
    ];

    protected $guard_name = 'web';
    protected $guard = 'teacher_api';

    protected $searchableFields = ['*'];

    protected $hidden = ['password'];

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

    public function homeroom()
    {
        return $this->hasOne(Homeroom::class);
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

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
}
