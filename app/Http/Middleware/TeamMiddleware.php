<?php

namespace App\Http\Middleware;

use App\Models\ERP\MenuRoute;
use App\Models\ERP\TeamPermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MongoDB\BSON\ObjectId;
use Route;

class TeamMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('team')) {
            $team_id = session()->get('team')->id;

            // Fetch team permissions
            $teamPermissionData = TeamPermission::where('teamId', new ObjectId($team_id))->first();

            if (empty($teamPermissionData)) {
                return redirect()->route('page403');
            }
           
            // Fetch allowed routes
            $allowedRoutes = MenuRoute::where('name', 'Common')
                ->orWhereIn('_id', array_map(fn($id) => new ObjectId($id), $teamPermissionData->childId))
                ->pluck('routeName')
                ->toArray();
                
            $currentRouteName = Route::currentRouteName();
            // $currentRouteName1 =  str_replace("team.", "", $currentRouteName);
            $currentRouteName1 =  substr($currentRouteName, 5);
        //    dd($currentRouteName1);
            // Check if the current route is allowed
          
            if (!in_array($currentRouteName1, $allowedRoutes)) {
               
                return redirect()->route('page403');
            }
        
            return $next($request);
        } 

        if (Auth::guard('team')->check()) {
           
            return $next($request);

        }
        if ($request->ajax() || $request->wantsJson()) {
            return response('Unauthorized.', 401);
        } else {
            return redirect('/login');
        }
    }
}
