CakePHP Completion
==================

A CakePHP plugin to enable (bash) completion for the CakePHP cli.

Installation
------------

You need bash-completion enabled on your machine, assuming that's the case;

	cp Vendor/cake /etc/bash_completion.d/
	. /etc/bash_completion.d/cake.bash

You'll need to enable the plugin in each installation you wish to use it with. Enable the plugin
as you would any other, by editing your bootstrap.php file:

	CakePlugin::load('Completion');

Usage
-----

Commands:

	$ Console/cake <tab>
	acl                    commandList            i18n                   testsuite
	api                    completion.completion  schema                 upgrade
	bake                   console                test
	$ Console/cake

Subcommands:

	$ Console/cake bake <tab>
	controller  dbConfig    fixture     model       plugin      project     test        view
	$ Console/cake bake

Options:

	$ Console/cake bake -
	-c            -h            -q            -v
	--connection  --help        --quiet       --verbose
	$ Console/cake bake -

History
-------

23/01/2012 - v0.1 Initial release
