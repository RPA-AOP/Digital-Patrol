<?php

namespace App\Http\Middleware;

use App\Helpers\Permission;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Request as RequestAlias;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        activity('page_access')
            ->event('access')
            ->withProperties($request->header())
            ->log($request->url());

        $except = ['logout', 'login', 'profile'];
        $requestUrl = \Illuminate\Support\Facades\Request::segment(1);
        if (in_array($requestUrl, $except)) {
            return $next($request);
        }
        $permision = Permission::get();
        switch ($request->method()) {
            case RequestAlias::METHOD_GET:
                if ($permision->has_view)
                    return $next($request);
                break;
            case RequestAlias::METHOD_POST:
                if ($permision->has_edit || $permision->has_create)
                    return $next($request);
                break;
            case RequestAlias::METHOD_DELETE:
                if ($permision->has_delete)
                    return $next($request);
                break;
            default:
                activity('page_access_denied')
                    ->event('access_denied')
                    ->withProperties($request->header())
                    ->log($request->url());
                abort(403);
        }
    }
}
