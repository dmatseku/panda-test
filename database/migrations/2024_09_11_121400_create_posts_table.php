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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('sku')->unique();
            $table->float('price');
            $table->timestamps();
        });

        Schema::create('posts_subscribers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id')->unsigned();
            $table->unsignedBigInteger('subscriber_id')->unsigned();
            $table->timestamps();

            $table->index(['post_id', 'subscriber_id']);
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('subscriber_id')->references('id')->on('subscribers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_subscribers');
        Schema::dropIfExists('posts');
    }
};
