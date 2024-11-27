<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],  // Asegúrate de que tus rutas de API estén cubiertas
    'allowed_methods' => ['*'],  // Permite todos los métodos, incluyendo OPTIONS
    'allowed_origins' => ['*'],  // Cambia por el dominio adecuado para producción, por ejemplo: ['https://anuc.hourclient.com']
    'allowed_headers' => ['*'],  // Permite todos los encabezados
    'exposed_headers' => [],  // Aquí puedes agregar cabeceras que quieras exponer
    'max_age' => 0,  // Esto es el tiempo en segundos que el navegador almacenará la respuesta CORS
    'supports_credentials' => false,  // Establece si se permiten las credenciales (cookies, headers de autenticación)
];
