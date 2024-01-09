<?php

namespace App\Models;
use App\Models\Scopes\Searchable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['version', 'release_time'];

    protected $searchableFields = ['*'];
}
