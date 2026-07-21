<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {

            $table->foreignId('country_id')->nullable()->after('id');

            $table->string('title');

            $table->text('description')->nullable();

            $table->string('source')->nullable();

            $table->string('author')->nullable();

            $table->string('url')->nullable();

            $table->string('image')->nullable();

            $table->dateTime('published_at')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {

            $table->dropColumn([
                'country_id',
                'title',
                'description',
                'source',
                'author',
                'url',
                'image',
                'published_at'
            ]);

        });
    }
};
