<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_access_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->char('client_id', 16);
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('revoked')->default(false);
            $table->dateTime('expires_at')->nullable();

            $table->foreign('client_id')->references('id')->on('oauth_clients')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oauth_access_tokens');
    }
}
