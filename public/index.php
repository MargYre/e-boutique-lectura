<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    // Ajoutez ces lignes pour gérer le sous-dossier
    $trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? $_ENV['TRUSTED_PROXIES'] ?? false;
    if ($trustedProxies) {
        Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_ALL ^ Request::HEADER_X_FORWARDED_HOST);
    }

    $trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? $_ENV['TRUSTED_HOSTS'] ?? false;
    if ($trustedHosts) {
        Request::setTrustedHosts([$trustedHosts]);
    }

    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};