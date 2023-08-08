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

    public function homerooms()
    {
        return $this->hasMany(Homeroom::class);
    }

    public function historyScans()
    {
        return $this->hasMany(HistoryScan::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }
}
