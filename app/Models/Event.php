<?php

namespace App\Models;

use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'headline',
        'description',
        'start_time',
        'location',
        'duration',
        'is_popular',
        'photos',
        'type',
        'category_id'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'photos' => 'array'
    ];

    public function tickets(): HasMany {
        return $this->hasmany(Ticket::class);
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function getStartFromAttribute() {
        return $this->tickets()->orderBy('price')->first()?->price;
    }

    public function getThumbnailAttribute() {
        $photos = $this->photos;

        if ($photos && !empty($photos)) {
            return Storage::url($photos[0]);
        }

        return asset('assets/images/event-1.webp');
    }

    public function scopeWithCategory($query, $category) {
        return $query->where('category_id', $category);
    }

    public function scopeUpcoming($query) {
        return $query->orderBy('start_time', 'asc')->where('start_time', '>=', now());
    }

    public function scopeFetch($query, $slug) {
        return $query->with(['category', 'tickets'])->withCount('tickets')->where('slug', $slug)->firstOrFail();
    }
}
