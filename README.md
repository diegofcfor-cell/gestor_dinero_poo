# Gestor de Dinero

## Des web desarrollada en **PHP** utilizando **Programación Orientada a Objetos (POO)** y una arquitectura **MVC con Front Controller**.## Descripción

El sistema permite a múltiples usuarios registrar ingresos y egresos, categorizarlos, filtrarlos y visualizar la información mediante totales y gráficos.

---

## Funcionalidades principales

- Autenticación de usuarios (login / logout)
- Sistema **multiusuario** con aislamiento de datos
- Registro de ingresos y egresos
- Gestión de categorías
- Filtros por fecha, tipo y categoría
- Totales dinámicos (ingresos, egresos y saldo)
- Gráfico de egresos por categoría (Chart.js)
- Alta de usuarios desde la aplicación
- Interfaz orientada a la experiencia de usuario (UX)

---

## Arquitectura

El proyecto utiliza una arquitectura **MVC**:

- **Modelos**: manejo de datos y reglas de negocio
- **Vistas**: presentación y experiencia de usuario
- **Controladores**: lógica de aplicación
- **Front Controller**: un único punto de entrada (`public/index.php`)

Estructura del proyecto:

gestor_dinero_poo/
├── app/
│   ├── Controllers/
│   ├── Models/
│   └── Views/
├── assets/
│   └── css/
├── config/
├── public/
│   └── index.php
└── README.md

## Tecnologías utilizadas

- PHP 8+
- MySQL / MariaDB
- HTML5
- CSS3
- JavaScript
- Chart.js
- Apache

---

## Usuarios de prueba

El sistema incluye usuarios de prueba:

- **admin**
- **grupo_7**
- **Diego**

Cada usuario visualiza únicamente sus propios movimientos.

---

## Instalación y uso

1. Clonar o copiar el proyecto en el directorio de Apache:

/var/www/html/gestor_dinero_poo

2. Crear la base de datos y las tablas necesarias en MySQL.

3. Configurar la conexión a la base de datos en:

config/config.php

4. Acceder al sistema desde el navegador:

http://localhost/gestor_dinero_poo/public/

## Justificación técnica

- Se utilizó **POO** para facilitar el mantenimiento y la escalabilidad.
- El patrón **MVC** permite una separación clara de responsabilidades.
- El uso de **PDO** asegura consultas seguras frente a inyecciones SQL.
- El sistema está preparado para ampliarse con roles, reportes y nuevas visualizaciones.

---

## Autoría

Trabajo grupal – Usuario base: **grupo_7**
