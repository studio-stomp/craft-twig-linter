# Craft Twig Linter plugin for Craft CMS 3.x

A plugin for Craft CMS bringing `sserbin/twig-linter` to Craft CMS projects

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require --dev studio-stomp/craft-twig-linter

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Craft Twig Linter.

## Craft Twig Linter Overview

Craft Twig Linter works by:
- Instantiating the Symfony command from `sserbin/twig-linter`
- Instantiating a Symfony console app
- adding the bootstrapped Twig environment to the command
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

Brought to you by [Studio Stomp](https://studiostomp.nl)
