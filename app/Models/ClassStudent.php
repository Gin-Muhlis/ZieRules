<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassStudent extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'code'];

    protected $searchableFields = ['*'];

    protected $table = 'class_students';

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function homerooms()
    {
        return $this->hasMany(Homeroom::class, 'class_id');
    }
}
