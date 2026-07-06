<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('posts', 'content')) {
            return;
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->dropFullText(['title', 'excerpt', 'content']);
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE posts CHANGE content markdown LONGTEXT NOT NULL');
        } else {
            Schema::table('posts', function (Blueprint $table) {
                $table->renameColumn('content', 'markdown');
            });
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->fullText(['title', 'excerpt', 'markdown']);
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('posts', 'markdown')) {
            return;
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->dropFullText(['title', 'excerpt', 'markdown']);
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE posts CHANGE markdown content LONGTEXT NOT NULL');
        } else {
            Schema::table('posts', function (Blueprint $table) {
                $table->renameColumn('markdown', 'content');
            });
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->fullText(['title', 'excerpt', 'content']);
        });
    }
};
