<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->search;
        $roles = Roles::where('name', 'like', '%'.$search.'%')->paginate(20);

        return response()->json([
            "total" => $roles->total(),
            "roles" => $roles,
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
        // Crear el Rol con los datos de la solicitud
        $rol = Roles::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'ROL CREADO CORRECTAMENTE',
            'rol' => $rol
        ], 200);
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
        // Busca el Rol por el ID
        $rol = Roles::findOrFail($id);
        // Actualiza el Rol con los datos de la solicitud
        $rol->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'ROL ACTUALIZADO CORRECTAMENTE',
            'rol' => $rol
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Busca el Rol por el ID
        $rol = Roles::findOrFail($id);

        // Elimina el Rol
        $rol->delete();

        return response()->json([
            'status' => true,
            'message' => 'ROL ELIMINADO CORRECTAMENTE',
            'rol' => $rol
        ], 200);
    }
}
