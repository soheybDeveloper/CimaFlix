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
        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type');
            $table->string('director')->nullable();
            $table->string('cast',1500)->nullable();
            $table->string('country')->nullable();
            $table->string('date_added')->nullable();
            $table->year('release_year')->nullable();
            $table->string('rating',10)->nullable();
            $table->string('duration')->nullable();
            $table->string('listed_in')->nullable();
            $table->text('description')->nullable();
            $table->string('trailer_url')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('shows');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
};
