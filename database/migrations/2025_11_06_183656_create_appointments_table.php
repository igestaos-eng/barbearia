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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('barber_id')->constrained('barbers')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->dateTime('scheduled_at');
            $table->dateTime('completed_at')->nullable();
            $table->integer('duration_minutes');
            $table->enum('status', ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show'])->default('pending');
            $table->text('notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->decimal('price', 10, 2);
            $table->boolean('reminder_sent')->default(false);
            $table->timestamp('reminder_sent_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['barber_id', 'scheduled_at']);
            $table->index(['customer_id', 'scheduled_at']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
