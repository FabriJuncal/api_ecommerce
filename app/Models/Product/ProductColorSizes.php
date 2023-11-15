<?php

namespace App\Models\product;

use App\Models\Product\ProductColors;
use App\Models\Product\ProductSizes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductColorSizes extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "stock",
        "product_color_id",
        "product_size_id"
    ];

    public function setCreatedAtAttribute($value){
        // date_default_timezone_set("America/Lima"); // Esta configuración afecta a toda la aplicación
        $this->attributes['created_at'] = Carbon::now('America/Argentina/Buenos_Aires'); // Esta configuración solo afecta a esta perte del código
    }

    public function setUpdateAtAttribute($value){
        // date_default_timezone_set("America/Lima"); // Esta configuración afecta a toda la aplicación
        $this->attributes['updated_at'] = Carbon::now('America/Argentina/Buenos_Aires'); // Esta configuración solo afecta a esta perte del código
    }

    public function product_color(){
        return $this->belongTo(ProductColors::class);
    }

    public function product_size(){
        return $this->belongTo(ProductSizes::class);
    }
}
