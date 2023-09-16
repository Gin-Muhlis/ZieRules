<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Holiday extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['date'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date' => 'date',
    ];
}
