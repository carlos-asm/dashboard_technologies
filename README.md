# Dashboard Technologies - Instalación y Uso

Este proyecto requiere **Docker** para su ejecución.

## 🚀 Instalación

### 1. Clonar el repositorio
```bash
git clone git@github.com:carlos-asm/dashboard_technologies.git
cd dashboard_technologies
```

### 2. Inicializar el entorno con Makefile
Ejecuta el siguiente comando para configurar el entorno:
```bash
make init
```

### 3. Crear manualmente la tabla en MySQL
Después de la inicialización, ejecuta la siguiente consulta SQL en tu base de datos:
```sql
CREATE TABLE users (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL
);
```

## 🛠 Uso de la API

### 📌 Endpoint para registrar un usuario
- **URL:** `http://localhost:8080/register`
- **Método:** `POST`
- **Headers:**
  - `Content-Type: application/json`
- **Body (JSON):**
```json
{
  "name": "Juan Pérez",
  "email": "juan.perez3@example.com",
  "password": "Segur0!Pass"
}
```

## 🧪 Ejecución de Pruebas
Para ejecutar todas las pruebas unitarias, usa:
```bash
make test
```

También puedes ejecutar pruebas específicas:

### ✅ Pruebas Unitarias
#### Caso de Uso (Registro de Usuario)
```bash
docker-compose exec app vendor/bin/phpunit tests/Unit/Application/UseCase/RegisterUserUseCaseTest.php
```

#### Entidad (User)
```bash
docker-compose exec app vendor/bin/phpunit tests/Unit/Domain/User/Entity/UserTest.php
```

#### Value Objects
```bash
docker-compose exec app vendor/bin/phpunit tests/Unit/Domain/User/ValueObject/EmailTest.php
```
```bash
docker-compose exec app vendor/bin/phpunit tests/Unit/Domain/User/ValueObject/NameTest.php
```
```bash
docker-compose exec app vendor/bin/phpunit tests/Unit/Domain/User/ValueObject/PasswordTest.php
```
```bash
docker-compose exec app vendor/bin/phpunit tests/Unit/Domain/User/ValueObject/UserIdTest.php
```

### 🔗 Pruebas de Integración
#### Repositorio (DoctrineUserRepository)
```bash
docker-compose exec app vendor/bin/phpunit tests/Integration/Infrastructure/Persistence/DoctrineUserRepositoryTest.php
```

---

Con esta guía, podrás configurar y probar el proyecto correctamente. 🚀

