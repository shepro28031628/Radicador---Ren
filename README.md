# 🚀 Renapp Radicador Digital - Portal Premium

![Version](https://img.shields.io/badge/version-2.1.2-blue.svg)
![PHP](https://img.shields.io/badge/PHP-8.x-777bb4.svg)
![Tailwind](https://img.shields.io/badge/Tailwind-CSS-38b2ac.svg)

Bienvenido al **Radicador Digital de Renapp**, una solución moderna y profesional diseñada para la gestión eficiente de radicación de documentos médicos y administrativos. Esta aplicación ha sido optimizada para ofrecer una experiencia de usuario de alta densidad informativa en una "pantalla única".

## ✨ Características Principales

- **💎 Diseño Premium**: Interfaz basada en *Glassmorphism* con tipografía Outfit y paleta de colores institucional.
- **🖥️ Optimización Anti-Scroll**: Layout de rejilla compacta (5 columnas para pacientes) que minimiza el desplazamiento vertical.
- **🛡️ Seguridad Proactiva**: 
  - **Validación de Archivos**: Restricción estricta por tipo (`PDF, JPG, PNG, XLSX, ZIP`) y tamaño máximo de **10MB**.
  - **Integridad de Datos**: Bloqueo de fechas pasadas y validación de campos obligatorios sincronizada.
- **📑 Carga Dual Híbrida**:
  - **Individual**: Carga de 6 documentos específicos con feedback visual inmediato.
  - **Masiva**: Sistema de carga por lotes para Afiliados, Servicios y Documentación masiva.
- **🏗️ Arquitectura Modular**: Código documentado bajo estándares PHPDoc/JSDoc y separación estricta de capas (MVC simplificado).

## 🛠️ Stack Tecnológico

- **Backend**: PHP 8.x
- **Frontend**: Tailwind CSS, Google Fonts (Outfit)
- **Librerías**: 
  - [ExcelJS](https://github.com/exceljs/exceljs): Generación de plantillas Excel dinámicas.

## 📂 Estructura del Proyecto

```text
radicador/
├── assets/ (CSS/JS)           # Estilos globales y lógica de cliente
├── docs/                      # Documentación técnica detallada
│   └── radicador.md           # Guía de mantenimiento y flujos
├── includes/
│   └── procesar.php           # Controlador de backend
├── uploads/                   # Repositorio de archivos radicados
├── radicador.php              # Vista Principal (Entry Point)
└── README.md                  # Manual de inicio rápido
```

## 🚀 Instalación Local (XAMPP)

1. **Requisitos**: PHP 7.4 o superior.
2. **Despliegue**: Copiar el proyecto en `C:\xampp\htdocs\radicador`.
3. **Acceso**: `http://localhost/radicador/radicador.php`.

---
© 2026 - Renapp. Sistema de Gestión Digital.
