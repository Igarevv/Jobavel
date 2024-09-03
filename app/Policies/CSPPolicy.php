<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Http\Request;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Basic;
use Spatie\Csp\Scheme;
use Spatie\Csp\Value;
use Symfony\Component\HttpFoundation\Response;

class CSPPolicy extends Basic
{
    public function configure(): void
    {
        parent::configure();

        $this->addDirective(Directive::DEFAULT, Keyword::SELF)
            ->addDirective(Directive::SCRIPT, [
                Keyword::SELF,
            ])
            ->addDirective(Directive::STYLE, [
                Keyword::SELF,
                'https://unpkg.com/bs-brain@2.0.4/'
            ])
            ->addDirective(Directive::IMG, [
                Keyword::SELF,
                'https://jobavel.s3.amazonaws.com/',
                'http://www.w3.org/',
                Scheme::DATA,
            ])
            ->addDirective(Directive::FONT, [
                Keyword::SELF,
                'https://fonts.gstatic.com/'
            ])
            ->addDirective(Directive::FRAME, Keyword::SELF)
            ->addNonceForDirective(Directive::SCRIPT)
            ->addNonceForDirective(Directive::STYLE);
            //->addDirective(Directive::UPGRADE_INSECURE_REQUESTS, Value::NO_VALUE); --> only for ssl enable
    }

    public function shouldBeApplied(Request $request, Response $response): bool
    {
        if (app()->hasDebugModeEnabled() || app()->isProduction()) {
            return false;
        }
        return parent::shouldBeApplied($request, $response);
    }
}
