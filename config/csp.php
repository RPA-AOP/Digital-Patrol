<?php

use App\Policies\DigipatrolPolicy;

return [

    'presets' => [
        DigipatrolPolicy::class,
    ],

    'directives' => [],

    /*
     * This policy which will be put in report only mode. This is great for testing out
     * a new policy or changes to existing csp policy without breaking anything.
     */
    'report_only_presets' => [],

    'report_only_directives' => [],

    /*
     * All violations against the policy will be reported to this url.
     * A great service you could use for this is https://report-uri.com/
     *
     * You can override this setting by calling `reportTo` on your policy.
     */
    'report_uri' => env('CSP_REPORT_URI', ''),

    'report_only_uri' => env('CSP_REPORT_ONLY_URI', ''),

    'report_to' => env('CSP_REPORT_TO', ''),

    'report_only_to' => env('CSP_REPORT_ONLY_TO', ''),

    'reporting_endpoints' => [],

    /*
     * Headers will only be added if this setting is set to true.
     */
    'enabled' => env('CSP_ENABLED', false),

    'enabled_while_hot_reloading' => env('CSP_ENABLED_WHILE_HOT_RELOADING', false),

    /*
     * The class responsible for generating the nonces used in inline tags and headers.
     */
    'nonce_generator' => Spatie\Csp\Nonce\RandomString::class,

    'nonce_enabled' => env('CSP_NONCE_ENABLED', true),
];
