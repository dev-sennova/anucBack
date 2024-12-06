<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('/verify-email','AuthController@verifyEmail')->name('verify_email');
    Route::post('/resend-email','AuthController@resendEmail')->name('resend_email');
    Route::post('register', 'AuthController@register');
    Route::get("empresa_globales_publico", "Tb_empresa_globalesController@indexPublico");
    Route::get("ofertaspublicas", "Tb_ofertaController@indexPublico");
    Route::get("producto", "Tb_productosController@index");
    Route::get("categoria", "Tb_producto_categoriasController@index");
    Route::get("unidad", "Tb_medida_unidadesController@index");

    // Las siguientes rutas además del prefijo requieren que el usuario tenga un token válido

    Route::group(['middleware' => 'auth:api'], function() {
     Route::get('logout', 'AuthController@logout');
     Route::get('user', 'AuthController@user');
     Route::post('verifypassword','AuthController@verifyPassword');
     Route::post('changepassword','AuthController@changePassword');


     Route::get("rol", "Tb_rolController@index");
     Route::post("rol/store", "Tb_rolController@store");
     Route::put("rol/update", "Tb_rolController@update");
     Route::put("rol/deactivate", "Tb_rolController@deactivate");
     Route::put("rol/activate", "Tb_rolController@activate");
     Route::get("rol/selectrol/{id}", "Tb_rolController@indexOne");

     Route::get("empresa_globales", "Tb_empresa_globalesController@index");
     Route::post("empresa_globales/store", "Tb_empresa_globalesController@store");
     Route::put("empresa_globales/update", "Tb_empresa_globalesController@update");
     Route::put("empresa_globales/deactivate", "Tb_empresa_globalesController@deactivate");
     Route::put("empresa_globales/activate", "Tb_empresa_globalesController@activate");
     Route::get("empresa_globales/selectempresa_globales/{id}", "Tb_empresa_globalesController@indexOne");
     Route::get("empresa_globales/estadisticas", "Tb_empresa_globalesController@estadisticas");

     Route::get("ciudad", "Tb_ciudadesController@index");
     Route::post("ciudad/store", "Tb_ciudadesController@store");
     Route::put("ciudad/update", "Tb_ciudadesController@update");
     Route::put("ciudad/deactivate", "Tb_ciudadesController@deactivate");
     Route::put("ciudad/activate", "Tb_ciudadesController@activate");
     Route::get("ciudad/selectciudad/{id}", "Tb_ciudadesController@indexOne");

     Route::get("estado_civil", "Tb_estado_civilController@index");
     Route::post("estado_civil/store", "Tb_estado_civilController@store");
     Route::put("estado_civil/update", "Tb_estado_civilController@update");
     Route::put("estado_civil/deactivate", "Tb_estado_civilController@deactivate");
     Route::put("estado_civil/activate", "Tb_estado_civilController@activate");
     Route::get("estado_civil/selectestado_civil/{id}", "Tb_estado_civilController@indexOne");

     //Route::get("unidad", "Tb_medida_unidadesController@index");
     Route::post("unidad/store", "Tb_medida_unidadesController@store");
     Route::put("unidad/update", "Tb_medida_unidadesController@update");
     Route::put("unidad/deactivate", "Tb_medida_unidadesController@deactivate");
     Route::put("unidad/activate", "Tb_medida_unidadesController@activate");
     Route::get("unidad/selectmedida_unidades/{id}", "Tb_medida_unidadesController@indexOne");

     Route::get("parentesco", "Tb_parentescosController@index");
     Route::post("parentesco/store", "Tb_parentescosController@store");
     Route::put("parentesco/update", "Tb_parentescosController@update");
     Route::put("parentesco/deactivate", "Tb_parentescosController@deactivate");
     Route::put("parentesco/activate", "Tb_parentescosController@activate");
     Route::get("parentesco/selectparentesco/{id}", "Tb_parentescosController@indexOne");

     //Route::get("categoria", "Tb_producto_categoriasController@index");
     Route::post("categoria/store", "Tb_producto_categoriasController@store");
     Route::put("categoria/update", "Tb_producto_categoriasController@update");
     Route::put("categoria/deactivate", "Tb_producto_categoriasController@deactivate");
     Route::put("categoria/activate", "Tb_producto_categoriasController@activate");
     Route::get("categoria/selectcategoria/{id}", "Tb_producto_categoriasController@indexOne");

     //Route::get("producto", "Tb_productosController@index");
     Route::post("producto/store", "Tb_productosController@store");
     Route::put("producto/update", "Tb_productosController@update");
     Route::put("producto/deactivate", "Tb_productosController@deactivate");
     Route::put("producto/activate", "Tb_productosController@activate");
     Route::get("producto/selectproducto/{id}", "Tb_productosController@indexOne");

     Route::get("sexo", "Tb_sexosController@index");
     Route::post("sexo/store", "Tb_sexosController@store");
     Route::put("sexo/update", "Tb_sexosController@update");
     Route::put("sexo/deactivate", "Tb_sexosController@deactivate");
     Route::put("sexo/activate", "Tb_sexosController@activate");
     Route::get("sexo/selectsexo/{id}", "Tb_sexosController@indexOne");

     Route::get("tipo_documentos", "Tb_tipo_documentosController@index");
     Route::post("tipo_documentos/store", "Tb_tipo_documentosController@store");
     Route::put("tipo_documentos/update", "Tb_tipo_documentosController@update");
     Route::put("tipo_documentos/deactivate", "Tb_tipo_documentosController@deactivate");
     Route::put("tipo_documentos/activate", "Tb_tipo_documentosController@activate");
     Route::get("tipo_documentos/selecttipo_documentos/{id}", "Tb_tipo_documentosController@indexOne");

     Route::get("tipo_predio", "Tb_tipo_predioController@index");
     Route::post("tipo_predio/store", "Tb_tipo_predioController@store");
     Route::put("tipo_predio/update", "Tb_tipo_predioController@update");
     Route::put("tipo_predio/deactivate", "Tb_tipo_predioController@deactivate");
     Route::put("tipo_predio/activate", "Tb_tipo_predioController@activate");
     Route::get("tipo_predio/selecttipo_predio/{id}", "Tb_tipo_predioController@indexOne");

     Route::get("vereda", "Tb_veredasController@index");
     Route::post("vereda/store", "Tb_veredasController@store");
     Route::put("vereda/update", "Tb_veredasController@update");
     Route::put("vereda/deactivate", "Tb_veredasController@deactivate");
     Route::put("vereda/activate", "Tb_veredasController@activate");
     Route::get("vereda/selectvereda/{id}", "Tb_veredasController@indexOne");

     Route::get("finca", "Tb_fincasController@index");
     Route::post("finca/store", "Tb_fincasController@store");
     Route::put("finca/update", "Tb_fincasController@update");
     Route::put("finca/deactivate", "Tb_fincasController@deactivate");
     Route::put("finca/activate", "Tb_fincasController@activate");
     Route::get("finca/selectfinca/{id}", "Tb_fincasController@indexOne");

     Route::get("personas", "Tb_personasController@index");
     Route::post("personas/store", "Tb_personasController@store");
     Route::put("personas/update", "Tb_personasController@update");
     Route::put("personas/deactivate", "Tb_personasController@deactivate");
     Route::put("personas/activate", "Tb_personasController@activate");
     Route::get("personas/selectpersonas/{id}", "Tb_personasController@indexOne");

     Route::get("asociados", "Tb_asociadosController@index");
     Route::post("asociados/store", "Tb_asociadosController@store");
     Route::put("asociados/update", "Tb_asociadosController@update");
     Route::put("asociados/deactivate", "Tb_asociadosController@deactivate");
     Route::put("asociados/activate", "Tb_asociadosController@activate");
     Route::get("asociados/selectasociados/{id}", "Tb_asociadosController@indexOne");
     Route::get("asociados/detallado/{id}", "Tb_asociadosController@indexOneDetalle");
     Route::get("asociados/ofertas/{id}", "Tb_asociadosController@indexOneOfertas");
     Route::put("asociados/passwordupdate", "Tb_asociadosController@updatePassword");
     Route::get("asociados/alldetallado/", "Tb_asociadosController@indexAllDetalle");
     Route::get("asociados/familiares/{id}", "Tb_asociadosController@indexFamiliaresDetalle");

     Route::get("asociado_permisos", "Tb_asociado_permisosController@index");
     Route::get("asociado_permisos/selectasociado_permisos/{id}", "Tb_asociado_permisosController@indexOne");
     Route::post("asociado_permisos/store", "Tb_asociado_permisosController@store");
     Route::put("asociado_permisos/update", "Tb_asociado_permisosController@update");

     Route::get("asociados_finca", "Tb_asociados_fincasController@index");
     Route::post("asociados_finca/store", "Tb_asociados_fincasController@store");
     Route::put("asociados_finca/update", "Tb_asociados_fincasController@update");
     Route::put("asociados_finca/deactivate", "Tb_asociados_fincasController@deactivate");
     Route::put("asociados_finca/activate", "Tb_asociados_fincasController@activate");
     Route::get("asociados_finca/selectasociados_finca/{id}", "Tb_asociados_fincasController@indexOne");
     Route::get("asociados_finca/selectasociados_fincaAsociado/{idAsociado}", "Tb_asociados_fincasController@indexOneByAsociado");
     Route::get("asociados_finca/select_finca/{idAsociado}", "Tb_asociados_fincasController@indexByAsociado");
     Route::get("asociados_finca/detallado", "Tb_asociados_fincasController@detallado");

     Route::get("produccion", "Tb_produccionController@index");
     Route::post("produccion/store", "Tb_produccionController@store");
     Route::put("produccion/update", "Tb_produccionController@update");
     Route::put("produccion/deactivate", "Tb_produccionController@deactivate");
     Route::put("produccion/activate", "Tb_produccionController@activate");
     Route::get("produccion/selectproduccion/{id}", "Tb_produccionController@indexOne");
     Route::get("produccion/selectproduccionByAsociado/{id}", "Tb_produccionController@indexByAsociado");

     //Route::get("ofertas", "Tb_ofertaController@index");
     Route::get("ofertas", "Tb_ofertaController@index");
     Route::post("ofertas/store", "Tb_ofertaController@store");
     Route::put("ofertas/update", "Tb_ofertaController@update");
     Route::put("ofertas/deactivate", "Tb_ofertaController@deactivate");
     Route::put("ofertas/activate", "Tb_ofertaController@activate");
     Route::get("ofertas/selectofertas/{id}", "Tb_ofertaController@indexOne");
     Route::get("ofertas/detallado", "Tb_ofertaController@detallado");
     Route::get("ofertas/ofertasactivas", "Tb_ofertaController@ofertasActivas");

     Route::get("periodicidad", "Tb_periodicidadController@index");
     Route::post("periodicidad/store", "Tb_periodicidadController@store");
     Route::put("periodicidad/update", "Tb_periodicidadController@update");
     Route::put("periodicidad/deactivate", "Tb_periodicidadController@deactivate");
     Route::put("periodicidad/activate", "Tb_periodicidadController@activate");
     Route::get("periodicidad/selectperiodicidad/{id}", "Tb_periodicidadController@indexOne");

     Route::get("familiares", "Tb_familiaresController@index");
     Route::post("familiares/store", "Tb_familiaresController@store");
     Route::put("familiares/update", "Tb_familiaresController@update");
     Route::put("familiares/deactivate", "Tb_familiaresController@deactivate");
     Route::put("familiares/activate", "Tb_familiaresController@activate");
     Route::get("familiares/selectfamiliares/{id}", "Tb_familiaresController@indexOne");

     Route::get("grupos", "Tb_gruposController@index");
     Route::post("grupos/store", "Tb_gruposController@store");
     Route::put("grupos/update", "Tb_gruposController@update");
     Route::put("grupos/deactivate", "Tb_gruposController@deactivate");
     Route::put("grupos/activate", "Tb_gruposController@activate");
     Route::get("grupos/selectgrupos/{id}", "Tb_gruposController@indexOne");

     Route::get("grupo_categorias", "Tb_grupo_categoriasController@index");
     Route::post("grupo_categorias/store", "Tb_grupo_categoriasController@store");
     Route::put("grupo_categorias/update", "Tb_grupo_categoriasController@update");
     Route::get("grupo_categorias/selectgrupo_categorias/{id}", "Tb_grupo_categoriasController@indexOne");

     Route::get("generalidades_produccion", "Tb_generalidades_produccionController@index");
     Route::post("generalidades_produccion/store", "Tb_generalidades_produccionController@store");
     Route::put("generalidades_produccion/update", "Tb_generalidades_produccionController@update");
     Route::put("generalidades_produccion/deactivate", "Tb_generalidades_produccionController@deactivate");
     Route::put("generalidades_produccion/activate", "Tb_generalidades_produccionController@activate");
     Route::get("generalidades_produccion/selectgeneralidades_produccion/{id}", "Tb_generalidades_produccionController@indexOne");

     Route::get("fases_produccion", "Tb_fases_produccionController@index");
     Route::post("fases_produccion/store", "Tb_fases_produccionController@store");
     Route::put("fases_produccion/update", "Tb_fases_produccionController@update");
     Route::put("fases_produccion/deactivate", "Tb_fases_produccionController@deactivate");
     Route::put("fases_produccion/activate", "Tb_fases_produccionController@activate");
     Route::get("fases_produccion/selectfases_produccion/{id}", "Tb_fases_produccionController@indexOne");

     Route::get("grupos_conceptos", "Tb_grupos_conceptosController@index");
     Route::post("grupos_conceptos/store", "Tb_grupos_conceptosController@store");
     Route::put("grupos_conceptos/update", "Tb_grupos_conceptosController@update");
     Route::put("grupos_conceptos/deactivate", "Tb_grupos_conceptosController@deactivate");
     Route::put("grupos_conceptos/activate", "Tb_grupos_conceptosController@activate");
     Route::get("grupos_conceptos/selectgrupos_conceptos/{id}", "Tb_grupos_conceptosController@indexOne");

     Route::get("conceptos", "Tb_conceptosController@index");
     Route::post("conceptos/store", "Tb_conceptosController@store");
     Route::put("conceptos/update", "Tb_conceptosController@update");
     Route::put("conceptos/deactivate", "Tb_conceptosController@deactivate");
     Route::put("conceptos/activate", "Tb_conceptosController@activate");
     Route::get("conceptos/selectconceptos/{id}", "Tb_conceptosController@indexOne");
     Route::get("conceptos/selectconceptosgrupo/{id}", "Tb_conceptosController@indexOneGrupo");

     Route::get("hoja_de_costos", "Tb_hoja_de_costosController@index");
     Route::post("hoja_de_costos/store", "Tb_hoja_de_costosController@store");
     Route::put("hoja_de_costos/update", "Tb_hoja_de_costosController@update");
     Route::put("hoja_de_costos/deactivate", "Tb_hoja_de_costosController@deactivate");
     Route::put("hoja_de_costos/activate", "Tb_hoja_de_costosController@activate");
     Route::get("hoja_de_costos/selecthoja_de_costos/{id}", "Tb_hoja_de_costosController@indexOne");

     Route::get("detallado_produccion", "Tb_detallado_produccionController@index");
     Route::post("detallado_produccion/store", "Tb_detallado_produccionController@store");
     Route::put("detallado_produccion/update", "Tb_detallado_produccionController@update");
     Route::put("detallado_produccion/deactivate", "Tb_detallado_produccionController@deactivate");
     Route::put("detallado_produccion/activate", "Tb_detallado_produccionController@activate");
     Route::get("detallado_produccion/selectdetallado_produccion/{id}", "Tb_detallado_produccionController@indexOne");
     Route::post("detallado_produccion/delete", "Tb_detallado_produccionController@delete");

     Route::get("medida_unidades", "Tb_medida_unidadesController@index");
     Route::post("medida_unidades/store", "Tb_medida_unidadesController@store");
     Route::put("medida_unidades/update", "Tb_medida_unidadesController@update");
     Route::put("medida_unidades/deactivate", "Tb_medida_unidadesController@deactivate");
     Route::put("medida_unidades/activate", "Tb_medida_unidadesController@activate");
     Route::get("medida_unidades/selectmedida_unidades/{id}", "Tb_medida_unidadesController@indexOne");

     Route::get("costeo/categorias_usuario/{id}", "CosteoController@categoriasPorUsuario");
     Route::get("costeo/productos_usuario/{id}", "CosteoController@productosPorUsuario");
     Route::get("costeo/hojas_grupo/", "CosteoController@hojasPorGrupo");
     Route::get("costeo/hojas_detallado/{id}", "CosteoController@detalladoHoja");
     Route::get("costeo/hojas_calculo/{id}", "CosteoController@calculoHoja");

     Route::post('/upload-image', 'ImageController@uploadImage');
    });

});
