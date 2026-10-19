<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('card_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vip_card_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('service_type'); // نوع الخدمة
            $table->decimal('cost', 10, 2)->default(0); // التكلفة
            $table->text('notes')->nullable(); // ملاحظات
            $table->timestamp('used_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('card_usages');
    }
};