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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('brand', 30);
            $table->string('model', 30);
            $table->integer('year', false, 4);
            $table->string('version', 20);
            $table->string('mileage', 10);
            $table->string('fuel', 20)->nullable();
            $table->integer('doors', false, 1);
            $table->decimal('price', 10, 2);
            $table->timestamp('date');
            $table->json('optionals')->nullable();
            $table->unsignedBigInteger('suppliers_id');
            $table->foreign('suppliers_id')->references('id')
            ->on('suppliers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
