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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name'); // Company name (up to 255 characters)
            $table->string('company_short_name')->nullable(); // Optional short name
            $table->unsignedBigInteger('industry_id')->nullable(); // Foreign key (Industry)
            $table->string('business_reg_no', 50)->nullable(); // Business registration number (limit to 50 characters)
            $table->string('address_1')->nullable(); // Address line 1
            $table->string('address_2')->nullable(); // Address line 2
            $table->unsignedBigInteger('city_id')->nullable(); // Foreign key (City)
            $table->unsignedBigInteger('province_id')->nullable(); // Foreign key (Province)
            $table->unsignedBigInteger('country_id')->nullable(); // Foreign key (Country)
            $table->string('postal_code', 10)->nullable(); // Postal code (limit to 10 characters)
            $table->string('contact_1', 15)->nullable(); // Primary contact number (15 characters)
            $table->string('contact_2', 15)->nullable(); // Secondary contact number
            $table->string('email')->nullable(); // Email address
            $table->string('epf_reg_no', 50)->nullable(); // EPF registration number
            $table->string('tin_no', 50)->nullable(); // Tax Identification Number (TIN)
            $table->unsignedBigInteger('admin_contact_id')->nullable(); // Foreign key (Admin contact)
            $table->unsignedBigInteger('billing_contact_id')->nullable(); // Foreign key (Billing contact)
            $table->unsignedBigInteger('primary_contact_id')->nullable(); // Foreign key (Primary contact)
            $table->string('logo')->nullable(); // Logo file path
            $table->string('logo_small')->nullable(); // Small logo file path
            $table->string('website')->nullable(); // Company website URL 

            $table->string('status')->nullable();  
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
        Schema::dropIfExists('companies');
    }
};