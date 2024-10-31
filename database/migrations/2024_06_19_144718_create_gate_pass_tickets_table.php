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
        Schema::create('gate_pass_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket')->unique();
            $table->foreignId('user_id');
            $table->bigInteger('approved_user_id')->nullable();
            $table->bigInteger('checked_user_id')->nullable();
            $table->string('company_name');
            $table->string('company_address');
            $table->string('company_employee');
            $table->string('company_vehno');
            $table->string('status');
            $table->date('date_approval')->nullable();
            $table->date('date_verify')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gate_pass_tickets');
    }
};
