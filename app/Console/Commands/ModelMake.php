<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand;

class ModelMake extends ModelMakeCommand
{

    public function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\\Persistence\\Models';
    }

}
