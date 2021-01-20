<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedirectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redirects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('redirectable_id')->nullable()->default(null);
            $table->string('redirectable_type')->nullable()->default(null);
            $table->string('redirect_this');
            $table->string('to_this');
            $table->integer('http_code')->default(301);
            $table->timestamps();

            $table->unique(['redirectable_id', 'redirectable_type', 'redirect_this', 'to_this'], 'unique_redirect');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('redirects');
    }
}
