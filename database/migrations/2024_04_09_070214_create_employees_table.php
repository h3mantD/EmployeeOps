<?php

declare(strict_types=1);

use App\Enums\EmployeeType;
use App\Enums\LastOperationType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number', 10)->unique()->nullable();
            $table->string('password');
            $table->enum('type', EmployeeType::values())->default(EmployeeType::SUPER_ADMIN);
            $table->rememberToken();
            $table->enum('last_operation', LastOperationType::values())->default(LastOperationType::CREATE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
