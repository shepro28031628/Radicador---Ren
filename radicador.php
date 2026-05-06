<?php 
// Inicialización preventiva de respuesta
$response = ['success' => false, 'message' => ''];

/**
 * RENAPP - RADICADOR DIGITAL
 * @version 2.0
 */
require_once 'includes/procesar.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radicación Digital | Renapp Ecosystem</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="min-h-screen flex flex-col">

    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-50 py-2">
        <div class="max-w-[1900px] mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="Logo-Ren.png" alt="Logo Ren" class="h-10 w-auto">
                <div class="h-8 w-[1px] bg-slate-200 hidden md:block"></div>
                <h1 class="text-xl font-black text-slate-800 tracking-tighter leading-none uppercase hidden md:block">Radicador</h1>
            </div>
            <div class="bg-indigo-50 px-3 py-1.5 rounded-lg border border-indigo-100 flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span id="currentDateDisplay" class="text-[10px] font-bold text-indigo-700 uppercase"></span>
            </div>
        </div>
    </header>

    <main class="flex-grow px-6 py-4 w-full max-w-[1900px] mx-auto">
        <!-- Sistema de Alertas Dinámicas -->
        <?php if (!empty($response['message'])): ?>
        <div class="alert-premium p-4 mb-4 flex items-center gap-4 shadow-lg border-l-4 <?php echo $response['success'] ? 'border-emerald-500 bg-emerald-50' : 'border-rose-500 bg-rose-50'; ?>">
            <div class="<?php echo $response['success'] ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600'; ?> p-2 rounded-full">
                <?php if ($response['success']): ?>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                <?php else: ?>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <?php endif; ?>
            </div>
            <div>
                <h4 class="font-bold text-sm <?php echo $response['success'] ? 'text-emerald-800' : 'text-rose-800'; ?>">
                    <?php echo $response['success'] ? '¡Operación Exitosa!' : 'Atención / Error'; ?>
                </h4>
                <p class="text-xs <?php echo $response['success'] ? 'text-emerald-700' : 'text-rose-700'; ?> opacity-90"><?php echo $response['message']; ?></p>
            </div>
        </div>
        <?php endif; ?>

        <form id="mainRadicadorForm" action="radicador.php" method="POST" enctype="multipart/form-data">
            <!-- Token de fecha invisible para persistencia en backend -->
            <input type="hidden" id="fechaSolicitud" name="fechaSolicitud" value="<?php echo date('Y-m-d'); ?>">
            
            <div class="flex flex-col lg:flex-row gap-4">
                
                <!-- 
                    CONTENEDOR IZQUIERDO (75%)
                    Agrupa los bloques de entrada de datos en un stack vertical.
                -->
                <div class="w-full lg:w-3/4 flex flex-col gap-4">
                    
                    <!-- 
                        SECCIÓN 1: DETALLES DE LA SOLICITUD
                        Captura el contexto administrativo de la radicación.
                    -->
                    <div class="section-card glass-panel p-4">
                        <div class="section-title-premium mb-4">
                            <div class="bg-indigo-100 p-1.5 rounded-lg text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-tight">Detalles de la Solicitud</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="tipoSolicitud" class="required text-[10px]">TIPO DE SOLICITUD</label>
                                <select id="tipoSolicitud" name="tipoSolicitud" class="input-premium w-full text-sm py-2" required>
                                    <option value="">Seleccione...</option>
                                    <option value="AUDITORIA DE INCAPACIDADES">AUDITORIA DE INCAPACIDADES</option>
                                    <option value="AUDITORIA DE INCAPACIDADES - LM/LP">AUDITORIA DE INCAPACIDADES - LM/LP</option>
                                    <option value="AUDITORIA SEGUIMIENTO PRI">AUDITORIA SEGUIMIENTO PRI</option>
                                    <option value="CALIFICACION DE ORIGEN AT">CALIFICACION DE ORIGEN AT</option>
                                    <option value="CALIFICACION DE ORIGEN EL">CALIFICACION DE ORIGEN EL</option>
                                    <option value="CERTIFICADO DE DISCAPACIDAD">CERTIFICADO DE DISCAPACIDAD</option>
                                    <option value="CONCEPTO DE REHABILITACION">CONCEPTO DE REHABILITACION</option>
                                    <option value="CONSOLIDACIÓN DE DOCUMENTOS">CONSOLIDACIÓN DE DOCUMENTOS</option>
                                    <option value="CONTROVERSIAS">CONTROVERSIAS</option>
                                    <option value="GLOSAS">GLOSAS</option>
                                    <option value="INFORMATIVO">INFORMATIVO</option>
                                    <option value="PCL">PCL</option>
                                    <option value="PROGRAMA PRI">PROGRAMA PRI</option>
                                    <option value="RECOBRO">RECOBRO</option>
                                    <option value="RECOBRO DESDE EPS HACIA ARL">RECOBRO DESDE EPS HACIA ARL</option>
                                    <option value="RECOMENDACIONES MÉDICAS">RECOMENDACIONES MÉDICAS</option>
                                    <option value="VALORACIÓN MÉDICA">VALORACIÓN MÉDICA</option>
                                </select>
                            </div>
                            <div>
                                <label for="nombreRadicador" class="required text-[10px]">NOMBRE DEL RADICADOR</label>
                                <input type="text" id="nombreRadicador" name="nombreRadicador" class="input-premium w-full text-sm py-2" placeholder="Nombre completo" required>
                            </div>
                        </div>
                    </div>

                    <!-- 
                        SECCIÓN 2: INFORMACIÓN DEL PACIENTE
                        Contenedor de los 21 campos obligatorios alineados con la plantilla Excel.
                        Layout: 5 columnas (Desktop) para optimizar espacio vertical.
                    -->
                    <div class="section-card glass-panel p-3">
                        <div class="section-title-premium mb-3">
                            <div class="bg-blue-100 p-1.5 rounded-lg text-blue-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <span class="text-[11px] font-bold uppercase tracking-tight">Información Integral del Paciente</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-2.5">
                            <div>
                                <label for="tipoDoc" class="required text-[10px]">TIPO IDENTIFICACION</label>
                                <select id="tipoDoc" name="tipoDoc" class="input-premium w-full text-sm py-2" required>
                                    <option value="CC">CC</option>
                                    <option value="CE">CE</option>
                                    <option value="TI">TI</option>
                                    <option value="RC">RC</option>
                                    <option value="PT">PT</option>
                                </select>
                            </div>
                            <div class="relative group">
                                <label for="cedula" class="required text-[10px]">NUMERO IDENTIFICACION</label>
                                <div class="relative">
                                    <input type="text" id="cedula" name="cedula" class="input-premium w-full text-sm py-2 pr-10" placeholder="Número" required>
                                    <div id="searchIndicator" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="searchIcon"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        <svg class="w-4 h-4 animate-spin hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="loadingIcon"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="nombres" class="required text-[10px]">NOMBRES</label>
                                <input type="text" id="nombres" name="nombres" class="input-premium w-full text-sm py-2" placeholder="Nombres" required>
                            </div>
                            <div>
                                <label for="apellidos" class="required text-[10px]">APELLIDOS</label>
                                <input type="text" id="apellidos" name="apellidos" class="input-premium w-full text-sm py-2" placeholder="Apellidos" required>
                            </div>
                            <div>
                                <label for="fechaNacimiento" class="required text-[10px]">FECHA NACIMIENTO</label>
                                <input type="date" id="fechaNacimiento" name="fechaNacimiento" class="input-premium w-full text-sm py-2" required>
                            </div>
                            <div>
                                <label for="sexo" class="required text-[10px]">SEXO</label>
                                <select id="sexo" name="sexo" class="input-premium w-full text-sm py-2" required>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div>
                                <label for="estadoCivil" class="required text-[10px]">ESTADO CIVIL</label>
                                <select id="estadoCivil" name="estadoCivil" class="input-premium w-full text-sm py-2" required>
                                    <option value="Soltero/a">Soltero/a</option>
                                    <option value="Casado/a">Casado/a</option>
                                    <option value="Divorciado/a">Divorciado/a</option>
                                    <option value="Viudo/a">Viudo/a</option>
                                    <option value="Unión Libre">Unión Libre</option>
                                </select>
                            </div>
                            <div>
                                <label for="nivelEscolar" class="text-[10px]">NIVEL ESCOLAR</label>
                                <input type="text" id="nivelEscolar" name="nivelEscolar" class="input-premium w-full text-sm py-2" placeholder="Ej: Profesional">
                            </div>
                            <div>
                                <label for="departamento" class="required text-[10px]">DEPARTAMENTO</label>
                                <input type="text" id="departamento" name="departamento" class="input-premium w-full text-sm py-2" placeholder="Nombre Depto" required>
                            </div>
                            <div>
                                <label for="municipio" class="required text-[10px]">MUNICIPIO</label>
                                <input type="text" id="municipio" name="municipio" class="input-premium w-full text-sm py-2" placeholder="Nombre Municipio" required>
                            </div>
                            <div>
                                <label for="tipoDireccion" class="text-[10px]">TIPO DIRECCIÓN</label>
                                <select id="tipoDireccion" name="tipoDireccion" class="input-premium w-full text-sm py-2">
                                    <option value="Residencial">Residencial</option>
                                    <option value="Laboral">Laboral</option>
                                </select>
                            </div>
                            <div>
                                <label for="direccion" class="required text-[10px]">DIRECCIÓN</label>
                                <input type="text" id="direccion" name="direccion" class="input-premium w-full text-sm py-2" placeholder="Dirección completa" required>
                            </div>
                            <div>
                                <label for="telefono" class="text-[10px]">TELÉFONO</label>
                                <input type="text" id="telefono" name="telefono" class="input-premium w-full text-sm py-2" placeholder="Fijo">
                            </div>
                            <div>
                                <label for="celular" class="required text-[10px]">CELULAR</label>
                                <input type="text" id="celular" name="celular" class="input-premium w-full text-sm py-2" placeholder="Móvil" required>
                            </div>
                            <div>
                                <label for="email" class="required text-[10px]">CORREO ELECTRÓNICO</label>
                                <input type="email" id="email" name="email" class="input-premium w-full text-sm py-2" placeholder="correo@ejemplo.com" required>
                            </div>
                            <div>
                                <label for="ibc" class="text-[10px]">IBC (INGRESO BASE)</label>
                                <input type="number" id="ibc" name="ibc" class="input-premium w-full text-sm py-2" placeholder="0.00">
                            </div>
                            <div>
                                <label for="tipoAfiliado" class="required text-[10px]">TIPO AFILIADO</label>
                                <select id="tipoAfiliado" name="tipoAfiliado" class="input-premium w-full text-sm py-2" required>
                                    <option value="Cotizante">Cotizante</option>
                                    <option value="Beneficiario">Beneficiario</option>
                                </select>
                            </div>
                            <div>
                                <label for="eps" class="required text-[10px]">EPS</label>
                                <input type="text" id="eps" name="eps" class="input-premium w-full text-sm py-2" placeholder="Nombre EPS" required>
                            </div>
                            <div>
                                <label for="arl" class="required text-[10px]">ARL</label>
                                <input type="text" id="arl" name="arl" class="input-premium w-full text-sm py-2" placeholder="Nombre ARL" required>
                            </div>
                            <div>
                                <label for="afp" class="required text-[10px]">AFP / FONDO</label>
                                <input type="text" id="afp" name="afp" class="input-premium w-full text-sm py-2" placeholder="Nombre AFP" required>
                            </div>
                            <div class="md:col-span-1">
                                <label for="regional" class="text-[10px]">REGIONAL</label>
                                <input type="text" id="regional" name="regional" class="input-premium w-full text-sm py-2" placeholder="Regional">
                            </div>
                        </div>
                    </div>

                    <!-- 
                        SECCIÓN 3: DOCUMENTACIÓN ADJUNTA
                        Sistema híbrido: Pestañas para carga individual o masiva.
                    -->
                    <div class="section-card glass-panel p-3">
                        <div class="flex items-center justify-between mb-3">
                            <div class="section-title-premium !mb-0">
                                <div class="bg-indigo-100 p-1.5 rounded-lg text-indigo-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                </div>
                                <span class="text-[11px] font-bold uppercase tracking-tight">Documentación Adjunta</span>
                            </div>
                            <!-- Control de Pestañas -->
                            <div class="flex gap-1 p-1 bg-slate-100/50 rounded-lg">
                                <button type="button" onclick="switchTab('individual')" id="tab-individual" class="tab-btn active px-3 py-1 rounded-md text-[9px] font-bold transition-all">INDIVIDUAL</button>
                                <button type="button" onclick="switchTab('masiva')" id="tab-masiva" class="tab-btn px-3 py-1 rounded-md text-[9px] font-bold text-slate-500 transition-all">MASIVA</button>
                            </div>
                        </div>

                        <div id="content-individual" class="tab-content">
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
                                <div class="upload-card-interactive !p-2" onclick="document.getElementById('doc_historia_clinica').click()">
                                    <div class="file-icon !w-7 !h-7 mb-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                                    <h5 class="text-[8px] font-bold text-slate-700 uppercase leading-tight">Historia Clínica</h5>
                                    <input type="file" id="doc_historia_clinica" name="doc_historia_clinica" class="hidden doc-input">
                                </div>
                                <div class="upload-card-interactive !p-2" onclick="document.getElementById('doc_furel').click()">
                                    <div class="file-icon !w-7 !h-7 mb-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                                    <h5 class="text-[8px] font-bold text-slate-700 uppercase leading-tight">FUREL</h5>
                                    <input type="file" id="doc_furel" name="doc_furel" class="hidden doc-input">
                                </div>
                                <div class="upload-card-interactive !p-2" onclick="document.getElementById('doc_evaluaciones_medicas').click()">
                                    <div class="file-icon !w-7 !h-7 mb-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>
                                    <h5 class="text-[8px] font-bold text-slate-700 uppercase leading-tight">Eval. Médicas</h5>
                                    <input type="file" id="doc_evaluaciones_medicas" name="doc_evaluaciones_medicas" class="hidden doc-input">
                                </div>
                                <div class="upload-card-interactive !p-2" onclick="document.getElementById('doc_certificado_cargos').click()">
                                    <div class="file-icon !w-7 !h-7 mb-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div>
                                    <h5 class="text-[8px] font-bold text-slate-700 uppercase leading-tight">Cert. Cargos</h5>
                                    <input type="file" id="doc_certificado_cargos" name="doc_certificado_cargos" class="hidden doc-input">
                                </div>
                                <div class="upload-card-interactive !p-2" onclick="document.getElementById('doc_analisis_puesto').click()">
                                    <div class="file-icon !w-7 !h-7 mb-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></div>
                                    <h5 class="text-[8px] font-bold text-slate-700 uppercase leading-tight">Análisis Puesto</h5>
                                    <input type="file" id="doc_analisis_puesto" name="doc_analisis_puesto" class="hidden doc-input">
                                </div>
                                <div class="upload-card-interactive !p-2" onclick="document.getElementById('doc_matriz_riesgo').click()">
                                    <div class="file-icon !w-7 !h-7 mb-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                                    <h5 class="text-[8px] font-bold text-slate-700 uppercase leading-tight">Matriz Riesgo</h5>
                                    <input type="file" id="doc_matriz_riesgo" name="doc_matriz_riesgo" class="hidden doc-input">
                                </div>
                                <div class="upload-card-interactive !p-2" onclick="document.getElementById('doc_paraclinicos').click()">
                                    <div class="file-icon !w-7 !h-7 mb-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg></div>
                                    <h5 class="text-[8px] font-bold text-slate-700 uppercase leading-tight">Paraclínicos</h5>
                                    <input type="file" id="doc_paraclinicos" name="doc_paraclinicos" class="hidden doc-input">
                                </div>
                                <div class="upload-card-interactive !p-2" onclick="document.getElementById('doc_autorizacion_hc').click()">
                                    <div class="file-icon !w-7 !h-7 mb-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.414a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg></div>
                                    <h5 class="text-[8px] font-bold text-slate-700 uppercase leading-tight">Aut. Entrega HC</h5>
                                    <input type="file" id="doc_autorizacion_hc" name="doc_autorizacion_hc" class="hidden doc-input">
                                </div>
                                <div class="upload-card-interactive !p-2" onclick="document.getElementById('doc_planilla_pila').click()">
                                    <div class="file-icon !w-7 !h-7 mb-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                                    <h5 class="text-[8px] font-bold text-slate-700 uppercase leading-tight">Pagos PILA</h5>
                                    <input type="file" id="doc_planilla_pila" name="doc_planilla_pila" class="hidden doc-input">
                                </div>
                                <div class="upload-card-interactive !p-2" onclick="document.getElementById('doc_cedula').click()">
                                    <div class="file-icon !w-7 !h-7 mb-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg></div>
                                    <h5 class="text-[8px] font-bold text-slate-700 uppercase leading-tight">Fotocopia Cédula</h5>
                                    <input type="file" id="doc_cedula" name="doc_cedula" class="hidden doc-input">
                                </div>
                            </div>
                        </div>

                        <div id="content-masiva" class="tab-content hidden space-y-3">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <!-- Paso 1: Carga Masiva Afiliados -->
                                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-3 relative overflow-hidden group">
                                    <div class="absolute top-0 right-0 bg-emerald-500 text-white text-[10px] font-black px-2 py-0.5 rounded-bl-lg">PASO 1</div>
                                    <h4 class="text-[11px] font-bold text-slate-800 mb-1 uppercase tracking-tight">Carga Masiva Afiliados</h4>
                                    <p class="text-[9px] text-slate-500 mb-2 leading-tight">Excel con 18 campos obligatorios para creación o actualización.</p>
                                    <input type="file" id="masiva_afiliados" name="masiva_afiliados" class="block w-full text-[9px] text-slate-500 border border-slate-100 rounded-lg bg-slate-50 mb-2 py-1 px-2">
                                    <div class="flex gap-1.5">
                                        <button type="button" class="flex-1 bg-emerald-600 text-white text-[9px] font-bold py-1.5 rounded-lg hover:bg-emerald-700 transition-all">CARGAR</button>
                                        <button type="button" onclick="generateExcelTemplate()" class="flex-1 bg-white border border-emerald-200 text-emerald-600 text-[9px] font-bold py-1.5 rounded-lg hover:bg-emerald-50 transition-all">PLANTILLA</button>
                                    </div>
                                </div>

                                <!-- Paso 2: Cargar Servicios -->
                                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-3 relative overflow-hidden group">
                                    <div class="absolute top-0 right-0 bg-amber-500 text-white text-[10px] font-black px-2 py-0.5 rounded-bl-lg">PASO 2</div>
                                    <h4 class="text-[11px] font-bold text-slate-800 mb-1 uppercase tracking-tight">Cargar Servicios</h4>
                                    <p class="text-[9px] text-slate-500 mb-2 leading-tight">Excel [Tipo_Doc - Numero - Servicios - Usuarios]</p>
                                    <input type="file" id="masiva_servicios" name="masiva_servicios" class="block w-full text-[9px] text-slate-500 border border-slate-100 rounded-lg bg-slate-50 mb-2 py-1 px-2">
                                    <div class="flex gap-1.5">
                                        <button type="button" class="flex-1 bg-amber-500 text-white text-[9px] font-bold py-1.5 rounded-lg hover:bg-amber-600 transition-all">CARGAR</button>
                                        <button type="button" onclick="generateServicesTemplate()" class="flex-1 bg-white border border-amber-200 text-amber-600 text-[9px] font-bold py-1.5 rounded-lg hover:bg-amber-50 transition-all">PLANTILLA</button>
                                    </div>
                                </div>

                                <!-- Paso 3: Registro y ZIP -->
                                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-3 relative overflow-hidden group">
                                    <div class="absolute top-0 right-0 bg-indigo-600 text-white text-[10px] font-black px-2 py-0.5 rounded-bl-lg">PASO 3</div>
                                    <h4 class="text-[11px] font-bold text-slate-800 mb-1 uppercase tracking-tight">Cargar Documentos</h4>
                                    <p class="text-[9px] text-slate-500 mb-2 leading-tight">Excel <b>REGISTRO.xlsx</b> + Archivo <b>ZIP</b> con documentos.</p>
                                    <div class="space-y-1.5 mb-2">
                                        <input type="file" id="masiva_excel_registro" name="masiva_excel_registro" class="block w-full text-[9px] text-slate-500 border border-slate-100 rounded-lg bg-slate-50 py-0.5 px-2" placeholder="REGISTRO.xlsx">
                                        <input type="file" id="masiva_zip" name="masiva_zip" class="block w-full text-[9px] text-slate-500 border border-slate-100 rounded-lg bg-slate-50 py-0.5 px-2" accept=".zip" placeholder="DOCS.zip">
                                    </div>
                                    <button type="button" class="w-full bg-indigo-600 text-white text-[9px] font-bold py-1.5 rounded-lg hover:bg-indigo-700 transition-all">PROCESAR LOTE COMPLETO</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 
                    COLUMNA DERECHA (25%)
                    Acciones finales y validación de seguridad.
                    Posicionamiento: Sticky para persistencia durante el scroll.
                -->
                <div class="w-full lg:w-1/4">
                    <div class="section-card glass-panel sticky top-20 p-4">
                        <div class="section-title-premium mb-4">
                            <div class="bg-indigo-600 p-1.5 rounded-lg text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm font-bold uppercase tracking-tight">Finalizar</span>
                        </div>
                        <label class="mb-4 p-3 bg-white/70 rounded-xl border border-indigo-100 hover:border-indigo-300 transition-all cursor-pointer group flex items-center gap-3 select-none">
                            <input type="checkbox" id="confirmCheck" class="sr-only" onchange="validateForm()">
                            <div class="w-6 h-6 border-2 border-slate-300 rounded-lg bg-white flex items-center justify-center transition-all group-hover:border-indigo-400" id="customCheckVisual">
                                <svg class="w-3.5 h-3.5 text-white scale-0 transition-transform duration-200" id="checkIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-[10px] font-bold text-slate-600 leading-tight">He verificado que la información y los documentos son correctos.</span>
                        </label>
                        <button type="submit" id="submitBtn" class="btn-premium w-full justify-center py-4 opacity-50 cursor-not-allowed pointer-events-none" disabled>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm font-bold">RADICAR</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <footer class="mt-auto py-3 border-t border-slate-200/60 bg-white/80 backdrop-blur-md">
        <div class="max-w-[1900px] mx-auto px-6 flex items-center justify-center gap-6">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none">© 2026 - Renapp</p>
            <img src="Logo-Ren.png" alt="Logo Ren" class="h-5 opacity-80">
        </div>
    </footer>

    <!-- Modal de Alerta: Campos Obligatorios -->
    <div id="mandatoryModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white/90 glass-panel max-w-sm w-full p-6 m-4 shadow-2xl scale-95 transition-transform duration-300" id="modalContent">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center text-rose-600 mb-4 animate-pulse">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight mb-2">Atención: Datos Incompletos</h3>
                <p class="text-xs text-slate-600 font-medium mb-6 leading-relaxed">Hay campos que son obligatorios. Se deben suministrar los datos faltantes para continuar con la radicación.</p>
                <button type="button" onclick="closeModal()" class="w-full py-3 bg-slate-800 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-slate-900 shadow-lg transition-all active:scale-95">Entendido</button>
            </div>
        </div>
    </div>

    <script src="assets/js/radicador.js"></script>
</body>
</html>
