<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Same schema as the comments table older tomatophp/filament-cms releases created,
     * so existing installs keep their data.
     */
    public function up(): void
    {
        if (Schema::hasTable('comments')) {
            return;
        }

        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parent_id')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->string('user_type');

            $table->unsignedBigInteger('content_id');
            $table->string('content_type');

            $table->longText('comment');
            $table->float('rate')->default(0)->nullable();

            $table->boolean('is_active')->default(1)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
