<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->nullable()
                ->after('id')
                ->constrained('categories')
                ->nullOnDelete();

            $table->string('name')->after('category_id');
            $table->string('slug')->unique()->after('name');
            $table->text('description')->nullable()->after('slug');
            $table->decimal('price', 10, 2)->default(0)->after('description');
            $table->integer('stock')->default(0)->after('price');
            $table->string('image')->nullable()->after('stock');
            $table->boolean('active')->default(1)->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn([
                'category_id',
                'name',
                'slug',
                'description',
                'price',
                'stock',
                'image',
                'active',
            ]);
        });
    }
};
