<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Homeroom extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['teacher_id', 'class_id'];

    protected $searchableFields = ['*'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassStudent::class, 'class_id');
    }
}
