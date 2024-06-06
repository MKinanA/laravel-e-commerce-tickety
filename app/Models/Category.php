<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'icon'
    ];

    public function events() {
        return $this->hasMany(Event::class);
    }

    public function scopeSortByMostEvents($query) {
        return $query->withCount('events')->orderBy('events_count', 'desc');
    }
}
