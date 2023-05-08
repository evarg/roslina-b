<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Mnabialek\LaravelAuthorize\Contracts\Roleable;

class AuthTest
{
    protected $auth;
    protected $config;
    protected $router;
    protected $gate;

    public function __construct(
        Guard $auth,
        Config $config,
        Router $router,
        Gate $gate
    ) {
        $this->auth = $auth;
        $this->config = $config;
        $this->router = $router;
        $this->gate = $gate;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        foreach ($request->header() as $header => $value) {
            echo $header . ': ' . implode(', ', $value) . "\n";
        }
        var_dump(array_values($this->router->getCurrentRoute()->parameters()));
        return $next($request);
    }
}
