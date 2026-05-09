<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
    ];

    /**
     * Get all tasks for this category
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get completed tasks count
     */
    public function getCompletedTasksCount(): int
    {
        return $this->tasks()->where('status', 'Completed')->count();
    }

    /**
     * Get total tasks count
     */
    public function getTotalTasksCount(): int
    {
        return $this->tasks()->count();
    }

    /**
     * Get progress percentage
     */
    public function getProgressPercentage(): int
    {
        $total = $this->getTotalTasksCount();
        if ($total === 0) {
            return 0;
        }
        return (int)(($this->getCompletedTasksCount() / $total) * 100);
    }
}