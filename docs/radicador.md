# Módulo: Radicación Digital (Renapp)

## Función
Sistema centralizado para la gestión de solicitudes de radicación médica y administrativa, permitiendo el ingreso individual de pacientes con 21 campos detallados o la carga masiva mediante estructuras normalizadas (Excel/ZIP).

## Técnica y Estándares
- **Clean UI:** Uso de Tailwind CSS para un diseño responsivo y "Glassmorphism" que reduce la fatiga visual.
- **Data Integrity:** Validación de fecha de servidor sincronizada con PHP/JS para evitar radicaciones extemporáneas.
- **Dynamic Excel:** Generación de plantillas en tiempo real con `exceljs.js`, incluyendo listas desplegables (Data Validation) para reducir errores de usuario.
- **Separación de Concernimientos:** Lógica de frontend desacoplada en `assets/js/radicador.js` y controlador de backend en `includes/procesar.php`.

## Diagrama de Flujo de Decisión

```ascii
       ╔═══════════════════════════════════╗
       ║       INICIO DEL PROCESO          ║
       ╚═══════════════╦═══════════════════╝
                       ║
                       ▼
       ╔═══════════════════════════════════╗
       ║   SELECCIÓN TIPO DE RADICACIÓN    ║
       ╚═══════╦═══════════════════╦═══════╝
               ║                   ║
       ┌───────╨───────┐   ┌───────╨───────┐
       │  INDIVIDUAL   │   │    MASIVA     │
       └───────╥───────┘   └───────╥───────┘
               ║                   ║
       ╔═══════▼═══════╗   ╔═══════▼═══════╗
       ║ Llenar Datos  ║   ║ Descargar     ║
       ║ del Paciente  ║   ║ Plantilla XLSX║
       ╚═══════╦═══════╝   ╚═══════╦═══════╝
               ║                   ║
        ╔═══════▼═══════╗   ╔═══════▼═══════╗
        ║ Cargar Docs   ║   ║ PASO 1, 2, 3  ║
        ║ (10 Categorías)║   ║ Flujo Masivo  ║
        ╚═══════╦═══════╝   ╚═══════╦═══════╝
               ║                   ║
               ╚═══════╦═══════════╝
                       ║
                       ▼
       ╔═══════════════════════════════════╗
       ║  VALIDACIÓN CLIENTE (JS)          ║
       ║  - Tipo, Tamaño, Check Veracidad  ║
       ╚═══════════════╦═══════════════════╝
                       ║
                       ▼
       ╔═══════════════════════════════════╗
       ║  CONTROLADOR BACKEND (PHP)        ║
       ║  - Seguridad y Persistencia BD    ║
       ╚═══════════════╦═══════════════════╝
                       ║
                       ▼
       ╔═══════════════════════════════════╗
       ║       FIN DEL PROCESO             ║
       ║       (Radicado Exitoso)          ║
       ╚═══════════════════════════════════╝
```

## Mejores Prácticas y Seguridad
1.  **Validación de Capas:** Las restricciones se aplican en HTML (atributos), JS (interactividad) y PHP (seguridad final).
2.  **Seguridad de Archivos (Frontend):**
    *   **Formatos Permitidos:** `.pdf, .jpg, .jpeg, .png, .xlsx, .zip`.
    *   **Límite de Tamaño:** Máximo **10MB** por archivo para evitar saturación del servidor.
3.  **Feedback Dinámico:** 
    *   **Buscador ID:** Indicador visual (spinner) durante la recuperación de datos desde Renapp.
    *   **Alertas:** Sistema de alertas en `radicador.php` para el backend.
    *   **Modal de Seguridad:** Bloqueo de radicación mediante Modal si existen campos obligatorios vacíos.
4.  **UX Anti-Scroll:** Organización en rejillas compactas para minimizar el desplazamiento.
5.  **Mimetismo de Código:** Se mantiene el estilo de comentarios y estructura original del proyecto para estabilidad total.
6.  **Optimización de Carga:** Se implementan 10 categorías de carga individual para asegurar la trazabilidad de cada documento.

## Mantenimiento
- **Campos del Paciente:** Editar la rejilla `lg:grid-cols-5` en `radicador.php`.
- **Lógica de Validación:** Modificar la constante `ALLOWED_TYPES` y `MAX_SIZE_MB` en `assets/js/radicador.js`.
- **Controlador:** Gestionar rutas y persistencia en `includes/procesar.php`.
