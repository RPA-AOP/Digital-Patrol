<?php

namespace App\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Policy;

class DigipatrolPolicy extends Policy

{

    public function configure(): void
    {
        $this
            ->addDirective(Directive::BASE, Keyword::SELF)
            ->addDirective(Directive::CONNECT, Keyword::SELF)
            ->addDirective(Directive::DEFAULT, Keyword::SELF)
            ->addDirective(Directive::FORM_ACTION, Keyword::SELF)
            ->addDirective(Directive::IMG, Keyword::SELF)
            ->addDirective(Directive::MEDIA, Keyword::SELF)
            ->addDirective(Directive::OBJECT, Keyword::NONE)
            ->addDirective(Directive::SCRIPT, 'self  https://fonts.gstatic.com https://cdnjs.cloudflare.com https://cdnjs.cloudflare.com')
            ->addDirective(Directive::STYLE, [Keyword::SELF, 'unsafe-inline', 'http://fonts.googleapis.com'])
            ->addDirective(Directive::FONT, 'self data: https://fonts.gstatic.com https://cdnjs.cloudflare.com https://cdnjs.cloudflare.com')
            ->addDirective(Directive::IMG, 'self data:')
            ->addDirective(Directive::FRAME, Keyword::SELF)
            ->addDirective(Directive::FRAME_ANCESTORS, Keyword::SELF)
            ->addNonceForDirective(Directive::SCRIPT);
    }
}
