<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('tasks', 'zadatak_rada_en')) {
                $table->text('zadatak_rada_en')->nullable();
            }

            if (!Schema::hasColumn('tasks', 'naziv_rada_en')) {
                $table->string('naziv_rada_en')->nullable();
            }
            
            // dodaj što želiš, ali BEZ renameColumn
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn([
                'zadatak_rada_en',
                'naziv_rada_en',
            ]);
        });
    }

};
