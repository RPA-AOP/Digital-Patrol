<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;

class DigipatrolPolicy extends Basic

{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->addDirective(Directive::FONT, 'https://fonts.gstatic.com https://cdnjs.cloudflare.com');
    }
}
