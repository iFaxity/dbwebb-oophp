<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "menu",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Redovisning",
            "url" => "redovisning",
            "title" => "Redovisningstexter från kursmomenten.",
            "submenu" => [
                [
                    "text" => "Kmom01",
                    "url" => "redovisning/kmom01",
                    "title" => "Redovisning för kmom01.",
                ],
                [
                    "text" => "Kmom02",
                    "url" => "redovisning/kmom02",
                    "title" => "Redovisning för kmom02.",
                ],
                [
                    "text" => "Kmom03",
                    "url" => "redovisning/kmom03",
                    "title" => "Redovisning för kmom03.",
                ],
                [
                    "text" => "Kmom04",
                    "url" => "redovisning/kmom04",
                    "title" => "Redovisning för kmom04.",
                ],
                [
                    "text" => "Kmom05",
                    "url" => "redovisning/kmom05",
                    "title" => "Redovisning för kmom05.",
                ],
                [
                    "text" => "Kmom06",
                    "url" => "redovisning/kmom06",
                    "title" => "Redovisning för kmom06.",
                ],
                [
                    "text" => "Kmom10",
                    "url" => "redovisning/kmom10",
                    "title" => "Redovisning för kmom10.",
                ],
            ],
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        [
            "text" => "Styleväljare",
            "url" => "style",
            "title" => "Välj stylesheet.",
        ],
        [
            "text" => "Docs",
            "url" => "dokumentation",
            "title" => "Dokumentation av ramverk och liknande.",
        ],
        [
            "text" => "Spel",
            "url" => "spel",
            "title" => "Spela spel som jag gjort.",
            "submenu" => [
                [
                    "text" => "Guess",
                    "url" => "guess",
                    "title" => "Ett gissa numret spel",
                ],
                [
                    "text" => "100",
                    "url" => "dice100",
                    "title" => "Tärningsspelet 100",
                ],
                [
                    "text" => "100 v2",
                    "url" => "d100",
                    "title" => "Tärningsspelet 100, version 2",
                ],
            ],
        ],
        [
            "text" => "Filmer",
            "url" => "movie",
            "title" => "Lista med filmer",
        ],
        [
            "text" => "CMS System",
            "url" => "content",
            "title" => "CMS System",
            "submenu" => [
                [
                    "text" => "Blogg",
                    "url" => "content/blog",
                    "title" => "CMS Blogg",
                ],
                [
                    "text" => "Admin panel",
                    "url" => "content/admin",
                    "title" => "CMS admin panel",
                ],
                [
                    "text" => "Skapa inlägg",
                    "url" => "content/create",
                    "title" => "Skapa nytt inlägg",
                ],
            ],
        ],
        [
            "text" => "Textfilter",
            "url" => "textfilter",
            "title" => "TextFilter test",
        ],
        [
            "text" => "Test &amp; Lek",
            "url" => "lek",
            "title" => "Testa och lek med test- och exempelprogram",
        ],
        [
            "text" => "Anax dev",
            "url" => "dev",
            "title" => "Anax development utilities",
        ],
    ],
];
