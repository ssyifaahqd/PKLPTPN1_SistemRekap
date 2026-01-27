<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private function dbName(): string
    {
        $row = DB::selectOne("SELECT DATABASE() AS db");
        return $row->db ?? '';
    }

    private function foreignKeyExists(string $table, string $column): bool
    {
        $dbName = $this->dbName();

        $result = DB::selectOne("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = ?
              AND TABLE_NAME = ?
              AND COLUMN_NAME = ?
              AND REFERENCED_TABLE_NAME IS NOT NULL
            LIMIT 1
        ", [$dbName, $table, $column]);

        return !is_null($result);
    }

    public function up(): void
    {
        /**
         * =========================================================
         * 1) ALTER TABLE pendapatan
         * =========================================================
         */
        Schema::table('pendapatan', function (Blueprint $table) {
            if (!Schema::hasColumn('pendapatan', 'period_code')) {
                $table->string('period_code', 7)->index(); // 2025-01
            }

            if (!Schema::hasColumn('pendapatan', 'unit_id')) {
                $table->unsignedBigInteger('unit_id')->nullable()->index();
            }

            if (!Schema::hasColumn('pendapatan', 'revenue_category_id')) {
                $table->unsignedBigInteger('revenue_category_id')->index();
            }

            if (!Schema::hasColumn('pendapatan', 'description')) {
                $table->string('description')->nullable();
            }

            if (!Schema::hasColumn('pendapatan', 'amount')) {
                $table->decimal('amount', 15, 2)->default(0);
            }

            if (!Schema::hasColumn('pendapatan', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->index();
            }

            // timestamps
            $hasCreatedAt = Schema::hasColumn('pendapatan', 'created_at');
            $hasUpdatedAt = Schema::hasColumn('pendapatan', 'updated_at');
            if (!$hasCreatedAt && !$hasUpdatedAt) {
                $table->timestamps();
            }
        });

        /**
         * FK pendapatan (dibuat hanya kalau belum ada)
         * - unit_id -> unit.id (SET NULL)
         * - revenue_category_id -> kategori_pendapatan.id (RESTRICT)
         * - created_by -> users.id (SET NULL)
         */
        if (Schema::hasColumn('pendapatan', 'unit_id') && !$this->foreignKeyExists('pendapatan', 'unit_id')) {
            Schema::table('pendapatan', function (Blueprint $table) {
                $table->foreign('unit_id')
                    ->references('id')->on('unit')
                    ->nullOnDelete();
            });
        }

        if (Schema::hasColumn('pendapatan', 'revenue_category_id') && !$this->foreignKeyExists('pendapatan', 'revenue_category_id')) {
            Schema::table('pendapatan', function (Blueprint $table) {
                $table->foreign('revenue_category_id')
                    ->references('id')->on('kategori_pendapatan')
                    ->restrictOnDelete();
            });
        }

        if (Schema::hasColumn('pendapatan', 'created_by') && !$this->foreignKeyExists('pendapatan', 'created_by')) {
            Schema::table('pendapatan', function (Blueprint $table) {
                $table->foreign('created_by')
                    ->references('id')->on('users')
                    ->nullOnDelete();
            });
        }

        /**
         * =========================================================
         * 2) ALTER TABLE biaya
         * =========================================================
         */
        Schema::table('biaya', function (Blueprint $table) {
            if (!Schema::hasColumn('biaya', 'period_code')) {
                $table->string('period_code', 7)->index(); // 2025-01
            }

            if (!Schema::hasColumn('biaya', 'unit_id')) {
                $table->unsignedBigInteger('unit_id')->nullable()->index();
            }

            if (!Schema::hasColumn('biaya', 'expense_category_id')) {
                $table->unsignedBigInteger('expense_category_id')->index();
            }

            if (!Schema::hasColumn('biaya', 'description')) {
                $table->string('description')->nullable();
            }

            if (!Schema::hasColumn('biaya', 'amount')) {
                $table->decimal('amount', 15, 2)->default(0);
            }

            if (!Schema::hasColumn('biaya', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->index();
            }

            // timestamps
            $hasCreatedAt = Schema::hasColumn('biaya', 'created_at');
            $hasUpdatedAt = Schema::hasColumn('biaya', 'updated_at');
            if (!$hasCreatedAt && !$hasUpdatedAt) {
                $table->timestamps();
            }
        });

        /**
         * FK biaya (dibuat hanya kalau belum ada)
         * - unit_id -> unit.id (SET NULL)
         * - expense_category_id -> kategori_biaya.id (RESTRICT)
         * - created_by -> users.id (SET NULL)
         */
        if (Schema::hasColumn('biaya', 'unit_id') && !$this->foreignKeyExists('biaya', 'unit_id')) {
            Schema::table('biaya', function (Blueprint $table) {
                $table->foreign('unit_id')
                    ->references('id')->on('unit')
                    ->nullOnDelete();
            });
        }

        if (Schema::hasColumn('biaya', 'expense_category_id') && !$this->foreignKeyExists('biaya', 'expense_category_id')) {
            Schema::table('biaya', function (Blueprint $table) {
                $table->foreign('expense_category_id')
                    ->references('id')->on('kategori_biaya')
                    ->restrictOnDelete();
            });
        }

        if (Schema::hasColumn('biaya', 'created_by') && !$this->foreignKeyExists('biaya', 'created_by')) {
            Schema::table('biaya', function (Blueprint $table) {
                $table->foreign('created_by')
                    ->references('id')->on('users')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
    }
};
