<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ports', function (Blueprint $table) {

            $table->id();

$table->foreignId('country_id')
      ->constrained()
      ->cascadeOnDelete();

$table->string('name');

$table->string('city')->nullable();

$table->string('type')->default('Seaport');

$table->string('status')->default('Normal');

$table->decimal('latitude',10,7)->nullable();

$table->decimal('longitude',10,7)->nullable();

$table->integer('congestion_level')->default(0);

$table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ports');
    }
};
