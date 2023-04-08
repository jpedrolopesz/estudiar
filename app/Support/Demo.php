<?php

namespace App\Support;

class Demo
{
    const DEMO_PROTECTED_ROUTES = [
        ['name' => 'profile.password', 'method' => 'PUT'],
        ['name' => 'profile.update', 'method' => 'PUT'],
        ['name' => 'admin.invitations.resend', 'method' => 'PUT'],
        ['name' => 'admin.settings', 'method' => 'PUT'],
        ['name' => 'admin.users.admin', 'method' => 'GET'],
        ['name' => 'admin.users.status', 'method' => 'GET'],
        ['name' => 'admin.invitations.invite', 'method' => 'POST'],
        ['name' => 'password.email', 'method' => 'POST'],
        ['name' => 'install.database', 'method' => 'POST'],
        ['name' => 'install.mail', 'method' => 'POST'],
        ['name' => 'projects.store', 'method' => 'POST'],
        ['name' => 'projects.update', 'method' => 'PUT'],
        ['name' => 'projects.archive', 'method' => 'PUT'],
        ['name' => 'codes.store', 'method' => 'POST'],
        ['name' => 'codes.update', 'method' => 'PUT'],
        ['name' => 'codes.destroy', 'method' => 'DELETE'],
        ['name' => 'projects.role', 'method' => 'PUT'],
        ['name' => 'projects.members', 'method' => 'PUT'],
        ['name' => 'register', 'method' => 'POST'],
        ['name' => 'password.update', 'method' => 'POST']
    ];
}