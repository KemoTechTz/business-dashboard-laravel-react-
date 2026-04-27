<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceCatalog extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'business_id', 'name', 'category', 'description', 'price_tzs', 'duration_minutes', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
