<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        if (Aaran\Aadmin\Src\Customise::hasMaster()) {

            Schema::create('contacts', function (Blueprint $table) {
                $table->id();
                $table->string('vname');
                $table->string('mobile')->nullable();
                $table->string('whatsapp')->nullable();
                $table->string('contact_person')->nullable();
                $table->string('contact_type')->nullable();
                $table->string('msme_no')->nullable();
                $table->string('msme_type')->nullable();
                $table->decimal('opening_balance')->nullable();
                $table->string('effective_from')->nullable();
                $table->string('active_id', 3)->nullable();
                $table->foreignId('user_id')->references('id')->on('users');
                $table->timestamps();
            });

            Schema::create('contact_details', function (Blueprint $table) {
                $table->id();
                $table->foreignId('contact_id')->references('id')->on('contacts');
                $table->string('address_type')->nullable();
                $table->string('address_1')->nullable();
                $table->string('address_2')->nullable();
                $table->foreignId('city_id')->references('id')->on('commons');
                $table->foreignId('state_id')->references('id')->on('commons');
                $table->foreignId('pincode_id')->references('id')->on('commons');
                $table->foreignId('country_id')->references('id')->on('commons');
                $table->string('gstin')->nullable();
                $table->string('email')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_details');

        Schema::dropIfExists('contacts');
    }
};