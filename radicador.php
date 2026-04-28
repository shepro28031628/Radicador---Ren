<?php 
/**
 * Renapp Radicador - Vista Principal
 * @version 2.0.0
 * 
 * Este archivo actúa como el punto de entrada de la aplicación (View).
 * La lógica de negocio reside en includes/procesar.php.
 */
require_once 'includes/procesar.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radicación Digital | Renapp Ecosystem</title>
    
    <!-- Librerías Externas -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
    
    <!-- Estilos Premium Modulares -->
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="min-h-screen flex flex-col">

    <!-- Header Premium Ampliado -->
    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-50 py-3">
        <div class="max-w-[1900px] mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center gap-6">
                <img src="Logo-Ren.png" alt="Logo Ren" class="h-12 w-auto">
                <div class="h-10 w-[1px] bg-slate-200 hidden md:block"></div>
                <div class="hidden md:block">
                    <h1 class="text-2xl font-black text-slate-800 tracking-tighter leading-none uppercase">Radicador Digital</h1>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="bg-indigo-50 px-4 py-2 rounded-xl border border-indigo-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span id="currentDateDisplay" class="text-xs font-bold text-indigo-700"></span>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow px-6 py-3 w-full max-w-[1900px] mx-auto">
        
        <!-- Feedback de Operación -->
        <?php if ($response['success']): ?>
        <div class="alert-premium p-4 mb-4 flex items-center gap-4 shadow-lg">
            <div class="bg-emerald-100 p-2 rounded-full">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-sm">¡Operación Exitosa!</h4>
                <p class="text-xs opacity-80"><?php echo $response['message']; ?></p>
            </div>
        </div>
        <?php endif; ?>

        <form id="mainRadicadorForm" action="radicador.php" method="POST" enctype="multipart/form-data">
            <div class="flex flex-col lg:flex-row gap-5">
                
                <!-- Columna Izquierda: Formulario Principal (75%) -->
                <div class="w-full lg:w-3/4 space-y-4">
                    
                    <!-- Sección 1: Detalles de la Solicitud -->
                    <div class="section-card glass-panel !p-4">
                        <div class="section-title-premium mb-2">
                            <div class="bg-indigo-100 p-1.5 rounded-lg text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-tight">Detalles de la Solicitud</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="tipoSolicitud" class="required text-[10px]">TIPO DE SOLICITUD</label>
                                <select id="tipoSolicitud" name="tipoSolicitud" class="input-premium w-full text-sm py-2" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Valoración medica telemedicina">Valoración medica telemedicina</option>
                                    <option value="Valoración medica presencial">Valoración medica presencial</option>
                                    <option value="Concepto de rehabilitación">Concepto de rehabilitación</option>
                                    <option value="Recomendaciones laborales">Recomendaciones laborales</option>
                                    <option value="Calificación de origen">Calificación de origen</option>
                                    <option value="Calificación de PCLO">Calificación de PCLO</option>
                                    <option value="Auditoria de seguimiento PRI">Auditoria de seguimiento PRI</option>
                                    <option value="Solicitudes de autorizacion de incapacidades y licencias - Liquidacion">Solicitudes de autorizacion de incapacidades y licencias - Liquidacion</option>
                                    <option value="Auditoria De Incapacidades Diferentes A Mayores De 540 Dias">Auditoria De Incapacidades Diferentes A Mayores De 540 Dias</option>
                                    <option value="Auditoria De Incapacidades">Auditoria De Incapacidades</option>
                                    <option value="Auditoria De Incapacidades - Lm/Lp">Auditoria De Incapacidades - Lm/Lp</option>
                                </select>
                            </div>
                            <div>
                                <label for="nombreRadicador" class="required text-[10px]">NOMBRE DEL RADICADOR</label>
                                <input type="text" id="nombreRadicador" name="nombreRadicador" class="input-premium w-full text-sm py-2" placeholder="Nombre completo" required>
                            </div>
                            <div>
                                <label for="fechaSolicitud" class="text-[10px]">FECHA DE RADICACIÓN</label>
                                <input type="date" id="fechaSolicitud" name="fechaSolicitud" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" class="input-premium w-full text-sm py-2">
                            </div>
                        </div>
                    </div>

                    <!-- Sección 2: Información del Paciente -->
                    <div class="section-card glass-panel !p-4">
                        <div class="section-title-premium mb-2">
                            <div class="bg-blue-100 p-1.5 rounded-lg text-blue-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-tight">Información del Paciente</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-3">
                            <div class="md:col-span-1">
                                <label for="tipoDoc" class="required text-[10px]">TIPO DOC</label>
                                <select id="tipoDoc" name="tipoDoc" class="input-premium w-full text-sm py-2" required>
                                    <option value="CC">CC</option>
                                    <option value="CE">CE</option>
                                    <option value="TI">TI</option>
                                </select>
                            </div>
                            <div class="md:col-span-1">
                                <label for="cedula" class="required text-[10px]">DOCUMENTO</label>
                                <input type="text" id="cedula" name="cedula" class="input-premium w-full text-sm py-2" placeholder="Número" required>
                            </div>
                            <div class="md:col-span-2">
                                <label for="nombres" class="required text-[10px]">NOMBRES</label>
                                <input type="text" id="nombres" name="nombres" class="input-premium w-full text-sm py-2" placeholder="Nombres" required>
                            </div>
                            <div class="md:col-span-2">
                                <label for="apellidos" class="required text-[10px]">APELLIDOS</label>
                                <input type="text" id="apellidos" name="apellidos" class="input-premium w-full text-sm py-2" placeholder="Apellidos" required>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 3: Seguridad Social -->
                    <div class="section-card glass-panel !p-4">
                        <div class="section-title-premium mb-2">
                            <div class="bg-cyan-100 p-1.5 rounded-lg text-cyan-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-tight">Seguridad Social</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
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
                            <div>
                                <label for="tipoAfiliado" class="required text-[10px]">AFILIADO</label>
                                <select id="tipoAfiliado" name="tipoAfiliado" class="input-premium w-full text-sm py-2" required>
                                    <option value="cotizante">Cotizante</option>
                                    <option value="beneficiario">Beneficiario</option>
                                </select>
                            </div>
                            <div>
                                <label for="email" class="required text-[10px]">EMAIL PACIENTE</label>
                                <input type="email" id="email" name="email" class="input-premium w-full text-sm py-2" placeholder="correo@paciente.com" required>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 4: Documentación -->
                    <div class="section-card glass-panel !p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="section-title-premium !mb-0">
                                <div class="bg-indigo-100 p-1.5 rounded-lg text-indigo-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                </div>
                                <span class="text-xs font-bold uppercase tracking-tight">Documentación Adjunta</span>
                            </div>
                            
                            <div class="flex gap-1.5 p-1 bg-slate-100/50 rounded-xl">
                                <button type="button" onclick="switchTab('individual')" id="tab-individual" class="tab-btn active px-4 py-1 rounded-lg text-[10px] font-bold transition-all">INDIVIDUAL</button>
                                <button type="button" onclick="switchTab('masiva')" id="tab-masiva" class="tab-btn px-4 py-1 rounded-lg text-[10px] font-bold text-slate-500 transition-all">CARGA MASIVA</button>
                            </div>
                        </div>
                        
                        <!-- Pestaña Individual -->
                        <div id="content-individual" class="tab-content">
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                                <div class="upload-card-interactive !p-4" onclick="document.getElementById('doc_historia_clinica').click()">
                                    <div class="file-icon !w-10 !h-10 mb-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                                    <h5 class="text-[10px] font-bold text-slate-700 uppercase">Historia Clínica</h5>
                                    <input type="file" id="doc_historia_clinica" name="doc_historia_clinica[]" class="hidden doc-input" multiple>
                                </div>
                                <div class="upload-card-interactive !p-4" onclick="document.getElementById('doc_incapacidades').click()">
                                    <div class="file-icon !w-10 !h-10 mb-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></div>
                                    <h5 class="text-[10px] font-bold text-slate-700 uppercase">Incapacidades</h5>
                                    <input type="file" id="doc_incapacidades" name="doc_incapacidades[]" class="hidden doc-input" multiple>
                                </div>
                                <div class="upload-card-interactive !p-4" onclick="document.getElementById('doc_reclamacion').click()">
                                    <div class="file-icon !w-10 !h-10 mb-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                                    <h5 class="text-[10px] font-bold text-slate-700 uppercase">Reclamación</h5>
                                    <input type="file" id="doc_reclamacion" name="doc_reclamacion[]" class="hidden doc-input" multiple>
                                </div>
                                <div class="upload-card-interactive !p-4" onclick="document.getElementById('doc_examenes').click()">
                                    <div class="file-icon !w-10 !h-10 mb-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg></div>
                                    <h5 class="text-[10px] font-bold text-slate-700 uppercase">Exámenes</h5>
                                    <input type="file" id="doc_examenes" name="doc_examenes[]" class="hidden doc-input" multiple>
                                </div>
                                <div class="upload-card-interactive !p-4" onclick="document.getElementById('doc_anexos').click()">
                                    <div class="file-icon !w-10 !h-10 mb-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.414a4 4 0 00-5.656-5.656l-6.415 6.415a6 6 0 108.486 8.486L20.5 13"></path></svg></div>
                                    <h5 class="text-[10px] font-bold text-slate-700 uppercase">Anexos</h5>
                                    <input type="file" id="doc_anexos" name="doc_anexos[]" class="hidden doc-input" multiple>
                                </div>
                            </div>
                        </div>

                        <!-- Pestaña Masiva -->
                        <div id="content-masiva" class="tab-content hidden">
                            <div class="flex items-center gap-8">
                                <div class="flex-grow upload-card-interactive !py-6 !px-8 flex items-center gap-6" onclick="document.getElementById('excel_upload').click()">
                                    <div class="file-icon !w-14 !h-14"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                                    <div class="text-left">
                                        <h5 class="text-sm font-bold text-indigo-800 uppercase">Carga Masiva Excel</h5>
                                        <p class="text-xs text-indigo-400">Seleccione el archivo .xlsx</p>
                                    </div>
                                    <input type="file" id="excel_upload" name="excel_upload" class="hidden" accept=".xlsx, .xls">
                                </div>
                                <button type="button" onclick="generateExcelTemplate()" class="flex items-center gap-3 text-xs font-bold text-indigo-600 bg-white border-2 border-indigo-100 px-6 py-4 rounded-2xl hover:bg-indigo-50 transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    DESCARGAR PLANTILLA
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Acciones (25%) -->
                <div class="w-full lg:w-1/4">
                    <div class="section-card glass-panel !bg-indigo-600/5 sticky top-16 !p-4">
                        <div class="section-title-premium mb-4">
                            <div class="bg-indigo-600 p-1.5 rounded-lg text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm font-bold uppercase tracking-tight">Finalizar</span>
                        </div>
                        
                        <label class="mb-4 p-3 bg-white/70 rounded-xl border border-indigo-100 hover:border-indigo-300 transition-all cursor-pointer group flex items-center gap-3 select-none">
                            <div class="relative flex-shrink-0">
                                <input type="checkbox" id="confirmCheck" class="sr-only" onchange="validateForm()">
                                <div class="w-6 h-6 border-2 border-slate-300 rounded-lg bg-white flex items-center justify-center transition-all group-hover:border-indigo-400" id="customCheckVisual">
                                    <svg class="w-3.5 h-3.5 text-white scale-0 transition-transform duration-200" id="checkIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-600 leading-tight">He verificado que la información y los documentos son correctos.</span>
                        </label>

                        <button type="submit" id="submitBtn" class="btn-premium w-full justify-center py-4 opacity-50 cursor-not-allowed pointer-events-none" disabled>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm font-bold">RADICAR</span>
                        </button>
                        
                        <div class="mt-4 pt-4 border-t border-indigo-100/50">
                            <div class="flex items-center justify-between text-[9px] text-slate-400 font-bold uppercase tracking-widest mb-2">
                                <span>Seguridad</span>
                                <div class="flex gap-1">
                                    <div class="w-1 h-1 rounded-full bg-emerald-500"></div>
                                    <div class="w-1 h-1 rounded-full bg-emerald-500"></div>
                                </div>
                            </div>
                            <p class="text-[9px] text-slate-400 leading-snug">
                                Proceso protegido con AES-256 y Ley de Habeas Data.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <!-- Footer Centrado Horizontal -->
    <footer class="mt-auto py-3 border-t border-slate-200/60 bg-white/80 backdrop-blur-md">
        <div class="max-w-[1900px] mx-auto px-6 flex items-center justify-center gap-6">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none">© 2026. Todos los derechos reservados</p>
            <div class="h-4 w-[1px] bg-slate-300/60"></div>
            <img src="Logo-Ren.png" alt="Logo Ren" class="h-5 opacity-80">
        </div>
    </footer>

    <!-- Lógica de Frontend Premium -->
    <script src="assets/js/radicador.js"></script>
</body>
</html>
