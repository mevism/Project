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
            "CREATE VIEW academicdepartments AS
SELECT
    departments.department_id,
    departments.division_id,
    school_departments.school_id,
    departments.dept_code,
    departments.name,
    departments.created_at
FROM departments
JOIN school_departments ON school_departments.department_id = departments.department_id;
"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academicdepartments');
    }
};
