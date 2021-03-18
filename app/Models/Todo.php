<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Todo
 * @package App\Models
 * @property int id
 * @property string label
 * @property int user_id
 */
class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'label'
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(TodoTask::class);
    }
}
