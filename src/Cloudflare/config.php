<?php

use App\Cloudflare\CloudflareSettings;

use function ClientX\setting;
use function DI\add;
use function DI\get;

return [
    'admin.settings' => add(get(CloudflareSettings::class)),
    'cloudflare' => [
        'enabled' => setting('cloudflare_enabled', "false"),
        'forwardedfor' => setting('cloudflare_forwardedfor', 'X-Forwarded-For')
    ]
];