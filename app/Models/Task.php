<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'class', 'description'];

    protected $searchableFields = ['*'];

    public function dataTasks()
    {
        return $this->hasMany(DataTask::class);
    }

    public function historyTasks()
    {
        return $this->hasMany(HistoryTask::class);
    }
}
