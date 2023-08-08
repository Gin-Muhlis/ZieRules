<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Violation extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'point'];

    protected $searchableFields = ['*'];

    public function dataViolations()
    {
        return $this->hasMany(DataViolation::class);
    }

    public function historyViolations()
    {
        return $this->hasMany(HistoryViolation::class);
    }
}
