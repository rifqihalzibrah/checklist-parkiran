<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('checklists', function (Blueprint $table) {
            $table->string('time')->nullable();
            $table->string('brand')->nullable();
            $table->string('plate')->nullable();
            $table->string('mirror')->nullable();
            $table->string('disc')->nullable();
            $table->string('jacket')->nullable();
            $table->string('tire')->nullable();
            $table->string('helmet')->nullable();
            $table->text('vehicle_condition')->nullable();
            $table->text('notes')->nullable();

            $table->enum('status', ['draft', 'submitted', 'revisi', 'approved'])->default('draft');
            $table->boolean('chief_approved')->default(false);
            $table->boolean('supervisor_approved')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('checklists', function (Blueprint $table) {
            $table->dropColumn([
                'time',
                'brand',
                'plate',
                'mirror',
                'disc',
                'jacket',
                'tire',
                'helmet',
                'vehicle_condition',
                'notes',
                'status',
                'chief_approved',
                'supervisor_approved'
            ]);
        });
    }
};
