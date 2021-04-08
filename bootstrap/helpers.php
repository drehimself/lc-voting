<?php

function roleName($role)
{
    return [
        'name'  => $role == 0 ? 'Admin' : 'User',
        'class' => $role == 0 ? 'success' : 'warning',
    ];
}

function isSelected($value,$match)
{
    return isset(request()->{$value}) && request()->{$value} == $match ? 'selected' : '';    
}

function formatBytes($bytes, $force_unit = NULL, $format = NULL, $si = TRUE)
{
    // Format string
    $format = ($format === NULL) ? '%01.2f %s' : (string) $format;

    // IEC prefixes (binary)
    if ($si == FALSE OR strpos($force_unit, 'i') !== FALSE)
    {
        $units = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
        $mod   = 1024;
    }
    // SI prefixes (decimal)
    else
    {
        $units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB');
        $mod   = 1000;
    }

    // Determine unit to use
    if (($power = array_search((string) $force_unit, $units)) === FALSE)
    {
        $power = ($bytes > 0) ? floor(log($bytes, $mod)) : 0;
    }

    return sprintf($format, $bytes / pow($mod, $power), $units[$power]);
}
// BIZ Helpers
function moneyFormat($num)
{
    return number_format($num);
}

function setTheQueryStringForViewToggle ()
{
    if (request()->view == '') {
        return 'kanban';
    }

    $state = request()->view == 'kanban' ? 'list' : 'kanban';

    return $state;
}

function status($num)
{
    switch ($num) {
        case '1':
            return 'high';
            break;
        case '2':
            return 'medium';
            break;
        case '3':
            return 'low';
            break;
        
        default:
            return 'Not Found';
            break;
    }
}
