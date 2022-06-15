<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenominationsTable extends Migration
{
    public function up()
    {
        Schema::create('denominations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['billete','moneda','otro'])->default('billete');
            $table->string('value',45);
            $table->string('image',80)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('denominations');
    }
}
