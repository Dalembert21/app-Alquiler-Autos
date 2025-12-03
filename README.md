# 🚗 Sistema de Gestión de Alquiler de Vehículos  
Plataforma web para administración de alquileres, usuarios, vehículos y reservas.

---

# 📌 Descripción General

Este proyecto consiste en una plataforma web diseñada para gestionar el proceso completo de alquiler de vehículos. Permite administrar usuarios, clientes, vehículos, reservas, pagos y reportes mediante una interfaz moderna y accesible.  

El sistema está orientado a **administradores, empleados/agentes de alquiler y clientes**, cada uno con funcionalidades específicas.

---

# 🎭 Roles del Sistema

## 🛠️ **Administrador**
- Gestiona información del sistema: vehículos, clientes y usuarios.
- Asigna y supervisa roles y permisos.
- Visualiza reportes y estadísticas de uso.
- Administra tarifas y mantenimiento de vehículos.

---

## 👨‍💼 **Empleado / Agente de Alquiler**
- Registra reservas y alquileres.
- Gestiona información de clientes.
- Controla devoluciones y estado de vehículos.
- Consulta disponibilidad en tiempo real.
- Genera contratos, facturas y cobra pagos.

---

## 🚘 **Cliente**
- Consulta vehículos disponibles.
- Realiza reservas y pagos.
- Visualiza historial de alquileres y facturas.

---

# ⚙️ Funcionalidades del Sistema

## 🟩 Para el Administrador
- **Gestión de Usuarios:** Crear, editar, asignar permisos, eliminar.
- **Gestión de Vehículos:** Agregar, modificar, eliminar vehículos; marcar como disponibles/mantenimiento.
- **Reportes:** Ingresos, disponibilidad, vehículos más alquilados, estadísticas por fecha.
- **Gestión de Tarifas:** Por tipo de vehículo, duración o temporada.

---

## 🟦 Para el Empleado
- **Gestión de Alquileres:** Registro de alquiler, verificación de disponibilidad.
- **Devoluciones:** Registrar devoluciones, calcular cargos por daños o retrasos.
- **Disponibilidad en tiempo real.**
- **Facturación y pagos.**

---

## 🟨 Para el Cliente
- **Consulta de vehículos disponibles.**
- **Realizar reservas con selección de fechas.**
- **Historial de alquileres y facturas.**
- **Pagos en línea.**

---

# 🧩 Requerimientos del Sistema

- **Usuarios y roles:** Registro y autenticación de administrador, empleado y cliente.
- **Gestión de vehículos:** CRUD completo de vehículos.
- **Módulo de alquiler:** Desde la reserva hasta la devolución.
- **Control de disponibilidad:** Vista en tiempo real.
- **Pagos y facturación:** Generación automática de facturas.
- **Reportes automáticos:** Para la administración.

---

# 🛠 Tecnologías Utilizadas

| Capa | Tecnología |
|------|------------|
| **Frontend** | HTML, CSS, JavaScript |
| **Backend** | PHP |
| **Base de datos** | MySQL |
| **Servidor en la nube** | Azure, Heroku |
| **Pruebas automatizadas** | Selenium |

---
# 🚀 Instalación y Configuración

## 🟦 1. Clonar el repositorio

```bash
git clone https://github.com/usuario/sistema-alquiler-vehiculos.git
```

---

## 🟦 2. Configurar la base de datos MySQL

Abrir **phpMyAdmin** o tu cliente MySQL preferido.

### 📌 Crear la base de datos:

```sql
CREATE DATABASE alquiler_vehiculos_db;
```

### 📌 Importar el archivo SQL (si existe):

```
/database/alquiler_vehiculos.sql
```

---

## 🟦 3. Configurar la conexión en PHP

Editar **config/conexion.php**:

```php
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "alquiler_vehiculos_db";

$conexion = new mysqli($host, $user, $pass, $db);

if ($conexion->connect_error) {
   die("Error de conexión: " . $conexion->connect_error);
}
?>
```

---

# 📁 Estructura del Proyecto (Referencial)

```bash
/project
├── assets
├── backend
│   ├── controllers
│   ├── models
│   └── routes
├── frontend
│   ├── css
│   ├── js
│   └── views
├── database
│   └── alquiler_vehiculos.sql
├── config
│   └── conexion.php
└── README.md
```

---

# 👥 Colaboradores

| Nombre           | Rol        |
| ---------------- | ---------- |
| Fernando Sánchez | Desarrollo |
| Dalembert Bravo  | Desarrollo |
| Kevin Ganan      | Desarrollo |

---

# 🔮 Mejoras Futuras

* Panel administrativo avanzado
* Módulo de mantenimiento vehicular
* Integración con pago en línea (PayPal / Stripe)
* Dashboard con gráficos dinámicos
* App móvil complementaria

