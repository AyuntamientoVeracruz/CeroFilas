# [Cero Filas](https://cerofilas.veracruzmunicipio.gob.mx)

Proyecto de generación, confirmación y evaluación de citas programadas y turnos para la atención de trámites realizados por el Gobierno de la Ciudad de Veracruz.

  - [Acerca de Cero Filas](#acerca-de-cero-filas)
  - [Base de datos](#base-de-datos)
    - [Tabla de citas](#tabla-de-citas)
	- [Tabla de turnos](#tabla-de-turnos)
	- [Tabla de usuarios](#tabla-de-usuarios)
	- [Tabla de tramites](#tabla-de-tramites)
	- [Tabla de oficinas](#tabla-de-oficinas)
	- [Tabla de dependencias](#tabla-de-dependencias)
	- [Tabla de configuraciones](#tabla-de-configuraciones)
	- [Tabla de reserva de citas](#tabla-de-reserva-de-citas)
	- [Tabla de tramites por oficina](#tabla-de-tramites-por-oficina)
	- [Tabla de tramites por usuario](#tabla-de-tramites-por-usuario)
	- [Tabla de evaluaciones](#tabla-de-evaluaciones)
	- [Tabla de ausencias](#tabla-de-ausencias)
	- [Tabla de videos](#tabla-de-videos)
  - [Archivos necesarios para el correcto funcionamiento del sitio](#archivos-necesarios-para-el-correcto-funcionamiento-del-sitio)
    - [Proyecto Laravel](#proyecto-laravel)
    - [Archivos publicos](#archivos-publicos)
  - [Instrucciones para desarrolladores](#instrucciones-para-desarrolladores)
    - [Adaptación estetica](#adaptaci%C3%B3n-estetica)
  - [Levantar el proyecto en un ambiente productivo](#levantar-el-proyecto-en-un-ambiente-productivo)
    - [Requerimientos](#requerimientos)
    - [Configuración](#configuraci%C3%B3n)
    - [Instalación por primera vez](#instalaci%C3%B3n-por-primera-vez)
  - [Licencia](#licencia)	
  - [Autores](#autores)

## Acerca de Cero Filas 

Cero Filas nace por iniciativa del H. Ayuntamiento de Veracruz en la administración 2018 - 2021 encabezada por el Maestro Fernando Yunes Márquez, Presidente Municipal Constitucional, el objetivo de dicha iniciativa es que a través de herramientas digitales, se le dé la oportunidad al ciudadano de escoger fecha y hora para asistir a la realización de un trámite y con ello:

* Evitar las largas filas para la atención a la realización de trámites
* Disminuir el tiempo de espera del ciudadano para ser atendido
* Eficientar el proceso del tramitador para atender a un ciudadano

La solicitud de una cita se lleva acabo a través de la plataforma Cero Filas, ingresando a [cerofilas.veracruzmunicipio.gob.mx](https://cerofilas.veracruzmunicipio.gob.mx)

El tramitador tendrá acceso a la plataforma ingresando a [cerofilas.veracruzmunicipio.gob.mx/sistema](https://cerofilas.veracruzmunicipio.gob.mx/sistema), es aquí donde podrá visualizar las citas y turnos pasados, citas y turnos actuales y los futuros. Dentro de esta plataforma, el tramitador podrá crear un historial del ciudadano o acceder a él a través de la CURP.

Para mejorar la atención del tramitador al ciudadano, se le da al tramitante la herramienta de la evaluación, esta se realizará una vez que haya concluido la atención, y llegará mediante correo electrónico, aquí podrá calificar la atención y dejar comentarios acerca de la atención recibida y su experiencia al realizar el trámite.

De la misma manera, se cuenta con un administrador de oficina (ingresando al mismo sistema) que podrá gestionar los catálogos de trámites y los tramitadores que desempeñarán ese trámite, así como sus horarios de atención de cada uno de ellos. Podrán gestionar las ausencias de los tramitadores para planificar de mejor manera la atención al ciudadano.

Se trata de una aplicación backend y frontend, construido con el framework Laravel 5.5 (PHP 7.1) usando como gestor de base de datos MySQL (5.0+). 
Tanto vistas, modelo y controlador se usaron a plenitud con el framework Laravel. 
Contiene formularios convencionales e invocaciones por ajax a backend con información que tiene acceso a base de datos.

## Base de datos

Se hace uso de una base de datos para almacenar la información de las citas y los turnos en las entidades: `turnos`, `citas`. Para llegar a estas entidades, se necesitan tener catálogos de: `usuarios`, `tramites`, `oficinas`, `dependencias`. Y algunas entidades de relación adicionales: `configuraciones`, `holdingcitas`, `tramitesxoficinas`, `tramitesxusers`, `valoraciones`, `ausencias` y `videos`.

A continuación se explica cada una de estas entidades.

### Tabla de citas

Tabla llamada `citas`. Esta entidad almacena las citas programadas por los visitantes del portal. Hace uso de las entidades catálogo como [tramites](#tabla-de-tramites), [oficinas](#tabla-de-oficinas).

| Nombre de la columna          | Columna obligatoria / opcional | Tipo de dato      | Detalle                                              |
| ----------------------------- |------------------------------- | ----------------- | ---------------------------------------------------- |
| `id_cita`                     | Obligatoria                    | Numerico¹         | Identificador autonumerico de la cita                |
| `tramite_id`                  | Obligatoria                    | Numerico¹         | Idenfificador de trámite de la tabla "tramites"      |
| `oficina_id`                  | Obligatoria                    | Numerico¹         | Idenfificador de oficina de la tabla "oficinas"      |
| `fechahora`                   | Obligatoria                    | Fechahora         | Fecha y hora de la cita                              |
| `nombre_ciudadano`            | Obligatoria                    | Texto             | Nombre(s) del ciudadadno que registra la cita        |
| `appaterno_ciudadano`         | Obligatoria                    | Texto             | Apellido paterno del ciudadano                       |
| `apmaterno_ciudadano`         | Obligatoria                    | Texto             | Apellido materno del ciudadano                       |
| `email`                       | Opcional                       | Texto             | Email del ciudadano                                  |
| `curp`                        | Obligatoria                    | Texto             | CURP del ciudadano                                   |
| `telefono`                    | Opcional³                      | Texto             | Teléfono del ciudadano                               |
| `folio`                       | Opcional                       | Texto             | Folio único de la cita de 8 caracteres               |
| `ip`                          | Opcional                       | Texto             | IP de la computadora que registra la cita            |
| `statuscita`                  | Opcional                       | Texto²            | Estatus de la cita (null or cancelada)               |
| `created_by`                  | Opcional                       | Numerico¹         | Identificador de usuario creador del registro        |
| `created_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de creación del registro             |
| `updated_by`                  | Opcional                       | Numerico¹         | Identificador de usuario modificador del registro    |
| `updated_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de modificación del registro         |

¹ Tener en cuenta que es importante formatear los numeros de forma tal que el separador decimal sea `.` y no deben 
contar con separadores de miles, comillas, caracter de moneda, ni otros caracteres especiales. 

² Los estatus de la cita son: `cancelada`, null. Cuando una cita es creada, no tiene un estatus, solo es modificada al ser cancelada.

### Tabla de turnos

Tabla llamada `turnos`. Esta entidad almacena los turnos (check-in de ciudadanos), es cuando un ciudadano con cita o sin cita se presenta en las oficinas y marca su presencia, si trae cita, entonces trae consigo un folio de cita o QR. Hace uso de las entidades catálogo como [tramites](#tabla-de-tramites), [oficinas](#tabla-de-oficinas), [citas](#tabla-de-citas), [users](#tabla-de-usuarios).

| Nombre de la columna          | Columna obligatoria / opcional | Tipo de dato      | Detalle                                              |
| ----------------------------- |------------------------------- | ----------------- | ---------------------------------------------------- |
| `id_turno`                    | Obligatoria                    | Numerico¹         | Identificador autonumerico del turno                 |
| `cita_id`                     | Opcional                       | Numerico¹         | Idenfificador de cita de la tabla "citas"            |
| `oficina_id`                  | Obligatoria                    | Numerico¹         | Idenfificador de oficina de la tabla "oficinas"      |
| `user_id`                     | Opcional                       | Numerico¹         | Idenfificador de tramitador de la tabla "users"      |
| `tramite_id`                  | Obligatoria                    | Numerico¹         | Idenfificador de trámite de la tabla "tramites"      |
| `fechahora_inicio`            | Opcional                       | Fechahora         | Fecha y hora de inicio de atención del turno         |
| `fechahora_fin`               | Opcional                       | Fechahora         | Fecha y hora de fin de atención del turno            |
| `observaciones`               | Opcional                       | TextoLargo        | Observaciones registradas por el tramitador sobre la atención del turno |
| `nombre_ciudadano`            | Opcional                       | Texto             | Nombre(s) del ciudadadno que registra el turno       |
| `curp`                        | Obligatoria                    | Texto             | CURP del ciudadano                                   |
| `email`                       | Opcional                       | Texto             | Email del ciudadano                                  |
| `estatus`                     | Obligatoria                    | Enum²             | Estatus del turno                                    |
| `folio`                       | Obligatoria                    | Texto             | Folio único del turno de 8 caracteres                |
| `tiempoaproxmin`              | Obligatoria                    | Numerico¹         | Tiempo aproximado en minutos en que será atendido el turno |
| `created_by`                  | Opcional                       | Numerico¹         | Identificador de usuario creador del registro        |
| `created_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de creación del registro             |
| `updated_by`                  | Opcional                       | Numerico¹         | Identificador de usuario modificador del registro    |
| `updated_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de modificación del registro         |


¹ Tener en cuenta que es importante formatear los numeros de forma tal que el separador decimal sea `.` y no deben 
contar con separadores de miles, comillas, caracter de moneda, ni otros caracteres especiales. 

² Los estatus del turno son: `creado`, `enproceso`, `finalizado`, `cancelado`. Estos estatus van cambiando conforme acciones del sistema.

### Tabla de usuarios

Tabla llamada `users`. Esta entidad almacena los usuarios del sistema (tramitadores, administrador de oficina, kiosko, turnera y super administrador). Cada tipo de usuario cuenta con diferentes acciones dentro del sistema. Hace uso de las entidades catálogo como [oficinas](#tabla-de-oficinas).

| Nombre de la columna          | Columna obligatoria / opcional | Tipo de dato      | Detalle                                              |
| ----------------------------- |------------------------------- | ----------------- | ---------------------------------------------------- |
| `id_user`                     | Obligatoria                    | Numerico¹         | Identificador autonumerico del usuario               |
| `tipo_user`                   | Obligatoria                    | Enum²             | Tipo de usuario del sistema                          |
| `estatus`                     | Obligatoria                    | Enum³             | Estatus del usuario                                  |
| `email`                       | Opcional                       | Texto             | Email del usuario con el que hara login en el sistema |
| `password`                    | Opcional                       | Texto             | Password del usuario con el que hara login en el sistema |
| `nombre`                      | Obligatoria                    | Texto             | Nombre(s) del usuario                                |
| `oficina_id`                  | Obligatoria                    | Numerico¹         | Idenfificador de oficina de la tabla "oficinas"      |
| `disponible_turno`            | Opcional                       | Enum⁴             | Indica si el usuario esta disponible para atender turnos |
| `ventanilla`                  | Opcional                       | Texto             | Clave alfanumerica para indicar la ventanilla donde atiende el usuario los turnos |
| `REMEMBER_TOKEN`              | Opcional                       | Texto¹            | Token de sesión del usuario                          |
| `created_by`                  | Opcional                       | Numerico¹         | Identificador de usuario creador del registro        |
| `created_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de creación del registro             |
| `updated_by`                  | Opcional                       | Numerico¹         | Identificador de usuario modificador del registro    |
| `updated_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de modificación del registro         |


¹ Tener en cuenta que es importante formatear los numeros de forma tal que el separador decimal sea `.` y no deben 
contar con separadores de miles, comillas, caracter de moneda, ni otros caracteres especiales. 

² Los tipos de usuario del sistema son: `superadmin`, `admin_oficina`, `kiosko`, `tramitador`, `turnera`. El `superadmin` permite administrar todos los usuarios del sistema, el `adminoficina` administra los usuarios y tramites de su jurisdiccion,  `kiosko` permite recibir a los ciudadanos por turno o cita, `turnera` nos permite ver en pantalla los turnos y su asignación a ventanilla de atención.

³ Los usuarios pueden estar activos o inactivos, un usuario inactivo no puede iniciar sesión en el sistema, ni es tomado en cuenta para los calculos de los horarios disponibles de una oficina.

⁴ Un usuario puede (`si`) o no (`no`) estar disponible para atender un turno. 

### Tabla de tramites

Tabla llamada `tramites`. Esta entidad almacena los tramites del sistema. Un tramite puede estar asignado a una dependencia (una dependencia puede tener 1 o mas oficinas). Hace uso de las entidades catálogo como [dependencias](#tabla-de-dependencias).

| Nombre de la columna          | Columna obligatoria / opcional | Tipo de dato      | Detalle                                              |
| ----------------------------- |------------------------------- | ----------------- | ---------------------------------------------------- |
| `id_tramite`                  | Obligatoria                    | Numerico¹         | Identificador autonumerico del tramite               |
| `nombre_tramite`              | Obligatoria                    | Texto             | Nombre del tramite                                   |
| `requisitos`                  | Opcional                       | Texto             | Requisitos del tramite                               |
| `tiempo_minutos`              | Obligatoria                    | Entero            | Tiempo en minutos que dura el tramite                |
| `costo`                       | Obligatoria                    | Texto             | Costo del tramite, puede ser texto                   |
| `codigo`                      | Obligatoria                    | Texto             | Codigo unico del tramite                             |
| `dependencia_id`              | Opcional                       | Numerico¹         | Idenfificador de dependencia de la tabla "dependencias"  |
| `warning_message`             | Opcional                       | Texto             | Mensaje de alerta al momento de desplegar requisitos |
| `created_by`                  | Opcional                       | Numerico¹         | Identificador de usuario creador del registro        |
| `created_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de creación del registro             |
| `updated_by`                  | Opcional                       | Numerico¹         | Identificador de usuario modificador del registro    |
| `updated_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de modificación del registro         |


¹ Tener en cuenta que es importante formatear los numeros de forma tal que el separador decimal sea `.` y no deben 
contar con separadores de miles, comillas, caracter de moneda, ni otros caracteres especiales. 

### Tabla de oficinas

Tabla llamada `oficinas`. Esta entidad almacena las oficinas. Una oficina forma parte de una dependencia, esto quiere decir, que una dependencia puede tener mas de una oficina. Hace uso de las entidades catálogo como [dependencias](#tabla-de-dependencias).

| Nombre de la columna          | Columna obligatoria / opcional | Tipo de dato      | Detalle                                              |
| ----------------------------- |------------------------------- | ----------------- | ---------------------------------------------------- |
| `id_oficina`                  | Obligatoria                    | Numerico¹         | Identificador autonumerico de la oficina             |
| `nombre_oficina`              | Obligatoria                    | Texto             | Nombre de la oficina                                 |
| `slug`                        | Opcional                       | Texto             | Slug del nombre la oficina                           |
| `dependencia_id`              | Obligatoria                    | Numerico¹         | Idenfificador de dependencia de la tabla "dependencias"  |
| `coords`                      | Obligatoria                    | Texto             | Coordenadas de la oficina,  formato: lat, long       |
| `direccion`                   | Opcional                       | Texto             | Direccion en texto de la oficina                     |
| `created_by`                  | Opcional                       | Numerico¹         | Identificador de usuario creador del registro        |
| `created_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de creación del registro             |
| `updated_by`                  | Opcional                       | Numerico¹         | Identificador de usuario modificador del registro    |
| `updated_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de modificación del registro         |


¹ Tener en cuenta que es importante formatear los numeros de forma tal que el separador decimal sea `.` y no deben 
contar con separadores de miles, comillas, caracter de moneda, ni otros caracteres especiales. 

### Tabla de dependencias

Tabla llamada `dependencias`. Esta entidad almacena las dependencias. Una oficina forma parte de una dependencia, esto quiere decir, que una dependencia puede tener mas de una oficina. Solo el administrador de la base de datos puede crear una dependencia.

| Nombre de la columna          | Columna obligatoria / opcional | Tipo de dato      | Detalle                                              |
| ----------------------------- |------------------------------- | ----------------- | ---------------------------------------------------- |
| `id_dependencia`              | Obligatoria                    | Numerico¹         | Identificador autonumerico de la dependencia         |
| `nombre_dependencia`          | Obligatoria                    | Texto             | Nombre de la dependencia                             |
| `created_by`                  | Opcional                       | Numerico¹         | Identificador de usuario creador del registro        |
| `created_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de creación del registro             |
| `updated_by`                  | Opcional                       | Numerico¹         | Identificador de usuario modificador del registro    |
| `updated_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de modificación del registro         |


¹ Tener en cuenta que es importante formatear los numeros de forma tal que el separador decimal sea `.` y no deben 
contar con separadores de miles, comillas, caracter de moneda, ni otros caracteres especiales. 

### Tabla de configuraciones

Tabla llamada `configuraciones`. Esta entidad almacena las configuraciones como lo es la API key de google maps. Solo el administrador de la base de datos puede crear una dependencia.

| Nombre de la columna          | Columna obligatoria / opcional | Tipo de dato      | Detalle                                              |
| ----------------------------- |------------------------------- | ----------------- | ---------------------------------------------------- |
| `id_configuracion`            | Obligatoria                    | Numerico¹         | Identificador autonumerico de la configuracion       |
| `service_name`                | Obligatoria                    | Texto             | Nombre del servicio                                  |
| `service_key`                 | Obligatoria                    | Texto             | Key del servicio                                     |

¹ Tener en cuenta que es importante formatear los numeros de forma tal que el separador decimal sea `.` y no deben 
contar con separadores de miles, comillas, caracter de moneda, ni otros caracteres especiales. 

### Tabla de reserva de citas

Tabla llamada `holdingcitas`. Esta entidad almacena la reserva de la cita, cuando un ciudadano en el portal esta seleccionando una fecha esta fecha es retenida para que no pueda ser usada por al menos 5 minutos si es que no fue seleccionada al final. Hace uso de las entidades catálogo como [tramites](#tabla-de-tramites), [oficinas](#tabla-de-oficinas). Tabla de almacenamiento temporal.

| Nombre de la columna          | Columna obligatoria / opcional | Tipo de dato      | Detalle                                              |
| ----------------------------- |------------------------------- | ----------------- | ---------------------------------------------------- |
| `id_holdingcita`              | Obligatoria                    | Numerico¹         | Identificador autonumerico de la reserva de cita     |
| `tramite_id`                  | Opcional                       | Numerico¹         | Idenfificador de trámite de la tabla "tramites"      |
| `oficina_id`                  | Obligatoria                    | Numerico¹         | Idenfificador de oficina de la tabla "oficinas"      |
| `fechahora`                   | Obligatoria                    | Fechahora         | Fecha y hora de la cita                              |
| `folio`                       | Obligatoria                    | Texto             | Folio único de la reserva de cita de 8 caracteres    |
| `created_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de creación del registro             |
| `updated_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de modificación del registro         |

¹ Tener en cuenta que es importante formatear los numeros de forma tal que el separador decimal sea `.` y no deben 
contar con separadores de miles, comillas, caracter de moneda, ni otros caracteres especiales. 

### Tabla de tramites por oficina

Tabla llamada `tramitesxoficinas`. Esta entidad almacena la relación de tramites y oficina. Hace uso de las entidades catálogo como [tramites](#tabla-de-tramites), [oficinas](#tabla-de-oficinas).

| Nombre de la columna          | Columna obligatoria / opcional | Tipo de dato      | Detalle                                              |
| ----------------------------- |------------------------------- | ----------------- | ---------------------------------------------------- |
| `id_tramitesxoficinas`        | Obligatoria                    | Numerico¹         | Identificador autonumerico de la relacion tramite x oficina |
| `tramite_id`                  | Obligatoria                    | Numerico¹         | Idenfificador de trámite de la tabla "tramites"      |
| `oficina_id`                  | Obligatoria                    | Numerico¹         | Idenfificador de oficina de la tabla "oficinas"      |
| `apply_date`                  | Opcional                       | Fechahora         | Fecha y hora de la cita                              |
| `created_by`                  | Opcional                       | Numerico¹         | Identificador de usuario creador del registro        |
| `created_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de creación del registro             |
| `updated_by`                  | Opcional                       | Numerico¹         | Identificador de usuario modificador del registro    |
| `updated_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de modificación del registro         |

¹ Tener en cuenta que es importante formatear los numeros de forma tal que el separador decimal sea `.` y no deben 
contar con separadores de miles, comillas, caracter de moneda, ni otros caracteres especiales. 

### Tabla de tramites por usuario

Tabla llamada `tramitesxusers`. Esta entidad almacena la relación de tramites y usuarios. Hace uso de las entidades catálogo como [tramites](#tabla-de-tramites), [users](#tabla-de-usuarios).

| Nombre de la columna          | Columna obligatoria / opcional | Tipo de dato      | Detalle                                              |
| ----------------------------- |------------------------------- | ----------------- | ---------------------------------------------------- |
| `id_tramitesxusers`           | Obligatoria                    | Numerico¹         | Identificador autonumerico de la relacion tramite x usuario |
| `tramite_id`                  | Obligatoria                    | Numerico¹         | Idenfificador de trámite de la tabla "tramites"      |
| `user_id`                     | Obligatoria                    | Numerico¹         | Idenfificador de usuario de la tabla "users"         |
| `lunes_inicio`                | Opcional                       | Tiempo            | Hora de inicio el dia lunes de ese tramite y usuario |
| `lunes_fin`                   | Opcional                       | Tiempo            | Hora de fin el dia lunes de ese tramite y usuario    |
| `martes_inicio`               | Opcional                       | Tiempo            | Hora de inicio el dia martes de ese tramite y usuario|
| `martes_fin`                  | Opcional                       | Tiempo            | Hora de fin el dia martes de ese tramite y usuario   |
| `miercoles_inicio`            | Opcional                       | Tiempo            | Hora de inicio el dia miercoles de ese tramite y usuario |
| `miercoles_fin`               | Opcional                       | Tiempo            | Hora de fin el dia miercoles de ese tramite y usuario|
| `jueves_inicio`               | Opcional                       | Tiempo            | Hora de inicio el dia jueves de ese tramite y usuario|
| `jueves_fin`                  | Opcional                       | Tiempo            | Hora de fin el dia jueves de ese tramite y usuario   |
| `viernes_inicio`              | Opcional                       | Tiempo            | Hora de inicio el dia viernes de ese tramite y usuario |
| `viernes_fin`                 | Opcional                       | Tiempo            | Hora de fin el dia viernes de ese tramite y usuario  |
| `sabado_inicio`               | Opcional                       | Tiempo            | Hora de inicio el dia sabado de ese tramite y usuario|
| `sabado_fin`                  | Opcional                       | Tiempo            | Hora de fin el dia sabado de ese tramite y usuario   |
| `created_by`                  | Opcional                       | Numerico¹         | Identificador de usuario creador del registro        |
| `created_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de creación del registro             |
| `updated_by`                  | Opcional                       | Numerico¹         | Identificador de usuario modificador del registro    |
| `updated_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de modificación del registro         |

¹ Tener en cuenta que es importante formatear los numeros de forma tal que el separador decimal sea `.` y no deben 
contar con separadores de miles, comillas, caracter de moneda, ni otros caracteres especiales. 

### Tabla de evaluaciones

Tabla llamada `valoraciones`. Esta entidad almacena la evaluación solicitad al ciudadano respecto a la atención del tramitador, y a su vez, esta misma almacena la calificación otorgada en caso de ser realizada la evaluación, esto derivado del turno de atención. Hace uso de las entidades catálogo como [turnos](#tabla-de-turnos).

| Nombre de la columna          | Columna obligatoria / opcional | Tipo de dato      | Detalle                                              |
| ----------------------------- |------------------------------- | ----------------- | ---------------------------------------------------- |
| `id_valoracion`               | Obligatoria                    | Numerico¹         | Identificador autonumerico de la evaluacion          |
| `turno_id`                    | Obligatoria                    | Numerico¹         | Idenfificador de turno de la tabla "turnos"          |
| `folio`                       | Obligatoria                    | Texto             | Folio único de la evaluacion de 8 caracteres         |
| `estrellas`                   | Opcional                       | Tiempo            | Estrellas del ciudadano hacia el tramitador por la atencion recibida |
| `respuesta1`                  | Opcional                       | Tiempo            | Respuesta 1 de la atencion recibida                  |
| `respuesta2`                  | Opcional                       | Tiempo            | Respuesta 2 de la atencion recibida                  |
| `observaciones`               | Opcional                       | Tiempo            | Texto libre de observaciones de la atención brindada |
| `created_by`                  | Opcional                       | Numerico¹         | Identificador de usuario creador del registro        |
| `created_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de creación del registro             |
| `updated_by`                  | Opcional                       | Numerico¹         | Identificador de usuario modificador del registro    |
| `updated_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de modificación del registro         |

¹ Tener en cuenta que es importante formatear los numeros de forma tal que el separador decimal sea `.` y no deben 
contar con separadores de miles, comillas, caracter de moneda, ni otros caracteres especiales. 

### Tabla de ausencias

Tabla llamada `ausencias`. Esta entidad almacena las ausencias que cada tramitador puede tener. El administrador de oficina gestiona las vacaciones (que es la disponibilidad que tendra el tramitador a futuro de sus tramites). Hace uso de las entidades catálogo como [users](#tabla-de-usuarios).

| Nombre de la columna          | Columna obligatoria / opcional | Tipo de dato      | Detalle                                              |
| ----------------------------- |------------------------------- | ----------------- | ---------------------------------------------------- |
| `id_ausencia`                 | Obligatoria                    | Numerico¹         | Identificador autonumerico de la ausencia            |
| `user_id`                     | Obligatoria                    | Numerico¹         | Idenfificador de usuarios de la tabla "users"        |
| `fecha_inicio`                | Obligatoria                    | Texto             | Fecha de inicio de la ausencia del usuario           |
| `fecha_fin`                   | Obligatoria                    | Tiempo            | Fecha de fin de la ausencia del usuario              |
| `motivo`                      | Opcional                       | Tiempo            | Motivo de la ausencia del usuario                    |
| `created_by`                  | Opcional                       | Numerico¹         | Identificador de usuario creador del registro        |
| `created_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de creación del registro             |
| `updated_by`                  | Opcional                       | Numerico¹         | Identificador de usuario modificador del registro    |
| `updated_at`                  | Opcional                       | Marca de tiempo   | Marca de tiempo de modificación del registro         |

¹ Tener en cuenta que es importante formatear los numeros de forma tal que el separador decimal sea `.` y no deben 
contar con separadores de miles, comillas, caracter de moneda, ni otros caracteres especiales. 

### Tabla de videos

Tabla llamada `videos`. Esta entidad almacena los videos que cada oficina pasara en su pantalla si hace uso de una pantalla de espera "Turnera". Solo el administrador de la base de datos puede crear un video.

| Nombre de la columna          | Columna obligatoria / opcional | Tipo de dato      | Detalle                                              |
| ----------------------------- |------------------------------- | ----------------- | ---------------------------------------------------- |
| `id_video`                    | Obligatoria                    | Numerico¹         | Identificador autonumerico del video                 |
| `urlvideo`                    | Obligatoria                    | Texto             | URL del video dentro de la carpeta public_html/videos|
| `oficina_id`                  | Obligatoria                    | Numerico¹         | Idenfificador de oficina de la tabla "oficinas"      |
| `orden`                       | Obligatoria                    | Numerico¹         | Orden de secuencia del video por oficina             |

¹ Tener en cuenta que es importante formatear los numeros de forma tal que el separador decimal sea `.` y no deben 
contar con separadores de miles, comillas, caracter de moneda, ni otros caracteres especiales. 

## Archivos necesarios para el correcto funcionamiento del sitio

### Proyecto Laravel

El proyecto Laravel se compone de las siguientes carpetas:

* [app](./app)
* [bootstrap](./bootstrap) 
* [config](./config)
* [database](./database)
* [resources](./resources)
* [routes](./routes)
* [tests](./tests)
* storage

Y también de los siguientes archivos:
* [artisan](./artisan)
* [composer.json](./composer.json)
* [composer.lock](./composer.lock)
* [package.json](./package.json)
* [env](./env) El cual deberá renombrarse y adecuarse
* [htaccess](./htaccess) El cual deberá renombrarse y adecuarse
* [vendor.zip](./vendors.zip) El cual deberá descromprimirse en la ruta raíz

### Archivos publicos

Los archivos publicos estan dentro de la siguiente carpeta:
* [public_html](./public_html)

## Instrucciones para desarrolladores

Para realizar modificaciones al sitio actual, realizar los siguientes pasos

* ...
* ...

### Adaptación estetica

En caso de necesitar agregar cambios al css del sitio, ubicarlos en el archivo `...`. Este archivo
tiene precedencia por sobre los estilos base del sitio. 


## Levantar el proyecto en un ambiente productivo

### Requerimientos

Sólo requiere un servidor web que pueda servir los contenidos. 

* Apache
* ...

### Configuración

* ...
* ...

### Instalación por primera vez

1. ...
2. ...
3. ...
4. ...
5. ...

## Licencia

Este proyecto esta licenciado bajo la Licencia MIT - vea el archivo [LICENSE](./LICENSE) para más detalles.

## Autores

* **Angel Cobos** - *H. Ayuntamiento de Veracruz* - [Correo electrónico](mailto:angelcobos@outlook.com)
* **Damara Tejeda** - *H. Ayuntamiento de Veracruz* - [Correo electrónico](mailto:damara9510@gmail.com)
