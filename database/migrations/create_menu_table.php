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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('page_id')->nullable();
            $table->integer('order_id');
            $table->integer('parent_id')->nullable();
            $table->integer('is_dropdown_parent');
            $table->integer('show_footer');
            $table->integer('show_menu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
