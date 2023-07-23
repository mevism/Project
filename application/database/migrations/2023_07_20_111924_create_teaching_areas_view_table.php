<?php

use Illuminate\Support\Facades\DB;
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
        DB::statement(
            "CREATE VIEW teachingareasview AS
            SELECT 
            teaching_areas.user_id, staff_infos.title, staff_infos.first_name, staff_infos.middle_name, staff_infos.last_name, units.unit_code, units.unit_name, units.type, units.department_id
            FROM teaching_areas
            JOIN staff_infos ON staff_infos.user_id = teaching_areas.user_id
            JOIN units ON units.unit_code = teaching_areas.unit_code;"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teaching_areas_view');
    }
};
