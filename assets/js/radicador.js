/**
 * Renapp Radicador - Frontend Logic
 * @version 2.0.0
 * @author Renapp Team
 * 
 * Gestiona la interactividad del formulario, validaciones dinámicas
 * y la generación de plantillas Excel.
 */

document.addEventListener('DOMContentLoaded', () => {
    initDateDisplay();
    initFileUploads();
    initFormValidation();
});

/**
 * Inicializa el visor de fecha en el encabezado
 */
function initDateDisplay() {
    function updateDisplayDate() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateStr = now.toLocaleDateString('es-ES', options);
        const display = document.getElementById('currentDateDisplay');
        if (display) {
            display.textContent = dateStr.charAt(0).toUpperCase() + dateStr.slice(1);
        }
    }
    updateDisplayDate();
}

/**
 * Gestiona el cambio entre pestañas (Individual / Masiva)
 * Realiza una conmutación de la obligatoriedad (required) de los campos.
 * 
 * @param {string} tabName - Identificador de la pestaña ('individual' | 'masiva')
 */
function switchTab(tabName) {
    const isMasiva = tabName === 'masiva';
    const form = document.getElementById('mainRadicadorForm');
    
    // UI: Actualización de botones y contenidos
    document.querySelectorAll('.tab-btn').forEach(btn => {
        const isActive = btn.id === `tab-${tabName}`;
        btn.classList.toggle('active', isActive);
        btn.classList.toggle('bg-white', isActive);
        btn.classList.toggle('text-indigo-600', isActive);
        btn.classList.toggle('text-slate-500', !isActive);
    });
    
    document.querySelectorAll('.tab-content').forEach(c => c.classList.toggle('hidden', c.id !== `content-${tabName}`));

    // Lógica: Manejo de campos obligatorios
    form.classList.toggle('hide-required', isMasiva);
    form.querySelectorAll('input:not([type="file"]), select').forEach(input => {
        if (isMasiva) {
            if (input.required) input.setAttribute('data-was-required', 'true');
            input.required = false;
        } else {
            if (input.getAttribute('data-was-required') === 'true') input.required = true;
        }
    });
}

/**
 * Configura los eventos para la carga de archivos interactiva
 */
function initFileUploads() {
    const ALLOWED_TYPES = ['.pdf', '.jpg', '.jpeg', '.png', '.xlsx', '.zip'];
    const MAX_SIZE_MB = 10;

    document.querySelectorAll('.doc-input, input[type="file"]').forEach(input => {
        const card = input.closest('.upload-card-interactive') || input.parentElement;
        if (!card) return;

        input.addEventListener('change', () => {
            if (input.files.length === 0) return;

            const file = input.files[0];
            const extension = '.' + file.name.split('.').pop().toLowerCase();
            const sizeMB = file.size / (1024 * 1024);

            if (!ALLOWED_TYPES.includes(extension)) {
                alert(`Archivo no permitido. Use: ${ALLOWED_TYPES.join(', ')}`);
                input.value = '';
                return;
            }

            if (sizeMB > MAX_SIZE_MB) {
                alert(`El archivo es demasiado pesado (${sizeMB.toFixed(2)}MB). Máximo: ${MAX_SIZE_MB}MB`);
                input.value = '';
                return;
            }

            const interactiveCard = input.closest('.upload-card-interactive');
            if (interactiveCard) {
                interactiveCard.classList.add('active');
                const status = interactiveCard.querySelector('h5');
                const name = input.files.length === 1 ? file.name : `${input.files.length} archivos`;
                if (status) status.innerHTML = `<span class="text-indigo-600 font-bold">✔ ${name}</span>`;
            }
        });
    });
}

/**
 * Valida el estado del formulario y habilita el botón de radicación
 */
function validateForm() {
    const check = document.getElementById('confirmCheck');
    const btn = document.getElementById('submitBtn');
    const visual = document.getElementById('customCheckVisual');
    const icon = document.getElementById('checkIcon');

    if (!check || !btn) return;

    const isActive = check.checked;
    btn.disabled = !isActive;
    btn.classList.toggle('opacity-50', !isActive);
    btn.classList.toggle('cursor-not-allowed', !isActive);
    btn.classList.toggle('pointer-events-none', !isActive);
    
    if (visual) {
        visual.classList.toggle('bg-white', !isActive);
        visual.classList.toggle('border-slate-300', !isActive);
        visual.classList.toggle('bg-indigo-600', isActive);
        visual.classList.toggle('border-indigo-600', isActive);
    }
    
    if (icon) {
        icon.classList.toggle('scale-0', !isActive);
        icon.classList.toggle('scale-100', isActive);
    }
}

/**
 * Inicializa la validación del formulario al enviar
 */
function initFormValidation() {
    const form = document.getElementById('mainRadicadorForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        const btn = document.getElementById('submitBtn');
        if (btn.disabled) {
            e.preventDefault();
            return;
        }
        
        const span = btn.querySelector('span');
        if (span) {
            span.textContent = 'PROCESANDO RADICACIÓN';
            span.classList.add('loading-dots');
        }
        btn.style.pointerEvents = 'none';
        btn.style.opacity = '0.8';
    });
}

/**
 * Genera una plantilla de Excel dinámica con validaciones de datos
 * @async
 */
async function generateExcelTemplate() {
    const workbook = new ExcelJS.Workbook();
    const worksheet = workbook.addWorksheet('Plantilla Renapp');

    const headers = [
        'Tipo_de_documento', 'Número_de_documento', 'Nombres', 'Apellidos', 
        'Fecha_de_Nacimiento', 'Sexo', 'Estado_Civil', 'Nivel_Escolar', 
        'Departamento', 'Municipio', 'Tipo_Dirección', 'Dirección', 
        'Teléfono', 'Celular', 'Correo_electrónico', 'IBC', 
        'Tipo_de_Afiliado', 'EPS', 'Regional', 'AFP', 'ARL'
    ];

    const headerRow = worksheet.addRow(headers);
    headerRow.font = { bold: true, color: { argb: 'FFFFFFFF' }, size: 11 };
    headerRow.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF10B981' } }; // Color Esmeralda para Afiliados
    headerRow.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 25;

    // Configuración de listas desplegables vía hoja oculta
    const configSheet = workbook.addWorksheet('Config', { state: 'hidden' });
    const options = {
        doc: ['CC', 'CE', 'TI', 'RC', 'PT'],
        sexo: ['Masculino', 'Femenino', 'Otro'],
        estado: ['Soltero/a', 'Casado/a', 'Divorciado/a', 'Viudo/a', 'Unión Libre'],
        afiliado: ['Cotizante', 'Beneficiario']
    };

    options.doc.forEach((opt, i) => configSheet.getCell(`A${i + 1}`).value = opt);
    options.sexo.forEach((opt, i) => configSheet.getCell(`B${i + 1}`).value = opt);
    options.estado.forEach((opt, i) => configSheet.getCell(`C${i + 1}`).value = opt);
    options.afiliado.forEach((opt, i) => configSheet.getCell(`D${i + 1}`).value = opt);

    // Aplicar validación a las primeras 500 filas para guiar al usuario
    for (let i = 2; i <= 500; i++) {
        worksheet.getCell(`A${i}`).dataValidation = { type: 'list', allowBlank: true, formulae: [`Config!$A$1:$A$${options.doc.length}`] };
        worksheet.getCell(`F${i}`).dataValidation = { type: 'list', allowBlank: true, formulae: [`Config!$B$1:$B$${options.sexo.length}`] };
        worksheet.getCell(`G${i}`).dataValidation = { type: 'list', allowBlank: true, formulae: [`Config!$C$1:$C$${options.estado.length}`] };
        worksheet.getCell(`Q${i}`).dataValidation = { type: 'list', allowBlank: true, formulae: [`Config!$D$1:$D$${options.afiliado.length}`] };
    }

    // Auto-ajuste de ancho de columnas para legibilidad
    worksheet.columns.forEach(col => { col.width = 25; });

    // Generación del archivo y descarga automática
    const buffer = await workbook.xlsx.writeBuffer();
    const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'Plantilla_Radicacion_Masiva.xlsx';
    link.click();
    
    console.log('✅ Plantilla Excel generada exitosamente.');
}
