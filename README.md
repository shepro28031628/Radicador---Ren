# 🚀 Renapp Radicador Digital - Portal Premium

![Version](https://img.shields.io/badge/version-2.2.0-blue.svg)
![PHP](https://img.shields.io/badge/PHP-8.x-777bb4.svg)
![Tailwind](https://img.shields.io/badge/Tailwind-CSS-38b2ac.svg)

Bienvenido al **Radicador Digital de Renapp**, una solución moderna y profesional diseñada para la gestión eficiente de radicación de documentos médicos y administrativos. Esta aplicación ha sido optimizada para ofrecer una experiencia de usuario de alta densidad informativa en una "pantalla única".

## ✨ Características Principales

- **💎 Diseño Premium**: Interfaz basada en *Glassmorphism* con efecto de cristal y tipografía corporativa.
- **🖥️ Optimización Anti-Scroll**: Layout de rejilla compacta que minimiza el desplazamiento vertical.
- **🛡️ Seguridad Proactiva**: 
  - **Validación de Archivos**: Restricción estricta por tipo (`PDF, JPG, PNG, XLSX, ZIP`) y tamaño máximo de **10MB**.
  - **Modal de Alerta**: Sistema de advertencia intrínseca para campos obligatorios faltantes.
- **🔍 Integración Renapp (Simulada)**: Búsqueda instantánea de afiliados por Número de Identificación con auto-completado de ficha médica y administrativa.
- **📑 Carga Dual Híbrida**:
  - **Individual**: Carga de 10 categorías específicas (HC, Furel, Paraclínicos, etc.) con indicador de búsqueda y éxito.
  - **Masiva (3 Pasos)**: Flujo guiado: 1. Afiliados (Excel), 2. Servicios (Excel), 3. Registro y ZIP de Documentos.
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
