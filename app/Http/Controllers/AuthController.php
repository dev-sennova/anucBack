<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\RegistroMailable;
use App\Models\Tb_asociados;
use App\Models\Tb_asociados_fincas;
use App\Models\Tb_personas;
use App\Models\Tb_usuario_rol;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'identificacion' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = request(['identificacion', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);

        $token->save();

        $userId=$user->id;

        $userDocument=$user->identificacion;

        $idPersona = Tb_personas::where('identificacion', $userDocument)
        ->orderBy('id', 'asc')
        ->value('id');

        $idAsociado = Tb_asociados::where('persona', $idPersona)
        ->orderBy('id', 'asc')
        ->value('id');

        $idAsociadoFinca = Tb_asociados_fincas::where('asociado', $idAsociado)
        ->orderBy('id', 'asc')
        ->value('id');

        $nombres = Tb_personas::where('identificacion', $userDocument)
        ->orderBy('id', 'asc')
        ->value('nombres');

        $apellidos = Tb_personas::where('identificacion', $userDocument)
        ->orderBy('id', 'asc')
        ->value('apellidos');

        $usuario_rol = Tb_usuario_rol::orderBy('tb_rol.id','asc')
        ->join("tb_rol","tb_usuario_rol.idRol","=","tb_rol.id")
        ->where('tb_usuario_rol.idUsuario','=',$userId)
        ->select('tb_usuario_rol.idRol','tb_rol.rol')
        ->get();

        $cantidad_rol = Tb_usuario_rol::orderBy('id','desc')
        ->where('tb_usuario_rol.idUsuario','=',$userId)
        ->count();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'id_usuario' => $user->id,
            'id_persona' => $idPersona,
            'id_asociado' => $idAsociado,
            'id_asociados_finca' => $idAsociadoFinca,
            'identificacion' => $user->identificacion,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'numeroRoles' => $cantidad_rol,
            'roles' => $usuario_rol
        ]);
    }
}
