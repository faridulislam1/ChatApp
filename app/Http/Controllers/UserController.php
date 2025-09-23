<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
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



    public function index()
    {
        return view('users.index');
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('id', 'name', 'email', 'created_at');
            return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function($row){
                return $row->created_at->format('Y-m-d'); 
            })
            ->addColumn('action', function($row){
                return '<a href="/users/'.$row->id.'" class="btn btn-sm btn-primary">View</a>';
                return '<a  href="/users/'.$row->id.'/edit" class="btn btn-sm btn-warning">Edit</a>';
            })
            ->rawColumns(['action'])
            ->make(true);

    }
    }

}
