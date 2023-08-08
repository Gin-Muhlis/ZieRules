<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achievment extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'point'];

    protected $searchableFields = ['*'];

    public function dataAchievments()
    {
        return $this->hasMany(DataAchievment::class);
    }

    public function historyAchievments()
    {
        return $this->hasMany(HistoryAchievment::class);
    }
}
