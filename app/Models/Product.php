<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", "slug", "description", "short_description", "price", "sale_price", "cost_price",
        "category", "brand", "sku", "barcode", "stock_quantity", "min_stock_level", "weight",
        "dimensions", "size", "colors", "image_url", "image_gallery", "is_featured", "is_active",
        "status", "rating", "reviews_count", "tags", "meta_title", "meta_description",
        "warranty_period", "created_by", "updated_by",
    ];

    protected $casts = [
        "colors" => "array",
        "image_gallery" => "array",
        "is_featured" => "boolean",
        "is_active" => "boolean",
        "price" => "decimal:2",
        "sale_price" => "decimal:2",
        "cost_price" => "decimal:2",
        "rating" => "decimal:2",
        "weight" => "decimal:2",
    ];

    public function getFormattedPriceAttribute()
    {
        return "$" . number_format($this->price, 2);
    }

    public function getFormattedSalePriceAttribute()
    {
        return $this->sale_price ? "$" . number_format($this->sale_price, 2) : null;
    }

    public function getIsOnSaleAttribute()
    {
        return !is_null($this->sale_price) && $this->sale_price < $this->price;
    }

    public function getEffectivePriceAttribute()
    {
        return $this->is_on_sale ? $this->sale_price : $this->price;
    }

    public function scopeActive($query)
    {
        return $query->where("is_active", true)->where("status", "active");
    }

    public function scopeFeatured($query)
    {
        return $query->where("is_featured", true);
    }

    public function scopeInStock($query)
    {
        return $query->where("stock_quantity", ">", 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where("stock_quantity", "<=", 0);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn("stock_quantity", "<=", "min_stock_level")
                     ->orWhere(function($q) {
                         $q->whereNull("min_stock_level")->where("stock_quantity", "<=", 10);
                     });
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where("name", "like", "%{$term}%")
              ->orWhere("description", "like", "%{$term}%")
              ->orWhere("short_description", "like", "%{$term}%")
              ->orWhere("category", "like", "%{$term}%")
              ->orWhere("brand", "like", "%{$term}%")
              ->orWhere("sku", "like", "%{$term}%")
              ->orWhere("tags", "like", "%{$term}%");
        });
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where("category", $category);
    }

    public function scopeByBrand($query, $brand)
    {
        return $query->where("brand", $brand);
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, "created_by");
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, "updated_by");
    }

    public function getIsLowStockAttribute()
    {
        $minLevel = $this->min_stock_level ?? 10;
        return $this->stock_quantity <= $minLevel && $this->stock_quantity > 0;
    }

    public function getIsOutOfStockAttribute()
    {
        return $this->stock_quantity <= 0;
    }

    public function getStockStatusAttribute()
    {
        if ($this->is_out_of_stock) {
            return "out_of_stock";
        } elseif ($this->is_low_stock) {
            return "low_stock";
        } else {
            return "in_stock";
        }
    }
}
