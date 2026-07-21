<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ports', function (Blueprint $table) {

            $table->foreignId('country_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            $table->string('name')->nullable();

            $table->string('code')->nullable();

            $table->decimal('latitude',10,7)->nullable();

            $table->decimal('longitude',10,7)->nullable();

            $table->string('type')->nullable();

            $table->boolean('status')->default(true);

        });
    }

    public function down(): void
    {
        Schema::table('ports', function (Blueprint $table) {

            $table->dropForeign(['country_id']);

            $table->dropColumn([
                'country_id',
                'name',
                'code',
                'latitude',
                'longitude',
                'type',
                'status'
            ]);

        });
    }
};
