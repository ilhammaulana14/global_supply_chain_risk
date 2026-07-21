<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('ports', function (Blueprint $table) {

            $table->integer('congestion_level')
                ->default(0);

        });
    }


    public function down(): void
    {
        Schema::table('ports', function (Blueprint $table) {

            $table->dropColumn('congestion_level');

        });
    }

};
