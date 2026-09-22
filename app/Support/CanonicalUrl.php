<?php

namespace App\Support;

use Illuminate\Http\Request;

final class CanonicalUrl
{
    public const ORIGIN = 'https://mc-cg.com';

    public function current(Request $request): string
    {
        return $this->forPath($request->getPathInfo());
    }

    public function route(string $name, mixed $parameters = []): string
    {
        return $this->forPath(route($name, $parameters, false));
    }

    public function forPath(string $path): string
    {
        $path = parse_url($path, PHP_URL_PATH) ?: '/';
        $path = preg_replace('#^/index\.php(?:/|$)#', '/', $path) ?: '/';
        $path = '/'.ltrim($path, '/');

        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        return self::ORIGIN.$path;
    }
}
