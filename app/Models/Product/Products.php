<?php

namespace App\Models\Product;

use App\Models\Product\Categories;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "title",
        "slug",
        "sku",
        "price_peso",
        "price_usd",
        "tags",
        "description",
        "summary",
        "state",
        "image",
        "stock",
        "categorie_id"
    ];

    public function setCreatedAtAttribute($value){
        // date_default_timezone_set("America/Lima"); // Esta configuración afecta a toda la aplicación
        $this->attributes['created_at'] = Carbon::now('America/Argentina/Buenos_Aires'); // Esta configuración solo afecta a esta perte del código
    }

    public function setUpdateAtAttribute($value){
        // date_default_timezone_set("America/Lima"); // Esta configuración afecta a toda la aplicación
        $this->attributes['updated_at'] = Carbon::now('America/Argentina/Buenos_Aires'); // Esta configuración solo afecta a esta perte del código
    }

    public function categorie(){
        return $this->belongsTo(Categories::class);
    }

    public function images(){
        return $this->hasMany(ProductImages::class);
    }

    public function sizes(){
        return $this->belongsTo(ProductSizes::class);
    }
}
