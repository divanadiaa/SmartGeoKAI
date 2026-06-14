<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('id_asset')->unique();

            $table->foreignId('province_id')->constrained()->restrictOnDelete();
            $table->foreignId('regency_id')->constrained()->restrictOnDelete();
            $table->foreignId('district_id')->constrained()->restrictOnDelete();

            $table->enum('asset_type', ['Tanah', 'Bangunan']);
            $table->enum('classification', ['ROW', 'Fasilitas', 'Operasional']);
            $table->enum('asset_group', ['Produksi', 'Non Produksi']);
            $table->enum('status', ['Clear', 'Proses', 'Masalah']);

            $table->decimal('area_m2', 15, 2)->default(0);
            $table->decimal('latitude', 15, 10);
            $table->decimal('longitude', 15, 10);

            $table->longText('description')->nullable();
            $table->text('gmaps_url')->nullable();

            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};