<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ports', function (Blueprint $table) {

            if (!Schema::hasColumn('ports', 'city')) {
                $table->string('city')->nullable()->after('name');
            }

            if (!Schema::hasColumn('ports', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable();
            }

            if (!Schema::hasColumn('ports', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable();
            }

            if (!Schema::hasColumn('ports', 'congestion_level')) {
                $table->integer('congestion_level')->default(0);
            }

        });
    }

    public function down(): void
    {
        Schema::table('ports', function (Blueprint $table) {

            $table->dropColumn([
                'city',
                'latitude',
                'longitude',
                'congestion_level'
            ]);

        });
    }
};
