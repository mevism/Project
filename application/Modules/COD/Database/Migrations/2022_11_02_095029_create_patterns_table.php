<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\COD\Entities\Pattern;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patterns', function (Blueprint $table) {
            $table->id();
            $table->integer('season_code');
            $table->string('season');
            $table->timestamps();
            $table->softDeletes();
        });

       $seasons = [
           ['season_code' => 1, 'season' => 'Semester I',],
           ['season_code' => 2, 'season' => 'Semester II',],
           ['season_code' => 3, 'season' => 'Long Holiday',],
           ['season_code' => 3, 'season' => 'Internal Attachment',],
           ['season_code' => 3, 'season' => 'Industrial Attachment' ],
       ];

        foreach ($seasons as $season){

            DB::table('patterns')->insert($season);

        }
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patterns');
    }
};
