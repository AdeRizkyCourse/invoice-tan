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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice', length: 20)->unique();
            $table->foreignId('id_client')->constrained('clients')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->decimal('total_harga', total: 12, places: 2);
            $table->enum('status', ['belum terbayar', 'terbayar']);
            $table->timestamps();
        });

        Schema::create('invoices_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_invoice')->constrained('invoices')->onDelete('cascade');
            $table->string('nama_barang', length: 30);
            $table->integer('jumlah');
            $table->decimal('harga_satuan', total: 12, places: 2);
            $table->decimal('total_harga', total: 12, places: 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoices_items');
    }
};
