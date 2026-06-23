# Sistema de Gestión de Alquiler de Vehículos (Rent-a-Car) 🚗

Plataforma web desarrollada en **CodeIgniter 4** para la administración integral de una flota de alquiler de vehículos. El sistema permite a los administradores gestionar reservas, flota y clientes, y ofrece a los usuarios un catálogo interactivo para solicitar alquileres.

## 🚀 Características Principales

* **Roles de Usuario:** Autenticación segregada para Administradores y Clientes.
* **Gestión de Flota:** CRUD completo de vehículos con carga de múltiples imágenes, categorización y control de estado lógico y físico (Disponible, Alquilado, Taller).
* **Catálogo Público:** Vista interactiva de vehículos filtrable por categoría y búsqueda de texto.
* **Sistema de Reservas Inteligente:** Integración con *Flatpickr* para selección de rangos de fechas, previniendo superposiciones de alquiler (Overbooking controlado).
* **Gestión Operativa:** Panel de control de reservas (Pendientes, Aprobadas, En Curso) y registro de devoluciones físicas.
* **Auditoría:** Historial detallado de alquileres tanto por vehículo como por cliente.

## 🛠️ Stack Tecnológico

* **Backend:** PHP 8.1+ / CodeIgniter 4
* **Base de Datos:** MySQL / MariaDB
* **Frontend:** HTML5, Bootstrap 5, JavaScript Vanilla
* **Librerías JS:** Flatpickr (Calendarios)

## ⚙️ Instalación y Configuración

1. **Clonar el repositorio y descargar dependencias:**
   ```bash
   git clone <url-del-repositorio>
   cd pi2topicos
   composer install
