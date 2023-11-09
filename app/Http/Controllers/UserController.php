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

        $users = User::FilterAdvance($state, $search)->where('type_user', 2)->orderBy("id", "desc")->paginate(20);

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
            $user['state'] = 1;
            return response()->json([
                'status' => true,
                'message' => 'Usuario creado exitosamente',
                'user' => $user
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
        $user = User::where("email", $request->email)->where("id", "<>", $id)->first();

        if($user){
            return response()->json([
                'status' => false,
                'errors' => "Error al intentar actualizar los datos del usuario"
            ], 400);
        }else{
            $user = User::findOrFail($id);
            $user->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Usuario actualizado exitosamente',
                'user' => $user
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if(!$user){
            return response()->json([
                'status' => false,
                'errors' => "Error al intentar eliminar al usuario"
            ], 400);
        }else{

            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'Usuario eliminado exitosamente'
            ], 200);
        }
    }
}
