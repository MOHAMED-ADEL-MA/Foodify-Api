<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('status', [
                'pending',
                'confirmed',
                'preparing',
                'on_the_way',
                'delivered',
                'cancelled',
            ])->default('pending');
            $table->enum('payment_method', [
                'card',
                'wallet',
                'cash_on_delivery',
            ]);
            $table->enum('payment_status', [
                'pending',
                'paid',
            ])->default('pending');
            $table->decimal('subtotal', 8, 2);
            $table->decimal('delivery_fee', 8, 2)->default(20.00);
            $table->decimal('total', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
