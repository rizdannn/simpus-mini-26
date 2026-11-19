<?php
// Kredensial dibaca dari environment variable (getenv).
// Nilai setelah tanda ?: hanya default untuk database LOKAL.
// Di hosting, isi lewat environment variable, jangan ditulis di kode.
return [
    'db_host'    => getenv('DB_HOST') ?: 'localhost',
    'db_port'    => getenv('DB_PORT') ?: '5433',
    'db_name'    => getenv('DB_NAME') ?: 'simpus_mini',
    'db_user'    => getenv('DB_USER') ?: 'postgres',
    'db_pass'    => getenv('DB_PASS') ?: 'postgres',
    'db_sslmode' => getenv('DB_SSLMODE') ?: 'prefer',
];