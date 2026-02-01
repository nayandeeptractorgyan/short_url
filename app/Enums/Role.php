<?php

namespace App\Enums;

enum Role: string
{
    case SuperAdmin = 'super_admin';
    case Admin      = 'admin';
    case Member     = 'member';
    case Sales      = 'sales';
    case Manager    = 'manager';

    public function label(): string
    {
        return match($this) {
            self::SuperAdmin => 'Super Admin',
            self::Admin      => 'Admin',
            self::Member     => 'Member',
            self::Sales      => 'Sales',
            self::Manager    => 'Manager',
        };
    }

    // SuperAdmin can invite Admin to a new company
    // Admin can invite Admin or Member to their own company
    public function canInvite(): bool
    {
        return match($this) {
            self::SuperAdmin, self::Admin => true,
            default                       => false,
        };
    }

    // Admin and Member CAN create short URLs
    // SuperAdmin CANNOT create short URLs
    // Sales and Manager are not restricted either
    public function canCreateUrl(): bool
    {
        return $this !== self::SuperAdmin;
    }
}
