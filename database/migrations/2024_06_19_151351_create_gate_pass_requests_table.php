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
        Schema::create('gate_pass_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id');
            $table->bigInteger('quantity');
            $table->string('unit');
            $table->string('desc');
            $table->string('remark')->nullable();
            $table->string('company_item');
            $table->text('image_url')->nullable();
            $table->text('checked_image_url')->nullable();
            $table->text('note')->nullable();
            $table->text('note_s')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gate_pass_requests');
    }
};
