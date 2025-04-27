# Gestión de Empleados y Proyectos - Documentación de Flujo y Pruebas

## Descripción General
Esta aplicación Symfony permite gestionar empleados y proyectos, con un sistema de auditoría que registra quién crea, edita o elimina cualquier registro. Incluye autenticación de usuarios y un panel de administración para consultar auditorías.

---

## 1. Instalación y Configuración Inicial

1. **Clona el repositorio y accede al directorio del proyecto:**
   ```bash
   git clone <REPO_URL>
   cd reto
   ```
2. **Instala las dependencias:**
   ```bash
   composer install
   ```
3. **Configura la base de datos:**
   - Edita el archivo `.env` con tus credenciales de base de datos.
   - Crea la base de datos y ejecuta las migraciones:
     ```bash
     php bin/console doctrine:database:create
     php bin/console doctrine:migrations:migrate
     ```

---

## 2. Creación de Usuario Administrador

1. **Ejecuta el comando para crear un usuario administrador:**
   ```bash
   php bin/console app:create-admin-user
   ```
2. **Sigue las instrucciones:**
   - Ingresa el UUID (nombre de usuario, por ejemplo: admin).
   - Ingresa la contraseña.

Este usuario tendrá el rol `ROLE_ADMIN` y acceso total a la aplicación.

---

## 3. Inicio de Sesión y Navegación

1. **Inicia la aplicación:**
   ```bash
   symfony serve
   # o
   php -S localhost:8000 -t public
   ```
2. **Accede en el navegador a:**
   - [http://localhost:8000](http://localhost:8000)
3. **Inicia sesión con el usuario administrador creado.**

---

## 4. Funcionalidades Principales

- **Gestión de Empleados:**
  - Crear, editar, ver y eliminar empleados.
- **Gestión de Proyectos:**
  - Crear, editar, ver y eliminar proyectos.
- **Auditoría:**
  - Cada acción de crear, editar o eliminar es registrada con usuario, entidad, acción y fecha/hora.
  - Accede a la auditoría desde el botón "Ver Auditoría" en la página principal.

---

## 5. Pruebas del Proyecto

1. **Crea, edita y elimina empleados y proyectos desde la interfaz.**
2. **Verifica que cada acción queda registrada en la sección de Auditoría.**
3. **Prueba iniciar sesión con distintos usuarios (si los creas) y observa cómo se registra el usuario en la auditoría.**

---

## 6. Observaciones
- La interfaz utiliza Bootstrap para una experiencia visual moderna y responsiva.
- El sistema de auditoría es automático y no requiere intervención manual.
- Si tienes problemas con la auditoría, revisa el archivo `var/log/auditoria_debug.log` para depuración.

---
