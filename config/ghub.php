<?php

return [

    'database_filename' => null,

    'settings_path' => null,

    'platform' => env('PLATFORM'),

    'application_path' => null,

    'application_filename' => null,

    'select_query' => null,

    'update_query' => null,

    'keymap' => [
        // Letters
        'A' => ['code' => 4],
        'B' => ['code' => 5],
        'C' => ['code' => 6],
        'D' => ['code' => 7],
        'E' => ['code' => 8],
        'F' => ['code' => 9],
        'G' => ['code' => 10],
        'H' => ['code' => 11],
        'I' => ['code' => 12],
        'J' => ['code' => 13],
        'K' => ['code' => 14],
        'L' => ['code' => 15],
        'M' => ['code' => 16],
        'N' => ['code' => 17],
        'O' => ['code' => 18],
        'P' => ['code' => 19],
        'Q' => ['code' => 20],
        'R' => ['code' => 21],
        'S' => ['code' => 22],
        'T' => ['code' => 23],
        'U' => ['code' => 24],
        'V' => ['code' => 25],
        'W' => ['code' => 26],
        'X' => ['code' => 27],
        'Y' => ['code' => 28],
        'Z' => ['code' => 29],

        // Numbers
        '1' => [
            'terms' => ['one'],
            'code' => 30,
        ],
        '2' => [
            'terms' => ['two'],
            'code' => 31,
        ],
        '3' => [
            'terms' => ['three'],
            'code' => 32,
        ],
        '4' => [
            'terms' => ['four'],
            'code' => 33,
        ],
        '5' => [
            'terms' => ['five'],
            'code' => 34,
        ],
        '6' => [
            'terms' => ['six'],
            'code' => 35,
        ],
        '7' => [
            'terms' => ['seven'],
            'code' => 36,
        ],
        '8' => [
            'terms' => ['eight'],
            'code' => 37,
        ],
        '9' => [
            'terms' => ['nine'],
            'code' => 38,
        ],
        '0' => [
            'terms' => ['zero'],
            'code' => 39,
        ],

        // Action keys
        'ENTER' => [
            'terms' => ['return'],
            'code' => 40,
        ],
        'ESCAPE' => [
            'code' => 41,
        ],
        'TAB' => [
            'code' => 43,
        ],
        'SPACEBAR' => [
            'code' => 44,
        ],
        'CAPS' => [
            'code' => 57,
        ],

        // Symbols
        '-' => [
            'name' => 'DASH',
            'terms' => ['minus'],
            'code' => 45,
        ],
        '=' => [
            'name' => 'EQUALS',
            'code' => 46,
        ],
        '[' => [
            'name' => 'LEFT SQUARE BRACKET',
            'code' => 47,
        ],
        ']' => [
            'name' => 'RIGHT SQUARE BRACKET',
            'code' => 48,
        ],
        '\\' => [
            'name' => 'BACKSLASH',
            'code' => 49,
        ],
        ';' => [
            'name' => 'SEMICOLON',
            'code' => 51,
        ],
        '\'' => [
            'name' => 'SINGLE QUOTE',
            'terms' => ['apostrophe'],
            'code' => 52,
        ],
        '`' => [
            'name' => 'BACK TICK',
            'code' => 53,
        ],
        ',' => [
            'name' => 'COMMA',
            'code' => 54,
        ],
        '.' => [
            'name' => 'PERIOD',
            'terms' => ['dot'],
            'code' => 55,
        ],
        '/' => [
            'name' => 'FORWARD SLASH',
            'code' => 56,
        ],

        // F keys
        'F1' => ['code' => 58],
        'F2' => ['code' => 59],
        'F3' => ['code' => 60],
        'F4' => ['code' => 61],
        'F5' => ['code' => 62],
        'F6' => ['code' => 63],
        'F7' => ['code' => 64],
        'F8' => ['code' => 65],
        'F9' => ['code' => 66],
        'F10' => ['code' => 67],
        'F11' => ['code' => 68],
        'F12' => ['code' => 69],

        // Arrows
        '⭠' => [
            'name' => 'LEFT',
            'terms' => ['arrow'],
            'code' => 79,
        ],
        '⭢' => [
            'name' => 'RIGHT',
            'terms' => ['arrow'],
            'code' => 80,
        ],
        '⭣' => [
            'name' => 'DOWN',
            'terms' => ['arrow'],
            'code' => 81,
        ],
        '⭡' => [
            'name' => 'UP',
            'terms' => ['arrow'],
            'code' => 82,
        ],

        // Modifiers
        '^' => [
            'name' => 'CTRL',
            'terms' => ['control'],
            'code' => 224,
            'modifier' => true,
        ],
        '⇧' => [
            'name' => 'SHIFT',
            'terms' => [],
            'code' => 225,
            'modifier' => true,
        ],
        '⎇' => [
            'name' => 'ALT',
            'terms' => ['alternate', 'option'],
            'code' => 226,
            'modifier' => true,
        ],
        '⌘' => [
            'name' => 'COMMAND',
            'terms' => ['meta', 'windows', 'cmd'],
            'code' => 227,
            'modifier' => true,
        ],
    ],

];
