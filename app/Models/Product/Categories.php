<?php

namespace App\Models\Product; // Se agregó la extensión "\Product" ya que el archivo se encuentra dentro del directorio "Product"

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use HasFactory;
    use SoftDeletes; // Habilita la funcionalidad de eliminación suave

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'image',
        'icon'
    ];

    public function setCreatedAtAttribute($value){
        // date_default_timezone_set("America/Lima"); // Esta configuración afecta a toda la aplicación
        $this->attributes['created_at'] = Carbon::now('America/Argentina/Buenos_Aires'); // Esta configuración solo afecta a esta perte del código
    }

    public function setUpdateAtAttribute($value){
        // date_default_timezone_set("America/Lima"); // Esta configuración afecta a toda la aplicación
        $this->attributes['updated_at'] = Carbon::now('America/Argentina/Buenos_Aires'); // Esta configuración solo afecta a esta perte del código
    }
}
