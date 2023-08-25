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
//        DB::statement(
//            "CREATE VIEW workloadview AS
//            SELECT
//            workloads.workload_id, approve_workloads.workload_approval_id, approve_workloads.dean_status, approve_workloads.dean_remarks, approve_workloads.registrar_status, approve_workloads.registrar_remarks, workloads.department_id, departments.name, academicdepartments.school_id, workloads.intake_id, workloads.user_id, workloads.unit_id, workloads.class_code, approve_workloads.status
//            FROM approve_workloads
//            JOIN workloads ON workloads.workload_approval_id =  approve_workloads.workload_approval_id
//            JOIN departments ON departments.department_id = workloads.department_id
//            JOIN academicdepartments ON academicdepartments.department_id = departments.department_id"
//        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workload_views');
    }
};
