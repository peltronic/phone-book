<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhonenumbersTable extends Migration
{
    public function up()
    {
        Schema::create('phonenumbers', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('contact_id')->comment('Foreign key to [contacts], identifying owner of this phone number record' );
            $table->foreign('contact_id')->references('id')->on('contacts');

            $table->string('phonenumber')->comment('The phone number stored with country code, but without spaces, dashes, etc');
            $table->string('country', 2)->nullable()->comment('Country code in format ISO 3166 ALPHA-2');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('phonenumbers');
    }
}
