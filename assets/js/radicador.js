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
 * @param {string} tabName - El nombre de la pestaña a activar
 */
function switchTab(tabName) {
    const form = document.getElementById('mainRadicadorForm');
    const inputs = form.querySelectorAll('input:not([type="file"]), select');
    
    // Actualizar estados visuales de los botones
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-white', 'text-indigo-600');
        btn.classList.add('text-slate-500');
    });
    
    const activeBtn = document.getElementById(`tab-${tabName}`);
    if (activeBtn) {
        activeBtn.classList.add('active', 'bg-white', 'text-indigo-600');
        activeBtn.classList.remove('text-slate-500');
    }

    // Cambiar visibilidad de contenidos
    document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
    const targetContent = document.getElementById(`content-${tabName}`);
    if (targetContent) targetContent.classList.remove('hidden');

    // Lógica de obligatoriedad dinámica
    const isMasiva = tabName === 'masiva';
    form.classList.toggle('hide-required', isMasiva);
    
    inputs.forEach(input => {
        if (isMasiva) {
            if (input.required) input.setAttribute('data-was-required', 'true');
            input.required = false;
        } else {
            if (input.getAttribute('data-was-required') === 'true') input.required = true;
        }
    });
}

/**
 * Configura los eventos para la carga de archivos (click y drag & drop)
 */
function initFileUploads() {
    const docInputs = document.querySelectorAll('.doc-input, #excel_upload');
    
    docInputs.forEach(input => {
        const card = input.closest('.upload-card-interactive');
        if (!card) return;

        input.addEventListener('change', function() {
            if (this.files.length > 0) {
                card.classList.add('active');
                const statusText = card.querySelector('h5') || card.querySelector('.status-text');
                const fileName = this.files.length === 1 ? this.files[0].name : `${this.files.length} archivos`;
                if (statusText) statusText.innerHTML = `<span class="text-indigo-600 font-bold">✔ ${fileName}</span>`;
                
                // Animación de feedback
                card.style.transform = 'scale(1.02)';
                setTimeout(() => card.style.transform = 'translateY(-2px)', 200);
            }
        });

        // Eventos Drag & Drop
        card.addEventListener('dragover', (e) => { e.preventDefault(); card.classList.add('border-indigo-400', 'bg-indigo-50/50'); });
        card.addEventListener('dragleave', () => card.classList.remove('border-indigo-400', 'bg-indigo-50/50'));
        card.addEventListener('drop', (e) => {
            e.preventDefault();
            card.classList.remove('border-indigo-400', 'bg-indigo-50/50');
            if (e.dataTransfer.files.length > 0) {
                input.files = e.dataTransfer.files;
                input.dispatchEvent(new Event('change'));
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
        'Nombres', 'Apellidos', 'Tipo Documento', 'Cédula', 
        'Celulares', 'Email', 'EPS', 'ARL', 'AFP', 'Tipo Afiliado', 'Tipo Solicitud'
    ];

    const headerRow = worksheet.addRow(headers);
    headerRow.font = { bold: true, color: { argb: 'FFFFFFFF' }, size: 12 };
    headerRow.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF6366F1' } };
    headerRow.alignment = { vertical: 'middle', horizontal: 'center' };
    headerRow.height = 25;

    // Configuración de listas desplegables vía hoja oculta
    const configSheet = workbook.addWorksheet('Config', { state: 'hidden' });
    const options = {
        doc: ['CC', 'CE', 'TI'],
        afiliado: ['Cotizante', 'Beneficiario'],
        solicitud: [
            'Valoración medica telemedicina', 'Valoración medica presencial',
            'Concepto de rehabilitación', 'Recomendaciones laborales',
            'Calificación de origen', 'Calificación de PCLO',
            'Auditoria de seguimiento PRI', 
            'Solicitudes de autorizacion de incapacidades y licencias - Liquidacion',
            'Auditoria De Incapacidades Diferentes A Mayores De 540 Dias',
            'Auditoria De Incapacidades', 'Auditoria De Incapacidades - Lm/Lp'
        ]
    };

    options.doc.forEach((opt, i) => configSheet.getCell(`A${i + 1}`).value = opt);
    options.afiliado.forEach((opt, i) => configSheet.getCell(`B${i + 1}`).value = opt);
    options.solicitud.forEach((opt, i) => configSheet.getCell(`C${i + 1}`).value = opt);

    // Aplicar validación a las primeras 100 filas
    for (let i = 2; i <= 100; i++) {
        worksheet.getCell(`C${i}`).dataValidation = { type: 'list', allowBlank: true, formulae: [`Config!$A$1:$A$${options.doc.length}`] };
        worksheet.getCell(`J${i}`).dataValidation = { type: 'list', allowBlank: true, formulae: [`Config!$B$1:$B$${options.afiliado.length}`] };
        worksheet.getCell(`K${i}`).dataValidation = { type: 'list', allowBlank: true, formulae: [`Config!$C$1:$C$${options.solicitud.length}`] };
    }

    worksheet.columns.forEach(col => { col.width = 25; });

    const buffer = await workbook.xlsx.writeBuffer();
    const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'Plantilla_Radicacion_Masiva.xlsx';
    link.click();
}
