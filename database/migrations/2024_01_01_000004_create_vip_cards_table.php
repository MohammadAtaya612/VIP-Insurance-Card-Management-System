<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vip_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('membership_number', 50)->unique();
            $table->enum('card_type', ['silver', 'gold']);
            $table->decimal('price', 10, 2);
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->dateTime('issued_at');
            $table->dateTime('expires_at');
            $table->string('qr_token', 64)->unique();
            $table->foreignId('issued_by')->constrained('users');
            $table->dateTime('renewed_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->text('cancelled_reason')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('card_type');
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vip_cards');
    }
};
