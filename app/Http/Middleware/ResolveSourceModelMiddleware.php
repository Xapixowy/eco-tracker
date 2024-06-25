<?php

namespace App\Http\Middleware;

use App\Exceptions\ResourceNotFoundException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;


class ResolveSourceModelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $sourceId = $request->route('sourceId');

        $sourceType = Str::contains($request->route()->getName(), 'vehicles') ? 'vehicles' : 'homes';
        $source = $sourceType === 'vehicles' ? $user->vehicles()->find($sourceId) : $user->homes()->find($sourceId);

        if (!$source) {
            throw new ResourceNotFoundException();
        }

        $request->merge(['source' => $source, 'sourceType' => $sourceType]);

        return $next($request);
    }
}
