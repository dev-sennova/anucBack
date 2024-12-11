<?php

namespace App\Http\Controllers;

use App\Models\Tb_asociado_permisos;
use App\Models\Tb_asociados;
use App\Models\Tb_asociados_fincas;
use App\Models\Tb_fincas;
use App\Models\Tb_personas;
use App\Models\Tb_produccion;
use App\Models\Tb_usuario_rol;
use App\Models\User;
use Illuminate\Http\Request;

class UtilidadesController extends Controller
{
    //Función creación masiva de usuarios de prueba
    public function crearUsuariosPrueba(Request $request){
        $ciclos=$request->cantidad;
        $usuariosCreados = [];
        $valores = [1, 5, 10, 12, 13];

        $cantidadTest=Tb_personas::where('tb_personas.nombres','=','UsuarioTest')->count();

        for($i=1; $i<=$ciclos; $i++){

            $cantidadTest=$cantidadTest+1;
            $encriptedPass='$2y$10$HlO4ipHoq0nktFaUdaB9KuQ8C1f3Rh.PfGexQtjhTHPR4vkNZc.Dy';
            $identificacion=$cantidadTest.$cantidadTest.$cantidadTest;

            try {
                $tb_personas=new Tb_personas();
                $tb_personas->identificacion=$identificacion;
                $tb_personas->nombres='UsuarioTest';
                $tb_personas->apellidos=$cantidadTest;
                $tb_personas->telefono=$identificacion;
                $tb_personas->correo='usuarioTest'.$cantidadTest.'@test.co';
                $tb_personas->whatsapp=$identificacion;
                $tb_personas->facebook='n/a';
                $tb_personas->instagram='n/a';
                $tb_personas->fecha_nacimiento='2024-12-10';
                $tb_personas->tipo_documento=1;
                $tb_personas->sexo=1;
                $tb_personas->estado_civil=1;
                $tb_personas->estado=1;

                if ($tb_personas->save()) {

                    $idPersona=$tb_personas->id;
                    $new_user=new User();
                    $new_user->identificacion=$identificacion;
                    $new_user->email='usuarioTest'.$cantidadTest.'@test.co';
                    $new_user->password=$encriptedPass;
                    if ($new_user->save()) {
                        $idUsuario = $new_user->id;
                        $new_user_rol=new Tb_usuario_rol();
                        $new_user_rol->idRol=3;
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

                                    $new_finca=new Tb_fincas();
                                    $new_finca -> nombre='FincaTest'.$cantidadTest;
                                    $new_finca -> extension=10;
                                    $new_finca -> vereda=1;

                                    if($new_finca->save()){
                                        $idFinca = $new_finca->id;

                                        $new_asociado_finca=new Tb_asociados_fincas();
                                        $new_asociado_finca->finca=$idFinca;
                                        $new_asociado_finca->asociado=$idAsociado;
                                        $new_asociado_finca->tipo_predio=1;

                                        if($new_asociado_finca->save()){
                                            $idAsociadoFinca = $new_asociado_finca->id;

                                            $valorAleatorio = $valores[array_rand($valores)];
                                            $new_produccion=new Tb_produccion();
                                            $new_produccion->produccion=150;
                                            $new_produccion->periodicidad=1;
                                            $new_produccion->producto=$valorAleatorio;
                                            $new_produccion->medida=3;
                                            $new_produccion->asociados_finca=$idAsociadoFinca;

                                            if($new_produccion->save()){
                                                $usuariosCreados[] = [
                                                    'idAsociado' => $idAsociado,
                                                    'identificacion' => $identificacion,
                                                    'idProducto' => $valorAleatorio
                                                ];
                                            }else{
                                                return response()->json([
                                                    'estado' => 'Error',
                                                    'message' => 'Producción no fue creada'
                                                ]);
                                            }
                                        }else{
                                            return response()->json([
                                                'estado' => 'Error',
                                                'message' => 'Finca asociación no fue creada'
                                            ]);
                                        }
                                    }else{
                                        return response()->json([
                                            'estado' => 'Error',
                                            'message' => 'Finca no fue creada'
                                        ]);
                                    }
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
        return response()->json([
            'estado' => 'Ok',
            'message' => 'Usuarios creados con éxito',
            'usuarios' => $usuariosCreados,
        ]);
    }
}
