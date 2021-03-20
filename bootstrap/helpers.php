<?php

function roleName($role)
{
    return [
        'name'  => $role == 0 ? 'Admin' : 'User',
        'class' => $role == 0 ? 'success' : 'warning',
    ];
}
