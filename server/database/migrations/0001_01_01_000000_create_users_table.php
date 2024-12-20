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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('business_name')->unique();
            $table->string('business_type')->nullable();
            $table->text('business_description')->nullable();
            $table->string('business_level')->nullable();
            $table->string('image')->nullable();
            $table->string('website')->nullable();
            $table->string('address');
            $table->string('country');
            $table->string('city');
            $table->string('email')->unique();
            $table->string('support_email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('shipping')->default('0');
            $table->string('password');
            $table->decimal('balance', 15, 2)->default(0.00);
            $table->string('payment_support')->nullable();
            $table->string('stripe_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_number')->unique()->nullable();
            $table->string('api_public_key')->unique()->nullable();
            $table->string('api_secret_key')->unique()->nullable();
            $table->string('timezone');
            $table->string('language');
            $table->string('currency');
            $table->boolean('email_verified')->default(0);
            $table->string('status')->default('active');
            $table->string('role')->default('user');
            $table->string('kyc_link')->nullable();
            $table->string('kyc_status')->default('pending');
            $table->boolean('developer')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->string('verification_code')->nullable();
            $table->string('googlefa_secret')->nullable();
            $table->boolean('googlefa_status')->default(0);

            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('telegram_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('whatsapp_link')->nullable();

            $table->string('two_factor_code')->nullable();
            $table->timestamp('two_factor_expires_at')->nullable();
            $table->timestamp('last_activity')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};