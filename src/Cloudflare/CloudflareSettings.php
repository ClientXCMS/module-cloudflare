<?php
namespace App\Cloudflare;

use App\Admin\Settings\SettingsInterface;
use ClientX\Renderer\RendererInterface;
use ClientX\Validator;

class CloudflareSettings implements SettingsInterface {

    public function icon(): string
    {
        return "fab fa-cloudflare";
    }

    public function name(): string
    {
        return "cloudflare";
    }

    public function title(): string
    {
        return "CloudFlare";
    }

    public function validate(array $params): Validator
    {
        return new Validator($params);
    }

    public function render(RendererInterface $renderer)
    {
        return $renderer->render('@cloudflare/settings');
    }
}