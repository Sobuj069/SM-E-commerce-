<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'sale_price',
        'stock',
        'sku',
        'image',
        'gallery_images',
        'is_featured',
        'is_active',
        'rating',
        'reviews_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'rating' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'stock' => 'integer',
        'reviews_count' => 'integer',
        'gallery_images' => 'array',
    ];

    /**
     * Scope for active products
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured products
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class)->latest();
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true)->latest();
    }

    /**
     * Get all images combined (primary thumbnail + gallery images)
     */
    public function getAllImagesAttribute(): array
    {
        $gallery = is_array($this->gallery_images) ? $this->gallery_images : [];
        $images = [];
        if (!empty($this->image)) {
            $images[] = $this->image;
        }
        foreach ($gallery as $img) {
            if (!empty($img) && !in_array($img, $images)) {
                $images[] = $img;
            }
        }
        return !empty($images) ? $images : ['https://images.unsplash.com/photo-1518611012118-696072aa579a?w=800'];
    }

    public function getEffectivePriceAttribute()
    {
        return ($this->sale_price !== null && $this->sale_price > 0 && $this->sale_price < $this->price)
            ? $this->sale_price
            : $this->price;
    }

    public function getHasDiscountAttribute(): bool
    {
        return $this->sale_price !== null && $this->sale_price > 0 && $this->sale_price < $this->price;
    }

    public function getDiscountPercentageAttribute(): int
    {
        if (!$this->has_discount || $this->price <= 0) {
            return 0;
        }
        return (int) round((($this->price - $this->sale_price) / $this->price) * 100);
    }
}