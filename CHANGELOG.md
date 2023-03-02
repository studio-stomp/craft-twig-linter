# Craft Twig Linter Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased](https://github.com/studio-stomp/craft-twig-linter/compare/0.3.1...main)

### Changed
- feat: initial Craft CMS 4 compatibility

## [0.3.1](https://github.com/studio-stomp/craft-twig-linter/compare/0.3.0...0.3.1) - 2022-09-21

### Fixed
- fixed: refactor to better instantiate WebApp, specifically making Request identify as non-console request 

## [0.3.0](https://github.com/studio-stomp/craft-twig-linter/compare/0.2.0...0.3.0) - 2021-08-26

### Added
- Added PHP 8.0

### Changed
- Updated codeception
- Updated PHPStan to level = max

## [0.2.0](https://github.com/studio-stomp/craft-twig-linter/compare/0.1.0...0.2.0) - 2020-12-30
### Changed
- Refactored from Plugin to Module
    - Plugin is really for integration functionality within the CMS, whilst this code belongs in the release process of the code
- Expanded tests
- Created summary for results
- Created overview of errors
- Aggregate Twig extension to load before linting by loading up a WebApplication as well (LintCommand runs in context of ConsoleCommand already)
- Loss of autoloading code (Plugin vs Module) seems worth to pros (less code, allow loading only in Console)

## [0.1.0](https://github.com/studio-stomp/craft-twig-linter/tree/0.1.0) - 2020-08-27
### Added
- Initial release
