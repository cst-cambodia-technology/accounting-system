<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 15)->nullable()->default(null);
            $table->string('givenName', 25);
            $table->string('middleName', 25)->nullable()->default(null);
            $table->string('familyName', 25);
            $table->string('displayName', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->rememberToken();
            $table->json('contactInfo')->nullable()->default(null);
            $table->json('contactAddr')->nullable()->default(null);
            $table->string('about', 4000)->nullable()->default(null);
            $table->enum('status',['Active','Inactive']);
            $table->integer('createdBy')->nullable()->default(null);
            $table->integer('modifiedBy')->nullable()->default(null);
            $table->timestamp('createdAt')->nullable()->default(null);
            $table->timestamp('modifiedAt')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
