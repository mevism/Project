<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Student\Entities\CourseClusterGroups;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_cluster_groups', function (Blueprint $table) {
            $table->id();
            $table->string('group');
            $table->timestamps();
        });

        $group = [
          ['group' => 'cw1'],
          ['group' => 'cw2'],
          ['group' => 'cw3'],
          ['group' => 'cw4'],
          ['group' => 'cw5'],
          ['group' => 'cw6'],
          ['group' => 'cw7'],
          ['group' => 'cw8'],
          ['group' => 'cw9'],
          ['group' => 'cw10'],
          ['group' => 'cw11'],
          ['group' => 'cw12'],
          ['group' => 'cw13'],
          ['group' => 'cw14'],
          ['group' => 'cw15'],
          ['group' => 'cw16'],
          ['group' => 'cw17'],
          ['group' => 'cw18'],
          ['group' => 'cw19'],
          ['group' => 'cw20'],
          ['group' => 'cw21'],
          ['group' => 'cw22'],
          ['group' => 'cw23'],
          ['group' => 'cw24']
        ];
        foreach ($group as $record){
            CourseClusterGroups::create($record);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_cluster_groups');
    }
};
