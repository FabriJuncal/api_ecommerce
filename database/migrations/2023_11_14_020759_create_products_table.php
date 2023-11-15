<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('sku', 50);
            $table->decimal('price_peso', 10, 2); // 10 dígitos en total, 2 dígitos después del punto decimal
            $table->decimal('price_usd', 10, 2);
            $table->json('tags')->nullable();
            $table->longText('description');
            $table->text('summary');
            $table->tinyInteger('state', false, true) // 'false' indica que no es autoincremental, 'true' indica que es sin signo
            ->default(1) // Indica que el valor por defecto será "1"
            ->comment('1 = NO PUBLICO | 2 = PUBLICO | 3 = PAUSADO'); // Agrega un comentario sobre el campo
            $table->string('image');
            $table->unsignedInteger('stock')->nullable(); // Esto dobla el rango de valores no negativos que puedes almacenar en comparación con un entero normal.
                                                        // Este campo se utilizará en el caso que el producto no disponga del campo "sizes",
                                                        // ya que cuando se utiliza el campo "sizes" el stock se encontrará en la tabla "product_color_sizes"
            $table->foreignId('categorie_id')->index();
            $table->timestamps();
            $table->softDeletes(); // Agrega la columna deleted_at para soporte de eliminación suave
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
