<?php

namespace App\Enums;

enum RoleType: string {
    case SUPERADMIN = 'superadmin';
    case ADMIN      = 'admin';
    case SUBADMIN   = 'subadmin';
    case LOGIST     = 'logist';
    case OPERATOR   = 'operator';
    case AGENT      = 'agent';
    case PERFORMER  = 'performer';
}