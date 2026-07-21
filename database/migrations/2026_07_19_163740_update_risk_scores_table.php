<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('risk_scores', function (Blueprint $table) {

            $table->integer('port_score')->default(0);

        });
    }

    public function down(): void
    {
        Schema::table('risk_scores', function (Blueprint $table) {

            $table->dropColumn('port_score');

        });
    }
};
