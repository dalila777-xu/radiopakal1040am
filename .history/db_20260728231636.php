<?php
// Configuración de la API de Supabase para Radio Pakal
define('SUPABASE_URL', 'https://cwfydsatojsahuojvt.supabase.co');
define('SUPABASE_KEY', 'sb_publishable_y-xMjQxSFvPaMusgSkT8Gg_9iFBM...'); // Asegúrate de pegar tu llave completa si es necesario

/**
 * Función para hacer peticiones mediante la API URL (REST) de Supabase
 * 
 * @param string $endpoint El nombre de la tabla (ej: 'publicaciones', 'programacion', 'carrusel')
 * @param string $method Método HTTP ('GET', 'POST', 'PATCH', 'DELETE')
 * @param array|null $data Datos a enviar (para insertar o actualizar)
 * @param string|null $queryParams Filtros de búsqueda opcionales (ej: 'id=eq.1')
 * @return mixed Respuesta decodificada de la API en formato array asociativo
 */
function supabaseRequest($endpoint, $method = 'GET', $data = null, $queryParams = null) {
    $url = SUPABASE_URL . '/rest/v1/' . $endpoint;
    
    if ($queryParams) {
        $url .= '?' . $queryParams;
    }

    $ch = curl_init($url);

    $headers = [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Content-Type: application/json',
        'Prefer: return=representation'
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    if ($data && ($method == 'POST' || $method == 'PATCH' || $method == 'PUT')) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        die("Error en la petición cURL a Supabase: " . $error);
    }
    
    curl_close($ch);

    return json_decode($response, true);
}
?>