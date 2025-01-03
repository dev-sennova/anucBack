<?php

namespace App\Http\Controllers;

use App\Models\Tb_asociado_permisos;
use App\Models\Tb_asociados;
use App\Models\Tb_personas;
use App\Models\Tb_usuario_rol;
use App\Models\User;
use Illuminate\Http\Request;

class Tb_personasController extends Controller
{
    public function index(Request $request)
    {
        $personas = Tb_personas::orderByRaw('CONCAT(nombres, " ", apellidos) ASC')
        ->get();

        return [
            'estado' => 'Ok',
            'personas' => $personas
        ];
    }

    public function indexOne(Request $request)
    {
        $personas = Tb_personas::orderByRaw('CONCAT(nombres, " ", apellidos) ASC')
        ->where('tb_personas.id','=',$request->id)
        ->get();

        return [
            'estado' => 'Ok',
            'personas' => $personas
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $idRol=$request->idRol;
        // if idRol = 0 -> solo persona if idRol = 3 asociado
        $encriptedPass='$2y$10$HlO4ipHoq0nktFaUdaB9KuQ8C1f3Rh.PfGexQtjhTHPR4vkNZc.Dy';

        try {
            $tb_personas=new Tb_personas();
            $tb_personas->identificacion=$request->identificacion;
            $tb_personas->nombres=$request->nombres;
            $tb_personas->apellidos=$request->apellidos;
            $tb_personas->telefono=$request->telefono;
            $tb_personas->correo=$request->correo;
            $tb_personas->whatsapp=$request->whatsapp;
            $tb_personas->facebook=$request->facebook;
            $tb_personas->instagram=$request->instagram;
            $tb_personas->fecha_nacimiento=$request->fecha_nacimiento;
            $tb_personas->tipo_documento=$request->tipo_documento;
            $tb_personas->sexo=$request->sexo;
            $tb_personas->estado_civil=$request->estado_civil;
            $tb_personas->estado=1;

            if ($tb_personas->save()) {

                $idPersona=$tb_personas->id;

                if($idRol =='0'){
                    return response()->json([
                        'estado' => 'Ok',
                        'id' => $idPersona,
                        'message' => 'Las personas han sido creadas con éxito'
                       ]);
                }else if($idRol =='3'){
                    $new_user=new User();
                    $new_user->identificacion=$request->identificacion;
                    $new_user->email=$request->correo;
                    $new_user->password=$encriptedPass;
                    if ($new_user->save()) {
                        $idUsuario = $new_user->id;
                        $new_user_rol=new Tb_usuario_rol();
                        $new_user_rol->idRol=$idRol;
                        $new_user_rol->idUsuario=$idUsuario;
                        if ($new_user_rol->save()) {

                            $new_asociado=new Tb_asociados();
                            $new_asociado -> persona=$idPersona;
                            $new_asociado -> categoria='1';

                            if ($new_asociado->save()) {
                                $idAsociado = $new_asociado->id;

                                $new_permisos=new Tb_asociado_permisos();
                                $new_permisos -> asociado=$idAsociado;
                                $new_permisos -> telefono='2';
                                $new_permisos -> correo='2';
                                $new_permisos -> whatsapp='2';
                                $new_permisos -> facebook='2';
                                $new_permisos -> instagram='2';

                                if ($new_permisos->save()) {
                                    return response()->json([
                                        'estado' => 'Ok',
                                        'id' => $idAsociado,
                                        'message' => 'El asociado ha sido creado con éxito'
                                       ]);
                                }else {
                                    return response()->json([
                                        'estado' => 'Error',
                                        'message' => 'Usuario permisos no fue creado'
                                    ]);
                                }
                            }else {
                                return response()->json([
                                    'estado' => 'Error',
                                    'message' => 'Usuario no fue creado'
                                   ]);
                            }

                        }else {
                        return response()->json([
                            'estado' => 'Error',
                            'message' => 'Usuario rol no fue creado'
                           ]);
                        }
                    } else {
                        return response()->json([
                            'estado' => 'Error',
                            'message' => 'El usuario no fue creado'
                           ]);
                    }
                }

            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Las personas no fueron creadas'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'+$e], 500);
        }

    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_personas=Tb_personas::findOrFail($request->id);
            $tb_personas->identificacion=$request->identificacion;
            $tb_personas->nombres=$request->nombres;
            $tb_personas->apellidos=$request->apellidos;
            $tb_personas->telefono=$request->telefono;
            $tb_personas->correo=$request->correo;
            $tb_personas->whatsapp=$request->whatsapp;
            $tb_personas->facebook=$request->facebook;
            $tb_personas->instagram=$request->instagram;
            $tb_personas->fecha_nacimiento=$request->fecha_nacimiento;
            $tb_personas->tipo_documento=$request->tipo_documento;
            $tb_personas->sexo=$request->sexo;
            $tb_personas->estado_civil=$request->estado_civil;
            $tb_personas->estado='1';

            if ($tb_personas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'id' => $tb_personas->id,
                    'message' => 'Las personas se actualizaron con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Las personas no fueron actualizadas'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function deactivate(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_personas=Tb_personas::findOrFail($request->id);
            $tb_personas->estado='0';

            if ($tb_personas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Las personas han sido desactivadas con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Las personas no fueron desactivadas'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }

    public function activate(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        try {
            $tb_personas=Tb_personas::findOrFail($request->id);
            $tb_personas->estado='1';

            if ($tb_personas->save()) {
                return response()->json([
                    'estado' => 'Ok',
                    'message' => 'Las personas han sido activadas con éxito'
                   ]);
            } else {
                return response()->json([
                    'estado' => 'Error',
                    'message' => 'Las personas no fueron activadas'
                   ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error interno'], 500);
        }

    }
}
