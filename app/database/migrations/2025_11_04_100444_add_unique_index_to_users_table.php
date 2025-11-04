<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        DB::table('users as u')
            ->join(DB::raw('(
        SELECT email, MAX(id) AS max_id
        FROM users
        GROUP BY email
        HAVING COUNT(*) > 1
    ) as dups'), 'u.email', '=', 'dups.email')
            ->whereColumn('u.id', '<>', 'dups.max_id')
            ->update([
                'u.email' => DB::raw("CONCAT('_', u.email)")
            ]);

        $oldUsers = User::where('email', 'like', '\_%')
            ->get();

        $oldUsers->each(
            fn($user) => $user->delete()
        );

        Schema::table('users', function (Blueprint $table) {
            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['email']);
        });

        $oldUsers = User::withTrashed()->where('email', 'like', '\_%')->get();

        $oldUsers->each(
            fn($user) => $user->restore()
        );

        DB::table('users')
            ->where('email', 'like', '\_%')
            ->update([
                'email' => DB::raw("SUBSTRING(email, 2)")
            ]);
    }
};
