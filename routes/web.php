<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/



//////////////////////////////////////////////////////////////////////
//* APP Routes (HOMEPAGE para generar citas) (CEROFILAS)
//////////////////////////////////////////////////////////////////////
Route::redirect('/', '/es');

Route::group(['prefix' => '{language}'], function () {

Route::get('/test', function (){
  App::setLocale('es');
  if(App::isLocale('es')){
    dd(App::getLocale() );
  }
});

//go to main page
Route::get('/', [
  'as' => '/',
  'uses' => 'AppController@home'
]);

//crear citas
Route::get('/crearcita', [
  'as' => 'crearcita',
  'uses' => 'AppController@crearcita' //'AppController@crearcita'
]);

//crear citas
Route::get('/crearcitacopy', [
  'as' => 'crearcitacopy',
  'uses' => 'AppController@crearcita'
]);

//preguntas frecuentes (faq)
Route::get('/faq', [
  'as' => 'faq',
  'uses' => 'AppController@faq'
]);

//cancelar cita por folio
Route::post('/cancelarcita', [
  'as' => 'cancelarcita',
  'uses' => 'AppController@cancelarcita'
]);

//enviar mail de recordatorio
Route::get('sendrecordatorios', [
  'as' => 'sendrecordatorios',
  'uses' => 'AppController@sendrecordatorios'
]);


//mantener token vivo
Route::post('keep-token-alive', function() {
    return 'Token must have been valid, and the session expiration has been extended.'; 
});

//obtener listado de tramites por oficina (o todas las oficinas)
Route::get('gettramites/{oficina?}', [
  'as' => 'gettramites',
  'uses' => 'AppController@gettramites'
]);

//obtener listado de oficinas filtradas por tramite (o todos los tramites)
Route::get('getoficinas/{tramite?}', [
  'as' => 'getoficinas',
  'uses' => 'AppController@getoficinas'
]);

//obtener listado de dias disponibles por tramite/oficina/mes/anio
Route::get('getavailabledays/{oficina?}/{tramite?}/{mes?}/{anio?}', [
  'as' => 'getavailabledays',
  'uses' => 'AppController@getavailabledays'
]);

//obtener listado de horas disponibles por tramite/oficina/dia/mes/anio
Route::get('getavailablehours/{oficina?}/{tramite?}/{dia?}/{mes?}/{anio?}', [
  'as' => 'getavailablehours',
  'uses' => 'AppController@getavailablehours'
]);

//obtener listado de tramitadores por oficina/tramite
Route::get('gettramitadores/{oficina?}/{tramite?}', [
  'as' => 'gettramitadores',
  'uses' => 'AppController@gettramitadores'
]);
//obtener listado de ausencias por tipo/oficina/tramite
Route::get('getausencias/{tipo?}/{oficina?}/{fechainicio?}/{fechafin?}/{dia?}/{mes?}/{anio?}', [
  'as' => 'getausencias',
  'uses' => 'AppController@getausencias'
]);

//obtener listado de dias disponibles por tramite/oficina/mes/anio
Route::get('getavailabledayscopy/{oficina?}/{tramite?}/{mes?}/{anio?}', [
  'as' => 'getavailabledayscopy',
  'uses' => 'AppController@getavailabledayscopy'
]);
//obtener listado de horas disponibles por tramite/oficina/dia/mes/anio
Route::get('getavailablehourscopy/{oficina?}/{tramite?}/{dia?}/{mes?}/{anio?}', [
  'as' => 'getavailablehourscopy',
  'uses' => 'AppController@getavailablehourscopy'
]);
//guardar holding cita (cita preliminar)
Route::post('holdingcitacopy', [
  'as' => 'holdingcitacopy',
  'uses' => 'AppController@holdingcitacopy'
]);

//guardar holding cita (cita preliminar)
Route::post('holdingcita', [
  'as' => 'holdingcita',
  'uses' => 'AppController@holdingcita'
]);

//eliminar holding cita (cita preliminar)
Route::post('removeholdingcita', [
  'as' => 'removeholdingcita',
  'uses' => 'AppController@removeholdingcita'
]);

//obtener confirmacion de registro de cita por folio
Route::get('getconfirmacionregistro/{folio?}', [
  'as' => 'getconfirmacionregistro',
  'uses' => 'AppController@getconfirmacionregistro'
]);

//obtener confirmacion de registro de cita por folio
Route::post('getcita', [
  'as' => 'getcita',
  'uses' => 'AppController@getcita'
]);

//obtener confirmacion de registro de cita por folio
Route::get('getcita', [
  'as' => 'getcita',
  'uses' => 'AppController@getcita'
]);


//guardar cita (cita final)
Route::post('savedate', [
  'as' => 'savedate',
  'uses' => 'AppController@savedate'
]);

//obtener pantalla de hacer valoracion para el ciudadano
Route::get('valoracion/{foliovaloracion?}', [
  'as' => 'valoracionindex',
  'uses' => 'AppController@indexValoracion'
]);
//guardar valoracion para el ciudadano
Route::post('savevaloracion', [
  'as' => 'valoracionsave',
  'uses' => 'AppController@valoracionsave'
]);





//////////////////////////////////////////////////////////////////////
//* KIOSK Routes (Kiosko para generar turnos) (CEROFILAS)
//////////////////////////////////////////////////////////////////////

//go to main page
Route::get('/kiosk', [
  'as' => 'kiosk',
  'uses' => 'KioskController@home'
]);

//leer QR de cita y generar turno
Route::post('/kiosk/confirmationqr/{oficina?}/{folio?}', [
  'as' => 'kioskconfirmationqr',
  'uses' => 'KioskController@confirmationqr'
]);

//buscar cita por nombre,curp o folio y generar turno
Route::post('/kiosk/searchcitabytext/{oficina?}/{text?}', [
  'as' => 'kiosksearchcitabytext',
  'uses' => 'KioskController@searchcitabytext'
]);

//generar turno manual
Route::post('/kiosk/manualturn', [
  'as' => 'kioskmanualturn',
  'uses' => 'KioskController@manualturn'
]);

//obtener tramites de la oficina del kiosko
Route::get('/kiosk/gettramitesbykiosko/{oficina?}', [
  'as' => 'gettramitesbykiosko',
  'uses' => 'KioskController@gettramitesbykiosko'
]);

//obtener tramites de la oficina del kiosko
Route::get('/kiosk/gettramitesbykiosko2/{oficina?}', [
  'as' => 'gettramitesbykiosko2',
  'uses' => 'KioskController@gettramitesbykiosko2'
]);





//////////////////////////////////////////////////////////////////////
//* TURNERA Routes (Kiosko para generar turnos) (CEROFILAS)
//////////////////////////////////////////////////////////////////////

//go to main page
Route::get('/turnera', [
  'as' => 'turnera',
  'uses' => 'KioskController@hometurnera'
]);

//obteniendo asignacion del tramitador
Route::get('sistema/getassignmentsfromoffice', [
  'as' => 'getassignmentsfromoffice',
  'uses' => 'CrmController@getassignmentsfromoffice'
]);





//////////////////////////////////////////////////////////////////////
//* Session managing Module routes (CEROFILAS)
//////////////////////////////////////////////////////////////////////
//go to main page after successful session sistema
Route::get('sistema', 'CrmController@index')->name('sistema');
//Route::post('sistema', 'CrmController@index')->name('sistema');

Route::get('home', function(){
return redirect('sistema');
});

//routes for session, inside this there are routes for request
Auth::routes();

//This function was added to be able to logout with methode = GET
Route::get('logout', 'Auth\LoginController@logout');

//password olvidado
Route::get('forgot', function () {
    return view('auth.forgot');
});

Route::post('resetpassword', [
  'as' => 'resetpassword',
  'uses' => 'Auth\RegisterController@resetpassword'
]);

Route::get('sistema/perfil', [
  'as' => 'perfil',
  'uses' => 'CrmController@perfil'
]);

Route::get('sistema/perfil/{tramitador?}', [
  'as' => 'perfiltramitador',
  'uses' => 'CrmController@perfiltramitador'
]);

Route::get('sistema/getevaluaciones/{tramitador?}/{offset?}', [
  'as' => 'getevaluaciones',
  'uses' => 'CrmController@getevaluaciones'
]);

Route::post('sistema/updateperfil', [
  'as' => 'updateperfil',
  'uses' => 'CrmController@updateperfil'
]);

Route::post('sistema/updatepassword', [
  'as' => 'updatepassword',
  'uses' => 'CrmController@updatepassword'
]);





//////////////////////////////////////////////////////////////////////
//* TRAMITADOR (CEROFILAS)
//////////////////////////////////////////////////////////////////////

//listar usuarios
Route::get('sistema/viewer', [
  'as' => 'viewerturnoscitas',
  'uses' => 'CrmController@viewerturnoscitas'
]);

//setear disponibilidad del tramitador
Route::post('sistema/availability', [
  'as' => 'setavailability',
  'uses' => 'CrmController@setavailability'
]);

//obteniendo asignacion del tramitador
Route::get('sistema/getassignment', [
  'as' => 'getassignment',
  'uses' => 'CrmController@getassignment'
]);

//atendiendo turno desde tramitador
Route::post('sistema/attendingturn', [
  'as' => 'attendingturn',
  'uses' => 'CrmController@attendingturn'
]);

//obteniendo historial a partir del curp
Route::get('sistema/gethistorial/{curp?}/{oficina?}', [
  'as' => 'gethistorial',
  'uses' => 'CrmController@gethistorial'
]);





//////////////////////////////////////////////////////////////////////
//* ADMINISTRADOR OFICINA (CEROFILAS)
//////////////////////////////////////////////////////////////////////

//DASHBOARD
Route::post('sistema/turno/update', [
  'as' => 'turnos/update',
  'uses' => 'CrmController@turnosUpdate'
]);

//USUARIOS MODULE
//listar usuarios
Route::get('sistema/usuarios', [
  'as' => 'usuarios',
  'uses' => 'CrmController@usuariosListar'
]);
//descarga de csv de usuarios
Route::get('sistema/usuarios/csv', [
  'as' => 'usuarios/csv',
  'uses' => 'CrmController@usuariosCsv'
]);
//activar(o desactivar) usuario
Route::post('sistema/usuarios/destroy', [
  'as' => 'usuarios/destroy',
  'uses' => 'CrmController@usuariosDestroy'
]);
//guardar usuario
Route::post('sistema/usuarios/store', [
  'as' => 'usuarios/store',
  'uses' => 'CrmController@usuariosStore'
]);
//actualizar usuario
Route::post('sistema/usuarios/update', [
  'as' => 'usuarios/update',
  'uses' => 'CrmController@usuariosUpdate'
]);
//eliminar relacion de usuario/tramite
Route::post('sistema/usuarios/destroytramitexuser', [
  'as' => 'usuarios/destroytramitexuser',
  'uses' => 'CrmController@usuariosDestroyTramitexUser'
]);
//guardar tramite de usuario
Route::post('sistema/usuarios/storetramitexuser', [
  'as' => 'usuarios/storetramitexuser',
  'uses' => 'CrmController@usuariosStoreTramitexUser'
]);
//actualizar tramite de usuario
Route::post('sistema/usuarios/updatetramitexuser', [
  'as' => 'usuarios/updatetramitexuser',
  'uses' => 'CrmController@usuariosUpdateTramitexUser'
]);

//listar ausencias
Route::get('sistema/ausencias/{usuario?}', [
  'as' => 'ausenciasusuarios',
  'uses' => 'CrmController@ausenciasusuariosListar'
]);
//guardar ausencia
Route::post('sistema/ausencias/store', [
  'as' => 'ausencias/store',
  'uses' => 'CrmController@ausenciasStore'
]);
//actualizar ausencia
Route::post('sistema/ausencias/update', [
  'as' => 'ausencias/update',
  'uses' => 'CrmController@ausenciasUpdate'
]);
//eliminar ausencias
Route::post('sistema/ausencias/destroy', [
  'as' => 'ausencias/destroy',
  'uses' => 'CrmController@ausenciasDelete'
]);

//TRAMITES MODULE
//listar tramites
Route::get('sistema/tramites', [
  'as' => 'tramites',
  'uses' => 'CrmController@tramitesListar'
]);
//guardar tramite
Route::post('sistema/tramites/store', [
  'as' => 'tramites/store',
  'uses' => 'CrmController@tramitesStore'
]);
//actualizar tramite
Route::post('sistema/tramites/update', [
  'as' => 'tramites/update',
  'uses' => 'CrmController@tramitesUpdate'
]);
//eliminar tramite
Route::post('sistema/tramites/destroy', [
  'as' => 'tramites/destroy',
  'uses' => 'CrmController@tramitesDelete'
]);
//guardar tramite x oficina
Route::post('sistema/tramites/oficinastore', [
  'as' => 'tramites/oficinastore',
  'uses' => 'CrmController@tramitesxOficinaStore'
]);
//actualizar tramite x oficina
Route::post('sistema/tramites/oficinaupdate', [
  'as' => 'tramites/oficinaupdate',
  'uses' => 'CrmController@tramitesxOficinaUpdate'
]);
//listar dependencias y oficinas
Route::get('sistema/getcodetramite/{code?}', [
  'as' => 'getcodetramite',
  'uses' => 'CrmController@getcodetramite'
]);

//DEPENDENCIAS/OFICINAS MODULE
//listar dependencias y oficinas
Route::get('sistema/dependencias', [
  'as' => 'dependencias',
  'uses' => 'CrmController@dependenciasListar'
]);
//guardar dependencias
Route::post('sistema/dependencias/store', [
  'as' => 'dependencias/store',
  'uses' => 'CrmController@dependenciasStore'
]);
//actualizar dependencias
Route::post('sistema/dependencias/update', [
  'as' => 'dependencias/update',
  'uses' => 'CrmController@dependenciasUpdate'
]);
//eliminar dependencias
Route::post('sistema/dependencias/destroy', [
  'as' => 'dependencias/destroy',
  'uses' => 'CrmController@dependenciasDelete'
]);
//guardar oficinas
Route::post('sistema/oficinas/store', [
  'as' => 'oficinas/store',
  'uses' => 'CrmController@oficinasStore'
]);
//actualizar oficinas
Route::post('sistema/oficinas/update', [
  'as' => 'oficinas/update',
  'uses' => 'CrmController@oficinasUpdate'
]);
//eliminar oficinas
Route::post('sistema/oficinas/destroy', [
  'as' => 'oficinas/destroy',
  'uses' => 'CrmController@oficinasDelete'
]);

//VISOR DE TURNOS Y CITAS
//obtener listado de turnos
Route::get('getturnos/{rol?}/{oficina?}/{fecha?}/{estatus?}', [
  'as' => 'getturnos',
  'uses' => 'CrmController@getturnos'
]);
//actualizar turno asignandole tramitador
Route::get('updateturnos/{turno?}/{tramitador?}', [
  'as' => 'updateturnos',
  'uses' => 'CrmController@updateturnos'
]);
//obtener listado de citas
Route::get('getcitas/{rol?}/{oficina?}/{fecha?}/{estatus?}', [
  'as' => 'getcitas',
  'uses' => 'CrmController@getcitas'
]);
});