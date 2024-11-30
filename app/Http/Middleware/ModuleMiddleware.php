<?php

namespace App\Http\Middleware;

use App\Models\Module;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $module = $request->segment(2); // Get the first segment of the URL (module name)
        $moduleData = Module::where('name', ucfirst($module))->first();

        if (!$moduleData || !$moduleData->enabled) {
            abort(403, 'Module not enabled.');
        }

        return $next($request);
    }
}
