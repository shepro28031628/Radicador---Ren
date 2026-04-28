# 🚀 Renapp Radicador Digital - Portal Premium

![Version](https://img.shields.io/badge/version-2.0.0-blue.svg)
![PHP](https://img.shields.io/badge/PHP-8.x-777bb4.svg)
![Tailwind](https://img.shields.io/badge/Tailwind-CSS-38b2ac.svg)

Bienvenido al **Radicador Digital de Renapp**, una solución moderna y profesional diseñada para la gestión eficiente de radicación de documentos médicos y administrativos. Esta aplicación ha sido optimizada para ofrecer una experiencia de usuario de "pantalla única" con una estética institucional premium.

## ✨ Características Principales

- **💎 Diseño Premium**: Interfaz basada en *Glassmorphism* con tipografía Outfit y paleta de colores institucional.
- **🖥️ Experiencia Single-Page**: Layout optimizado para eliminar el scroll vertical, manteniendo todas las acciones a la vista.
- **📑 Carga Dual**:
  - **Individual**: Carga de documentos mediante tarjetas interactivas con soporte para *Drag & Drop*.
  - **Masiva**: Generación dinámica de plantillas Excel con listas desplegables integradas y carga por lote.
- **🛡️ Seguridad Antifraude**: Bloqueo dinámico de fechas pasadas en el calendario de radicación.
- **🏗️ Arquitectura Modular**: Código separado en capas (CSS, JS, PHP/Controlador) siguiendo las mejores prácticas de programación.

## 🛠️ Stack Tecnológico

- **Backend**: PHP 8.x (Arquitectura MVC simplificada)
- **Frontend**: HTML5, Tailwind CSS, Google Fonts (Outfit)
- **Librerías**: 
  - [ExcelJS](https://github.com/exceljs/exceljs): Generación de plantillas Excel en el cliente.
  - [Lucide Icons / Heroicons](https://heroicons.com/): Iconografía vectorial.

## 📂 Estructura del Proyecto

```text
radicador/
├── assets/
│   ├── css/
│   │   └── main.css          # Estilos globales y variables de diseño
│   └── js/
│       └── radicador.js      # Lógica de frontend e interactividad
├── includes/
│   └── procesar.php          # Controlador de backend (Clase RadicadorController)
├── uploads/                  # Carpeta de destino de archivos (Ignorada en Git)
├── radicador.php             # Punto de entrada principal (Vista)
├── radicador.html            # Versión estática de demostración
└── README.md                 # Documentación del proyecto
```

## 🚀 Instalación Local

1. **Requisitos**: Tener instalado [XAMPP](https://www.apachefriends.org/) con PHP 7.4 o superior.
2. **Clonar/Copiar**: Coloca la carpeta del proyecto en `C:\xampp\htdocs\radicador`.
3. **Ejecutar**: Abre tu navegador y dirígete a `http://localhost/radicador/radicador.php`.

## 📌 Mejores Prácticas Aplicadas

- **Separación de Responsabilidades**: El diseño, la lógica de cliente y la lógica de servidor residen en archivos independientes.
- **Documentación de Código**: Uso de PHPDoc y JSDoc para una fácil comprensión y mantenimiento.
- **Validación de Datos**: Control estricto de campos obligatorios y tipos de archivos permitidos.

---
© 2026 Renapp Ecosystem. Todos los derechos reservados.
