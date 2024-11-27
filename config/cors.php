<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],  // Permite todos los métodos, incluyendo OPTIONS
    'allowed_origins' => ['*'],  // Cambia por el dominio adecuado para producción, por ejemplo: ['https://anuc.hourclient.com']
    'allowed_headers' => ['*'],  // Permite todos los encabezados
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
