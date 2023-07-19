<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function client(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'client' => Auth::user(),
        ], 200);
    }

    public function edit(Request $request)
    {
        $user = Auth::user();

        if (isset($request->name)) $user->name = $request->name;
        if (isset($request->email)) $user->email = $request->email;
        if (isset($request->phone)) $user->phone = $request->phone;
        if (isset($request->birthday)) $user->birthday = $request->birthday;
        if (isset($request->address)) $user->address = $request->address;
        if (isset($request->surname)) $user->surname = $request->surname;

        $user->save();
        return response()->json([
            'status' => 'success',
            'client' => $user,
        ], 200);
    }

}
