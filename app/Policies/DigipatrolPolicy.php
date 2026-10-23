<?php

namespace App\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class DigipatrolPolicy implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy
            ->add(Directive::BASE, Keyword::SELF)
            ->add(Directive::CONNECT, Keyword::SELF)
            ->add(Directive::DEFAULT, Keyword::SELF)
            ->add(Directive::FORM_ACTION, Keyword::SELF)
            ->add(Directive::IMG, Keyword::SELF)
            ->add(Directive::MEDIA, Keyword::SELF)
            ->add(Directive::OBJECT, Keyword::NONE)
            ->add(Directive::SCRIPT, [Keyword::SELF, 'https://fonts.gstatic.com', 'https://cdnjs.cloudflare.com', 'https://unpkg.com'])
            ->add(Directive::SCRIPT_ATTR, [Keyword::SELF, Keyword::UNSAFE_HASHES])
            ->add(Directive::STYLE, [Keyword::SELF, Keyword::UNSAFE_INLINE, 'http://fonts.googleapis.com', 'https://unpkg.com'])
            ->add(Directive::FONT, [Keyword::SELF, 'data:', 'https://fonts.gstatic.com', 'https://cdnjs.cloudflare.com', 'https://unpkg.com'])
            ->add(Directive::IMG, [Keyword::SELF, 'data:', 'https://unpkg.com/', 'https://*.tile.osm.org', 'https://api.mapbox.com'])
            ->add(Directive::FRAME, Keyword::SELF)
            ->add(Directive::FRAME_ANCESTORS, Keyword::SELF)
            ->addNonce(Directive::SCRIPT);
    }
}
