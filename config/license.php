<?php

return [
    'server_url'   => env('LICENSE_SERVER_URL'),
    'device_id'    => env('LICENSE_DEVICE_ID', php_uname('n')),
    'product_code' => env('LICENSE_PRODUCT_CODE', 'APP1'),
    'local_path'   => storage_path('app/license.json'), // tempat simpan lisensi lokal
];
