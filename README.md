# Portal Cautivo - Proyecto de Autenticación Básica y Registro de Actividad

Este proyecto implementa un portal cautivo en un entorno local utilizando **MAMP**, **PHP**, y **MySQL**. El sistema incluye autenticación de usuarios, registro de actividad, control de sesiones, y una interfaz gráfica sencilla.

## Requisitos

- **MAMP**: Entorno de servidor local para ejecutar Apache y MySQL.
- **phpMyAdmin**: Administrador de bases de datos MySQL integrado en MAMP.
- **Navegador**: Para acceder a las páginas de inicio de sesión, registro y éxito.
  
## Estructura del Proyecto

- **`htdocs/`**: Carpeta principal del proyecto (ubicada en `/Applications/MAMP/htdocs` en Mac).
  - `index.html`: Página de inicio de sesión.
  - `register.html`: Página de registro de usuarios.
  - `success.html`: Página de bienvenida tras iniciar sesión correctamente.
  - `error.html`: Página de error para credenciales incorrectas.
  - `styles.css`: Archivo CSS para el diseño.
  - `register.php`: Script para registrar nuevos usuarios.
  - `login.php`: Script para verificar las credenciales y registrar el acceso.
  - `logout.php`: Script para calcular la duración de la sesión y cerrarla.
- **Base de datos**: Base de datos `registro_actividad` con tablas `usuarios` y `registros_acceso`.

## Instalación y Configuración

### Configurar MAMP

1. **Descargar MAMP**: Descarga e instala MAMP desde [mamp.info](https://www.mamp.info/en/).
2. **Iniciar Servidores**: Abre MAMP y haz clic en "Start Servers" para iniciar Apache y MySQL.
3. **Directorio de Proyecto**: Coloca todos los archivos de este repositorio en la carpeta `htdocs` de MAMP (`/Applications/MAMP/htdocs` en Mac).

### Configurar la Base de Datos en phpMyAdmin

1. **Abrir phpMyAdmin**:
   - Desde MAMP, abre la página de inicio y selecciona **phpMyAdmin**.
   
2. **Crear la Base de Datos**:
   - En phpMyAdmin, ve a la pestaña **Databases** y crea una base de datos llamada `registro_actividad`.

3. **Crear Tablas**:

   - **Tabla `usuarios`**:
     ```sql
     CREATE TABLE usuarios (
       id INT(11) AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) UNIQUE,
       password VARCHAR(255)
     );
     ```

   - **Tabla `registros_acceso`**:
     ```sql
     CREATE TABLE registros_acceso (
       id INT(11) AUTO_INCREMENT PRIMARY KEY,
       user_id INT(11),
       tiempo_entrada DATETIME DEFAULT CURRENT_TIMESTAMP,
       ip_address VARCHAR(45),
       duracion INT(11),
       FOREIGN KEY (user_id) REFERENCES usuarios(id)
     );
     ```

### Configurar el Portal Cautivo

1. **Página de Inicio de Sesión**:
   - Abre `index.html` en un navegador desde `http://localhost:8888/index.html`.
   
2. **Registro de Usuario**:
   - Ve a `register.html` para crear un nuevo usuario.
   - Completa el formulario de registro para crear una cuenta.

3. **Inicio de Sesión**:
   - Después de registrarte, inicia sesión en `index.html` con las credenciales creadas.
   - Si el inicio de sesión es exitoso, serás redirigido a `success.html`.
   - Si el inicio de sesión falla, serás redirigido a `error.html`.

## Estructura de la Base de Datos

### Tabla `usuarios`

| Columna   | Tipo      | Descripción                       |
|-----------|-----------|-----------------------------------|
| `id`      | INT       | ID del usuario (Primary Key)      |
| `username`| VARCHAR   | Nombre de usuario (único)         |
| `password`| VARCHAR   | Contraseña cifrada del usuario    |

### Tabla `registros_acceso`

| Columna         | Tipo      | Descripción                                        |
|-----------------|-----------|----------------------------------------------------|
| `id`            | INT       | ID del registro (Primary Key)                      |
| `user_id`       | INT       | ID del usuario (clave foránea a `usuarios(id)`)    |
| `tiempo_entrada`| DATETIME  | Hora de inicio de sesión (por defecto actual)      |
| `ip_address`    | VARCHAR   | Dirección IP desde la que el usuario se conecta    |
| `duracion`      | INT       | Duración de la sesión en segundos                  |

---
