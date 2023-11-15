<?php

namespace App\Models\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImages extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "name",
        "image",
        "type",
        "size",
        "product_id"
    ];

    public function setCreatedAtAttribute($value){
        // date_default_timezone_set("America/Lima"); // Esta configuración afecta a toda la aplicación
        $this->attributes['created_at'] = Carbon::now('America/Argentina/Buenos_Aires'); // Esta configuración solo afecta a esta perte del código
    }

    public function setUpdateAtAttribute($value){
        // date_default_timezone_set("America/Lima"); // Esta configuración afecta a toda la aplicación
        $this->attributes['updated_at'] = Carbon::now('America/Argentina/Buenos_Aires'); // Esta configuración solo afecta a esta perte del código
    }

    public function product(){
        return $this->belongTo(Products::class);
    }
}