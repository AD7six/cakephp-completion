CakePHP Bash Completion
=======================

A CakePHP plugin to enable bash completion for the CakePHP cli.

Installation
------------

You need bash-completion enabled on your machine, assuming that's the case;

    cp Vendor/cake /etc/bash_completion.d/
	. /etc/bash_completion.d/cake


You'll need to enable the plugin in each installation you wish to use it with. Enable the plugin
as you would any other, by editing your bootstrap.php file:

    CakePlugin::load('BashCompletion');

Usage
-----

	$ Console/cake <tab>
	acl                             console                         test
	api                             DebugKit.benchmark              testsuite
	bake                            DebugKit.whitespace             upgrade
	BashCompletion.bash_completion  i18n
	command_list                    schema
	$ Console/cake

History
-------

23/01/2012 - v0.1 Initial release