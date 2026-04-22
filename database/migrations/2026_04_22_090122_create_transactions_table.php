<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('restrict'); // يمنع حذف الفئة إذا كانت مرتبطة بمعاملات
            $table->decimal('amount', 12, 2); // المبلغ بدقة مالية
            $table->enum('type', ['income', 'expense']);
            $table->date('date'); // تاريخ المعاملة
            $table->string('description')->nullable(); // وصف اختياري
            $table->timestamps();

            // فهرس لتحسين أداء الاستعلامات حسب التاريخ والمستخدم
            $table->index(['user_id', 'date']);
        });

        // القيود الدفاعية على مستوى PostgreSQL
        DB::statement("ALTER TABLE transactions ADD CONSTRAINT check_transactions_amount_positive CHECK (amount > 0)");
        DB::statement("ALTER TABLE transactions ADD CONSTRAINT check_transactions_type CHECK (type IN ('income', 'expense'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};