<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
  public function activateUsers()
{
    $inactiveUsers = DB::table('users')
        ->where('status', 0)
        ->get();

    DB::table('users')
        ->where('status', 0)
        ->lazyById()
        ->each(function (object $user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update(['status' => 0]);
        });

    $activatedUsers = DB::table('users')
        ->whereIn('id', $inactiveUsers->pluck('id'))
        ->get();

    return response()->json([
        'message' => 'All inactive users have been activated successfully.',
        'activated_users' => $activatedUsers
    ]);
}


}
