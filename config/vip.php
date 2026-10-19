<?php

return [
    'company_name' => env('COMPANY_NAME', 'شركة البديل للخدمات العامة واللوجستية VIP'),
    'company_phone' => env('COMPANY_PHONE', '+970000000000'),
    'logo_path' => public_path('images/logo.png'),

    'card_types' => [
        'silver' => [
            'name' => 'VIP Silver',
            'name_ar' => 'فضية VIP',
            'price' => 500,
            'color' => '#C0C0C0',
            'benefits' => [
                'ونش مجاني حتى 250 شيقل',
                'سيارة بديلة لمدة 4 أيام',
                'زجاج ومرايا بدون رسوم مشاركة',
            ],
        ],
        'gold' => [
            'name' => 'VIP Gold',
            'name_ar' => 'ذهبية VIP',
            'price' => 1000,
            'color' => '#D4AF37',
            'benefits' => [
                'ونش مجاني حتى 250 شيقل',
                'سيارة بديلة لمدة 7 أيام',
                'زجاج ومرايا بدون رسوم مشاركة',
                'رسوم حادث صفر',
            ],
        ],
    ],

    'card_validity_days' => 365,
    'membership_prefix' => 'VIP',
];
