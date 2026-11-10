<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tugas 1: Tabel Produk (id, name, description, stock, image)
     * Ditambahkan category_id (relasi ke categories) dan price agar aplikasi e-commerce berjalan utuh.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('category')->nullable(); // Untuk backward compatibility
            $table->decimal('price', 12, 2)->default(0);
            $table->text('description')->nullable();
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
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
