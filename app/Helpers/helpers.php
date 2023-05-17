<?php function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
function isRouteActive($prefixName)
{
    $currentRoute = Route::current();
    $routePrefix = $currentRoute->getPrefix();
    
    if ($routePrefix && $routePrefix == $prefixName) {
        return 'active';
    }

    return '';
}
function isRouteNameActive($routeName)
{
    return Route::currentRouteName() == $routeName ? 'active' : '';
}
if (! function_exists('getuserRole')) {
    function getuserRole($user = null)
    {
        if ($user) {
            return optional($user->roles->pluck('name')[0]);
        }
        return optional(auth()->user()->roles->pluck('name')[0]);
    }
}
    ?>