<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthRefreshTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_refresh_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->string('oauth_access_token_id', 100);
            $table->boolean('revoked')->default(false);
            $table->dateTime('expires_at')->nullable();

            $table->foreign('oauth_access_token_id')->references('id')->on('oauth_access_tokens')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oauth_refresh_tokens');
    }
}
