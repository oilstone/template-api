<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthClientRedirectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_client_redirects', function (Blueprint $table) {
            $table->id();
            $table->char('client_id', 16);
            $table->text('uri');

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
        Schema::dropIfExists('oauth_client_redirects');
    }
}
