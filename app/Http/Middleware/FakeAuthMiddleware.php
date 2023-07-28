<?php

namespace App\Http\Middleware;

use App\Models\Hotelier;
use Closure;

class FakeAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $hotelierId = $request->route('hotelierId');
        $hotelier = Hotelier::find($hotelierId);
        if (!$hotelier) {
            abort(401, 'Unauthorized Access');
        }

        return $next($request);
    }
}
