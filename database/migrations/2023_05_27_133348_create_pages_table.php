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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->text('about_heading');
            $table->text('about_content');
            $table->tinyInteger('about_status')->default(1);
            $table->text('terms_heading');
            $table->text('terms_content');
            $table->tinyInteger('terms_status')->default(1);
            $table->text('privacy_heading');
            $table->text('privacy_content');
            $table->tinyInteger('privacy_status')->default(1);
            $table->text('contact_heading');
            $table->text('contact_map')->nullable();
            $table->tinyInteger('contact_status')->default(1);
            $table->text('photo_gallery_heading');
            $table->tinyInteger('photo_gallery_status')->default(1);
            $table->text('video_gallery_heading');
            $table->tinyInteger('video_gallery_status')->default(1);
            $table->text('faq_heading');
            $table->tinyInteger('faq_status')->default(1);
            $table->text('blog_heading');
            $table->tinyInteger('blog_status')->default(1);
            $table->text('room_heading');
            $table->text('cart_heading');
            $table->tinyInteger('cart_status')->default(1);
            $table->text('checkout_heading');
            $table->tinyInteger('checkout_status')->default(1);
            $table->text('payment_heading');
            $table->text('signup_heading');
            $table->tinyInteger('signup_status')->default(1);
            $table->text('signin_heading');
            $table->tinyInteger('signin_status')->default(1);
            $table->text('forget_password_heading');
            $table->text('reset_password_heading');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};