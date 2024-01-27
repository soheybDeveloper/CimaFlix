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
        Schema::create('fav_list_shows', function (Blueprint $table) {
            $table->unsignedBigInteger('favorite_list_id');
            $table->unsignedBigInteger('show_id');

            $table->primary(['favorite_list_id', 'show_id']);
            $table->foreign('favorite_list_id')->references('id')->on('_favorite_list')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('show_id')->references('id')->on('shows')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fav_list_shows');
    }
};
