<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

/**
 * Controlador para el manejo de autenticación y usuarios.
 */
class AuthController extends Controller
{
    /**
     * Crear un nuevo usuario en la base de datos.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {

        $rules = [
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8'
        ];
        $validator = \Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'type_user' => $request->type_user,
            'role_id' => $request->roleId,
            'password' => $request->password
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Usuario creado exitosamente',
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ], 200);
    }

    /**
     * Iniciar sesión como un usuario Admin.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginAdmin(Request $request)
    {
        $rules = [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string',
            'type_user' => 'required|in:2'
        ];
        $validator = \Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        if (!Auth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ])) {
            return response()->json([
                'status' => false,
                'errors' => ['No autorizado']
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        // Accede al nombre del rol a través de la relación
        $user->role->all();

        return response()->json([
            'status' => true,
            'message' => 'Usuario ha iniciado sesión exitosamente',
            'user' => $user,
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ], 200);
    }

    /**
     * Iniciar sesión como un usuario Ecommerce.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginEcommerce(Request $request)
    {
        $rules = [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string'
        ];
        $validator = \Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        if (!Auth::attempt([
            "email" => $request->email,
            "password" => $request->password,
            "state" => 1
        ])) {
            return response()->json([
                'status' => false,
                'errors' => ['No autorizado']
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        return response()->json([
            'status' => true,
            'message' => 'Usuario ha iniciado sesión exitosamente',
            'user' => $user,
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ], 200);
    }

    /**
     * Cerrar sesión para el usuario actual y revocar los tokens.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        // Elimina el token de la tabla "personal_tokens"
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Usuario ha cerrado sesión exitosamente',
        ], 200);
    }

    /**
     * Obtiene los datos del usuario autenticado
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        // $user = Auth::user(); // Obtén el usuario autenticado actualmente
        $user = auth()->user();

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'No hay usuario autenticado'], 401);
        }
    }

    /**
     * Envía un mail para reestablecer la contraseña
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => "Le hemos enviado un correo electrónico el enlace para restablecer su contraseña."])
            : response()->json(['message' => "Ha ocurrido un error."], 400);
    }
}
