<?php
namespace App\Cloudflare;

use ClientX\Module;
use ClientX\Renderer\RendererInterface;

class CloudflareModule extends Module {

    const DEFINITIONS = __DIR__ . '/config.php';

    public function __construct(RendererInterface $renderer)
    {
        $renderer->addPath('cloudflare', __DIR__ . '/views');
    }
}