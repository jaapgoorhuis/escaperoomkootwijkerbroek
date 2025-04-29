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
        Schema::create('footer', function (Blueprint $table) {
            $table->id();
            $table->longText('column_1')->nullable();
            $table->text('column_1_type')->nullable();
            $table->longText('column_2')->nullable();
            $table->text('column_2_type')->nullable();
            $table->longText('column_3')->nullable();
            $table->text('column_3_type')->nullable();
            $table->longText('column_4')->nullable();
            $table->text('column_4_type')->nullable();
            $table->integer('show_magazine')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer');
    }
};
