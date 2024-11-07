
### Paso 1: Configurar el Entorno en MAMP

1. **Instalar MAMP**: Descarga e instala MAMP desde [mamp.info](https://www.mamp.info/en/).
2. **Iniciar MAMP**: Abre MAMP y haz clic en "Start Servers" para iniciar los servidores Apache y MySQL.
3. **Directorio de Documentos**: Coloca tus archivos HTML y PHP en el directorio `htdocs` dentro de la carpeta MAMP (`/Applications/MAMP/htdocs`).

### Paso 2: Crear la Base de Datos en phpMyAdmin

1. **Accede a phpMyAdmin**: Desde MAMP, abre la página de inicio y selecciona **phpMyAdmin**.
2. **Crear la Base de Datos**:
   - Ve a la pestaña **Databases** y crea una base de datos llamada `registro_actividad`.
3. **Crear las Tablas**:
   - **Tabla `usuarios`**: Contiene los datos básicos de cada usuario (nombre de usuario y contraseña).
     - Columnas:
       - `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
       - `username` (VARCHAR(50), UNIQUE)
       - `password` (VARCHAR(255))
   - **Tabla `registros_acceso`**: Contiene los registros de actividad de cada usuario (tiempo de inicio de sesión, dirección IP y duración de la sesión).
     - Columnas:
       - `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
       - `user_id` (INT, clave foránea que referencia a `usuarios(id)`)
       - `tiempo_entrada` (DATETIME, con valor predeterminado `CURRENT_TIMESTAMP`)
       - `ip_address` (VARCHAR(45))
       - `duracion` (INT, permite NULL)

4. **Establecer la Clave Foránea**:
   - En la tabla `registros_acceso`, configura `user_id` como una clave foránea que referencia `id` en la tabla `usuarios`.

### Paso 3: Crear Archivos HTML y PHP

#### 1. Archivos HTML (Interfaz Gráfica)

- **`index.html`**: Página de inicio de sesión.
- **`register.html`**: Página de registro para nuevos usuarios.
- **`success.html`**: Página de bienvenida tras autenticación exitosa.
- **`error.html`** (opcional): Página de error para credenciales incorrectas.
- **`styles.css`**: Archivo de estilos CSS para mejorar la apariencia de las páginas.

#### 2. Archivos PHP (Lógica del Portal Cautivo)

- **`register.php`**: Maneja el registro de usuarios, verificando si el usuario ya existe en la base de datos y guardando el nuevo registro.
- **`login.php`**: Verifica las credenciales de inicio de sesión, inicia la sesión y registra el tiempo de inicio y la dirección IP en `registros_acceso`.
- **`logout.php`**: Calcula la duración de la sesión, actualiza la base de datos y cierra la sesión del usuario.

### Paso 4: Implementar Funciones Clave en PHP

1. **`login.php`**:
   - Verifica las credenciales ingresadas.
   - Si son correctas, inicia la sesión y registra el tiempo de inicio en `registros_acceso`.
   - Redirige a `success.html` si el inicio de sesión es exitoso, o a `error.html` si falla.

2. **`logout.php`**:
   - Calcula la duración de la sesión.
   - Actualiza el registro en `registros_acceso` con la duración y destruye la sesión.
   - Redirige a `index.html` después de cerrar la sesión.

3. **Control de Sesión en PHP**:
   - Configura una variable de sesión `session_expiration` en `login.php` para establecer un tiempo límite de sesión.
   - Verifica la expiración de la sesión en `success.html` o en cualquier página protegida.

### Paso 5: Configurar el Control de Ancho de Banda (Opcional)

1. **Configuración en el Router**:
   - Si tu router permite QoS (Quality of Service) o control de ancho de banda, configura un límite por IP o dispositivo.
2. **Usar `tc` en un Servidor Linux**:
   - Si el servidor Linux actúa como gateway, usa `tc` para aplicar un límite de ancho de banda a direcciones IP específicas.
3. **Firewall con pfSense** (opcional):
   - Si tienes acceso a pfSense, configura el portal cautivo y el límite de ancho de banda para usuarios autenticados.

### Resultado Final

Con esta configuración, tu portal cautivo en MAMP y phpMyAdmin tendrá:

- **Autenticación Básica**: Los usuarios deben iniciar sesión antes de acceder a la red.
- **Registro de Actividad**: Cada inicio de sesión se registra en la base de datos, incluyendo tiempo de inicio, IP y duración.
- **Control de Sesión**: El sistema aplica un límite de tiempo para la sesión de cada usuario.
- **Interfaz Gráfica**: Una interfaz sencilla y amigable usando HTML y CSS.

Esta guía resume todos los pasos necesarios para implementar un portal cautivo básico y funcional en un entorno de desarrollo local usando MAMP y phpMyAdmin.
