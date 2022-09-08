<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
<<<<<<<< HEAD:application/Modules/COD/Database/Migrations/2022_09_07_120120_create_progressions_table.php
        Schema::create('progressions', function (Blueprint $table) {
            $table->id();

========
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
>>>>>>>> 011c3dfa700ff8ff99cb216ec7544e0646e749be:application/Modules/Registrar/Database/Migrations/2022_08_21_121644_create_groups_table.php
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
<<<<<<<< HEAD:application/Modules/COD/Database/Migrations/2022_09_07_120120_create_progressions_table.php
        Schema::dropIfExists('progressions');
========
        Schema::dropIfExists('groups');
>>>>>>>> 011c3dfa700ff8ff99cb216ec7544e0646e749be:application/Modules/Registrar/Database/Migrations/2022_08_21_121644_create_groups_table.php
    }
};
