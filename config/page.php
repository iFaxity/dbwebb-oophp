<?php
/**
 * Configuration file for page which can create and put together web pages
 * from a collection of views. Through configuration you can add the
 * standard parts of the page, such as header, navbar, footer, stylesheets,
 * javascripts and more.
 */

return [
    "layout" => [
        "region" => "layout",
        // Change here to use your own templatefile as layout
        "template" => "custom/layout/default",
        "data" => [
            "baseTitle" => " | oophp",
            "bodyClass" => null,
            "favicon" => "favicon.ico",
            "htmlClass" => null,
            "lang" => "sv",
            "stylesheets" => [
                "css/theme.min.css",
            ],
            "javascripts" => [
                //"js/responsive-menu.js",
                "js/main.js",
            ],
        ],
    ],

    // These views are always loaded into the collection of views.
    "views" => [
        [
            "region" => "header-logo",
            "template" => "custom/header/logo",
            "data" => [
                "homeLink" => "",
                "logoText" => "oophp",
                "logo"     => "image/theme/leaf_40x40.png",
                "logoAlt"  => "Löv-bild",
            ],
        ],
        [
            "region" => "header",
            "template" => "custom/navbar/navbar",
            "data" => [
                "navbarConfig" => require __DIR__ . "/navbar/header.php",
            ],
        ],
        [
            "region" => "header-mobile",
            "template" => "custom/navbar/responsive",
            "data" => [
                "navbarConfig" => require __DIR__ . "/navbar/header.php",
            ],
        ],
        [
            "region" => "footer",
            "template" => "custom/columns/default",
            "data" => [
                "class"  => "footer-column",
                "columns" => [
                    [
                        "template" => "anax/v2/block/default",
                        "contentRoute" => "block/footer-col-1",
                    ],
                    [
                        "template" => "anax/v2/block/default",
                        "contentRoute" => "block/footer-col-2",
                    ],
                    [
                        "template" => "anax/v2/block/default",
                        "contentRoute" => "block/footer-col-3",
                    ]
                ]
            ],
            "sort" => 1
        ],
        [
            "region" => "footer",
            "template" => "anax/v2/block/default",
            "data" => [
                "class"  => "site-footer",
                "contentRoute" => "block/footer",
            ],
            "sort" => 2
        ],
    ],
];
