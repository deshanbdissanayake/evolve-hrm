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
        Schema::create('industries', function (Blueprint $table) {
            $table->id('id');
            $table->string('industry_name');
            $table->string('status')->nullable(); // Example: New field$table->dateTime('created_at');
            $table->dateTime('created_date')->nullable();
            $table->integer('created_by')->nullable();
            $table->dateTime('updated_date')->nullable();
            $table->integer('updated_by')->nullable();
            $table->dateTime('deleted_date')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industries');
    }
};
