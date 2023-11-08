<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $state = $request->get('state');
        $search = $request->get('search');

        $users = User::FilterAdvance($state, $search)->where('type_user', 2)->paginate(20);

        return response()->json([
            "total" => $users->total(),
            "users" => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::where("email", $request->email)->first();

        if($user){
            return response()->json([
                'status' => false,
                'errors' => "Email ya registrado, pruebe intentando con otro."
            ], 400);
        }else{
            $user = User::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Usuario creado exitosamente'
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
