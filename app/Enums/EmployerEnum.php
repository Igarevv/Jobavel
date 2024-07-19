<?php

namespace App\Enums;

enum EmployerEnum: string
{
    case COMPANY_TYPE_PRODUCT = 'product';

    case COMPANY_TYPE_AGENCY = 'agency';

    case COMPANY_TYPE_OUTSOURCE = 'outsource';

    case COMPANY_TYPE_OUTSTAFF = 'outstaff';
}
