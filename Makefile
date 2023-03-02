# Makefile for easy execution of task across team members and environments.
#
# Inspired by:
# - https://localheinz.com/blog/2018/01/24/makefile-for-lazy-developers/
# - https://blog.jessekramer.io/tutorial/2018/10/22/php-projects-and-make.html
#
# Based on:
# - https://github.com/nicwortel/symfony-skeleton/blob/master/Makefile
# - https://github.com/infection/infection/blob/master/Makefile
# - https://github.com/opencfp/opencfp/blob/master/Makefile
#

.DEFAULT_GOAL := help

# See https://tech.davis-hansson.com/p/make/
MAKEFLAGS += --warn-undefined-variables
MAKEFLAGS += --no-builtin-rules

# Output any line in the form of `command:	\#\# Some description of the command
.PHONY: help
help:
	@echo "\033[33mUsage:\033[0m\n  make TARGET\n\n\033[32m#\n# Commands\n#---------------------------------------------------------------------------\033[0m\n"
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//' | awk 'BEGIN {FS = ":"}; {printf "\033[33m%s:\033[0m%s\n", $$1, $$2}'

#
# Variables
#---------------------------------------------------------------------------

#
# Commands (phony targets)
#---------------------------------------------------------------------------

.PHONY: serve
serve:	## Serve a local development environment through Docker services
serve: services-testing vendor
	$(info Prepare Craft CMS for use...)

.PHONY: services-testing
services-testing:	## Serve a testing environment through Docker services
services-testing:
	$(info Starting testing environment...)
	./dkr stop
	./dkr up -d xphp test_db

.PHONY: test
test:	## Run all test suites
test:	vendor services-testing test-unit
	$(info Running all test suites...)

.PHONY: test-unit
test-unit:	## Run all unit test suites
test-unit:	vendor services-testing
	$(info Running all unit test suites...)
	./dkr run --rm xphp php -dxdebug.mode=off vendor/bin/codecept run unit

#
# Rules from files (non-phony targets)
#---------------------------------------------------------------------------
vendor: composer.lock
	composer validate --no-check-publish --no-check-all
	composer install

