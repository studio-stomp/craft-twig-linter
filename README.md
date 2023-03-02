# Craft Twig Linter plugin for Craft CMS 3.x

A module for Craft CMS bringing `sserbin/twig-linter` to Craft CMS projects

## Requirements

This plugin requires Craft CMS 3.5.0 or later.

## Installation

To install the module, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require studio-stomp/craft-twig-linter

3. Load the module in the application config:

```php
// File: ./config/app.console.php
return [
    'modules' => [
        // ... other modules
        'craft-twig-linter' => studiostomp\crafttwiglinter\CraftTwigLinter::class
    ],
    'bootstrap' => [
        // ... other module ids
        'craft-twig-linter'
    ],
];
```

## Craft Twig Linter Overview

Craft Twig Linter works by:
- Instantiating the Symfony command from `sserbin/twig-linter`
- Instantiating a Symfony console app for running the command
- Instantiating a WebApplication for the project (command runs in context of ConsoleApplication)
- Aggregate all registered Twig extension from both Console and Web (registered by both Craft Plugins as well as Craft Modules)
- Create a new Twig environment with all the collected extensions
- running the Symfony app

## Configuring Craft Twig Linter

Currently there is no configuration

## Using Craft Twig Linter

        php craft craft-twig-linter/lint /path/to/templates /path/to/other/templates

## Craft Twig Linter Roadmap

Some things to do, and ideas for potential features:

* Make template paths configurable
* Make template paths autodiscoverable
* Make Symfony app independent (PR `sserbin/twig-linter` or fork it)
* Make compatible for just Yii2 (if Yii2, does that also cover Craft?)

Brought to you by [Studio Stomp](https://studiostomp.nl)
