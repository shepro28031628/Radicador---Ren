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
    initAfiliadoLookup();
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

    if (isActive) {
        // Verificar campos obligatorios antes de permitir activar el check
        const mandatoryFields = ['tipoSolicitud', 'nombreRadicador', 'cedula', 'nombres', 'apellidos', 'celular', 'email', 'eps', 'arl', 'afp'];
        let missing = false;
        mandatoryFields.forEach(id => {
            const el = document.getElementById(id);
            if (el && !el.value) missing = true;
        });

        if (missing) {
            check.checked = false;
            showMandatoryModal();
            return;
        }
    }

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
 * Funciones para el manejo del Modal de Alerta
 */
function showMandatoryModal() {
    const modal = document.getElementById('mandatoryModal');
    const content = document.getElementById('modalContent');
    if (modal) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            if (content) content.classList.remove('scale-95');
            if (content) content.classList.add('scale-100');
        }, 10);
    }
}

function closeModal() {
    const modal = document.getElementById('mandatoryModal');
    const content = document.getElementById('modalContent');
    if (modal) {
        modal.classList.remove('opacity-100');
        if (content) content.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
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
 * Genera una plantilla de Excel dinámica con validaciones de datos (PASO 1)
 */
async function generateExcelTemplate() {
    const workbook = new ExcelJS.Workbook();
    const worksheet = workbook.addWorksheet('Plantilla Afiliados');

    const headers = [
        'Tipo_de_documento', 'Número_de_documento', 'Nombres', 'Apellidos', 
        'Fecha_de_Nacimiento', 'Sexo', 'Estado_Civil', 'Nivel_Escolar', 
        'Departamento', 'Municipio', 'Tipo_Dirección', 'Dirección', 
        'Teléfono', 'Celular', 'Correo_electrónico', 'EPS', 'Regional', 'AFP', 'ARL'
    ];

    const headerRow = worksheet.addRow(headers);
    headerRow.font = { bold: true, color: { argb: 'FFFFFFFF' }, size: 10 };
    headerRow.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF10B981' } };
    headerRow.alignment = { vertical: 'middle', horizontal: 'center' };

    // Configuración de listas desplegables
    const configSheet = workbook.addWorksheet('Config', { state: 'hidden' });
    const options = {
        doc: ['CC', 'CE', 'TI', 'RC', 'PT'],
        sexo: ['Masculino', 'Femenino', 'Otro'],
        estado: ['Soltero/a', 'Casado/a', 'Divorciado/a', 'Viudo/a', 'Unión Libre']
    };

    options.doc.forEach((opt, i) => configSheet.getCell(`A${i + 1}`).value = opt);
    options.sexo.forEach((opt, i) => configSheet.getCell(`B${i + 1}`).value = opt);
    options.estado.forEach((opt, i) => configSheet.getCell(`C${i + 1}`).value = opt);

    for (let i = 2; i <= 300; i++) {
        worksheet.getCell(`A${i}`).dataValidation = { type: 'list', allowBlank: true, formulae: [`Config!$A$1:$A$${options.doc.length}`] };
        worksheet.getCell(`F${i}`).dataValidation = { type: 'list', allowBlank: true, formulae: [`Config!$B$1:$B$${options.sexo.length}`] };
        worksheet.getCell(`G${i}`).dataValidation = { type: 'list', allowBlank: true, formulae: [`Config!$C$1:$C$${options.estado.length}`] };
    }

    worksheet.columns.forEach(col => { col.width = 18; });

    const buffer = await workbook.xlsx.writeBuffer();
    saveExcel(buffer, 'Plantilla_Masiva_Afiliados.xlsx');
}

/**
 * Genera la plantilla para Carga de Servicios (PASO 2)
 */
async function generateServicesTemplate() {
    const workbook = new ExcelJS.Workbook();
    const worksheet = workbook.addWorksheet('Plantilla Servicios');

    const headers = ['Tipo_de_documento', 'Número_de_documento', 'servicios', 'usuarios'];
    const headerRow = worksheet.addRow(headers);
    headerRow.font = { bold: true, color: { argb: 'FFFFFFFF' } };
    headerRow.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FFF59E0B' } }; // Amber

    worksheet.columns.forEach(col => { col.width = 22; });

    const buffer = await workbook.xlsx.writeBuffer();
    saveExcel(buffer, 'Plantilla_Carga_Servicios.xlsx');
}

function saveExcel(buffer, filename) {
    const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = filename;
    link.click();
}

/**
 * Simulación de Búsqueda de Afiliados por Número de Identificación
 */
function initAfiliadoLookup() {
    const cedulaInput = document.getElementById('cedula');
    const searchIcon = document.getElementById('searchIcon');
    const loadingIcon = document.getElementById('loadingIcon');
    
    if (!cedulaInput) return;

    cedulaInput.addEventListener('input', async () => {
        const val = cedulaInput.value.trim();
        if (val !== '12345') {
            // Limpiar estilos si no coincide
            cedulaInput.classList.remove('border-emerald-500', 'bg-emerald-50/30');
            return;
        }

        // Activar estado de carga
        if (searchIcon) searchIcon.classList.add('hidden');
        if (loadingIcon) loadingIcon.classList.remove('hidden');

        // Simulación de latencia de red
        await new Promise(resolve => setTimeout(resolve, 600));

        // Re-validar por si el usuario borró mientras cargaba
        if (cedulaInput.value.trim() === '12345') {
            document.getElementById('nombres').value = "JUAN CARLOS";
            document.getElementById('apellidos').value = "PEREZ RODRIGUEZ";
            document.getElementById('sexo').value = "Masculino";
            document.getElementById('estadoCivil').value = "Casado/a";
            document.getElementById('celular').value = "3001234567";
            document.getElementById('email').value = "juan.perez@renapp.com";
            document.getElementById('eps').value = "NUEVA EPS";
            document.getElementById('arl').value = "SURA ARL";
            document.getElementById('afp').value = "PORVENIR";
            
            cedulaInput.classList.add('border-emerald-500', 'bg-emerald-50/30');
            console.log('✅ Afiliado recuperado instantáneamente.');
        }

        // Desactivar estado de carga
        if (searchIcon) searchIcon.classList.remove('hidden');
        if (loadingIcon) loadingIcon.classList.add('hidden');
    });

    // Marcar campos como "encontrados" para saber cuáles limpiar
    ['nombres', 'apellidos', 'celular', 'email', 'eps', 'arl', 'afp'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', () => delete el.dataset.found);
        }
    });
}
