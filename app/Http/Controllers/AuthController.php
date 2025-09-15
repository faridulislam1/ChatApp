<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use App\Models\Order;

class AuthController extends Controller
{

   public function register(Request $request)
   {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => [
            'required', 'confirmed',
            Password::min(8)->mixedCase()->numbers()->symbols()
        ],
        'role' => 'in:admin,customer,vendor' 
    ]);

    
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role ?? 'customer',
        'status' => 1, 
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'status' => 200,
        'message' => 'User registered successfully',
        'data' => [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'status' => $user->status,
            'token' => $token,
        ],
    ], 200);
   }

   public function login(Request $request)
   {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);  

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials',
            'status' => 401,
            'data' => null
        ], 401);
    }

    $user->tokens()->delete();
    $plainToken = $user->createToken('auth_token')->plainTextToken;
    $tokenParts = explode('|', $plainToken);
    $tokenOnly = $tokenParts[1] ?? $plainToken;

    return response()->json([
        'message' => 'success',
        'status' => 200,
        'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'token' => $tokenOnly,
                'super_token' => config('app.super_token'),
            ],
    ], 200);
   }

    // public function showuser(Request $request)
    // {
    //     $user = $request->user();

    //     if ($user->role === 'admin') {
            
    //         $users = User::all();
    //     } elseif ($user->role === 'vendor' || $user->role === 'customer') {
           
    //         $users = User::where('id', $user->id)->get();
    //     } else {
    //         return response()->json(['message' => 'Unauthorized'], 403);
    //     }

    //     return response()->json($users);
    //  }

    public function showuser(Request $request)
    {
        if ($request->attributes->get('super_access') === true) {
            return response()->json([
                'status' => 'success',
                'message' => 'Super access granted',
                'users' =>User::all()
            ]);
        }

        return response()->json(['status' => 'failed', 'reason' => 'No super access'], 403);
    }

    public function updateuser(Request $request, $id)
    {
        if ($request->attributes->get('super_access') === true) {
            $request->validate([
                'name'   => 'required|string|max:255',
                'email'  => "required|string|email|max:255|unique:users,email,{$id}",
                'role'   => 'required|in:admin,customer,vendor',
                'status' => 'required|integer|in:0,1,2,3,4,5,6',
            ]);
            $targetUser = User::findOrFail($id);
            $targetUser->update([
                'name'   => $request->name,
                'email'  => $request->email,
                'status' => $request->status,
                'role'   => $request->role,
            ]);
            return response()->json([
                'status'  => 200,
                'message' => 'User updated successfully by SUPER_TOKEN'
            ]);
        }
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => "required|string|email|max:255|unique:users,email,{$id}",
            'role'   => 'required|in:admin,customer,vendor',
            'status' => 'required|integer|in:0,1,2,3,4,5,6',
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        $targetUser = User::findOrFail($id);
        if ($user->role === 'admin') {
            $targetUser->update([
                'name'   => $request->name,
                'email'  => $request->email,
                'status' => $request->status,
                'role'   => $request->role,
            ]);
        } elseif ($user->id === $targetUser->id) {
            $targetUser->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json([
            'status'  => 200,
            'message' => 'User updated successfully'
        ]);
    }

    public function deleteuser(Request $request, $id)
    {
        $user = $request->user();
        $targetUser = User::find($id);

        if (!$targetUser) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($user->role !== 'admin' && $user->id !== $targetUser->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $targetUser->delete();

        return response()->json([
            'status'=>200,
            'message' => 'User deleted successfully']);
    }

    public function get_orders(Request $request)
    {
        $search = $request->query('Customer_Names'); 
        $perPage = $request->query('per_page', 10);

        if ($request->attributes->get('super_access') !== true) {
            return response()->json([
                'status' => 403,
                'message' => 'Unauthorized: invalid or missing SUPER_TOKEN'
            ], 403);
        }

        $orders = Order::query()
            ->when($search, function ($query, $search) {
                $query->where('CustomerName', 'like', "%{$search}%");
            })
            ->paginate($perPage)
            ->appends(['Customer_Names' => $search]);

        $orders->getCollection()->transform(function ($order) {
            return collect($order)->except(['created_at', 'updated_at']);
        });

        return response()->json([
            'status' => 200,
            'message' => 'Orders fetched successfully',
            'current_page' => $orders->currentPage(),
            'per_page' => $orders->perPage(),
            'total_items' => $orders->total(),
            'last_page' => $orders->lastPage(),
            'data' => $orders->items(),
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }


}
