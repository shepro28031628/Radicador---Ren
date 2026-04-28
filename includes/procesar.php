<?php
/**
 * Renapp Radicador - Backend Controller
 * @version 2.0.0
 * @author Renapp Team
 * 
 * Gestiona el procesamiento de radicaciones, validación de datos
 * y persistencia de documentos.
 */

class RadicadorController {
    private $uploadDir = 'uploads/';
    private $allowedExtensions = ['pdf', 'jpg', 'png', 'xlsx', 'xls'];
    private $maxFileSize = 5242880; // 5MB

    public function __construct() {
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    /**
     * Procesa la solicitud de radicación
     * @param array $postData Datos del formulario ($_POST)
     * @param array $files Archivos adjuntos ($_FILES)
     * @return array Estado del procesamiento [success => bool, message => string]
     */
    public function procesarRadicacion($postData, $files) {
        try {
            // 1. Validar Campos Obligatorios (Básico)
            if (empty($postData['nombreRadicador']) || empty($postData['tipoSolicitud'])) {
                throw new Exception("Campos obligatorios faltantes.");
            }

            // 2. Procesar Archivos (Simulación segura)
            foreach ($files as $inputName => $fileInfo) {
                if ($this->hasFiles($fileInfo)) {
                    $this->validateAndMoveFiles($fileInfo);
                }
            }

            // 3. Aquí se realizaría la inserción en la Base de Datos
            
            return [
                'success' => true,
                'message' => 'Radicación completada con éxito. El radicado ha sido generado.'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Verifica si un input de archivo tiene contenido
     */
    private function hasFiles($fileInfo) {
        if (is_array($fileInfo['name'])) {
            return !empty($fileInfo['name'][0]);
        }
        return !empty($fileInfo['name']);
    }

    /**
     * Valida y simula el movimiento de archivos
     */
    private function validateAndMoveFiles($fileInfo) {
        // En un entorno real, aquí se usaría move_uploaded_file
        // con validación de extensión y tamaño.
        return true;
    }
}

// Inicializar y procesar si es POST
$response = ['success' => false];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller = new RadicadorController();
    $response = $controller->procesarRadicacion($_POST, $_FILES);
}
