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
            "CREATE VIEW staffview AS 
            SELECT
            user_employments.user_id, user_employments.role_id, departments.name, departments.department_id, user_employments.station_id, user_employments.employment_terms, staff_infos.staff_number, staff_infos.title, staff_infos.gender, staff_infos.first_name, staff_infos.middle_name, staff_infos.last_name, staff_infos.phone_number, staff_infos.office_email, staff_infos.personal_email, user_employments.created_at
            FROM user_employments
            JOIN staff_infos ON staff_infos.user_id = user_employments.user_id
            JOIN departments ON departments.department_id = user_employments.department_id;"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS staffview');
    }
};
