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
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name');
            $table->text('short_description')->nullable()->after('description');
            $table->decimal('cost_price', 10, 2)->nullable()->after('sale_price');
            $table->string('barcode', 50)->nullable()->unique()->after('sku');
            $table->integer('min_stock_level')->default(10)->after('stock_quantity');
            $table->decimal('weight', 8, 2)->nullable()->after('min_stock_level');
            $table->string('dimensions', 100)->nullable()->after('weight');
            $table->string('meta_title')->nullable()->after('tags');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('warranty_period', 100)->nullable()->after('meta_description');
            $table->foreignId('created_by')->nullable()->constrained('users')->after('updated_at');
            $table->foreignId('updated_by')->nullable()->constrained('users')->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn([
                'slug',
                'short_description',
                'cost_price',
                'barcode',
                'min_stock_level',
                'weight',
                'dimensions',
                'meta_title',
                'meta_description',
                'warranty_period',
                'created_by',
                'updated_by'
            ]);
        });
    }
};
