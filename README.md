# CakePHP Completion

A CakePHP plugin to enable (bash) completion for the CakePHP cli.

## Requirements

* CakeSession-accessible User session
* CakePHP 2.2.0+

## Installation

_[Manual]_

* Download this: [https://github.com/ad7six/cakephp-completion/zipball/master](https://github.com/ad7six/cakephp-completion/zipball/master)
* Unzip that download.
* Copy the resulting folder to `app/Plugin`
* Rename the folder you just copied to `Completion`

_[GIT Submodule]_

In your app directory type:

	git submodule add git://github.com/ad7six/cakephp-completion.git Plugin/Completion
	git submodule init
	git submodule update

_[GIT Clone]_

In your plugin directory type

	git clone git://github.com/ad7six/cakephp-completion.git Completion

## Setup

You need bash-completion enabled on your machine, assuming that's the case;

	cp Plugin/Completion/Vendor/cake.bash /etc/bash_completion.d/
	. /etc/bash_completion.d/cake.bash

Mac OS X users with homebrew may do the following - after installating `bash-completion`:

	cp Plugin/Completion/Vendor/cake.bash /usr/local/etc/bash_completion.d/
	. /usr/local/etc/bash_completion.d/cake.bash

You'll need to enable the plugin in each installation you wish to use it with. Enable the plugin
as you would any other, by editing your bootstrap.php file:

	CakePlugin::load('Completion');

## Usage

Commands:

	$ Console/cake <tab>
	acl           bake          console       schema        test          upgrade
	api           command_list  i18n          server        testsuite
	$ Console/cake

Subcommands:

	$ Console/cake bake <tab>
	controller  db_config   fixture     model       plugin      project     test        view
	$ Console/cake bake

Options:

	$ Console/cake bake -<tab>
	-c            -h            -q            -v
	--connection  --help        --quiet       --verbose
	$ Console/cake bake -

## History

* 23/01/2012 - v0.1 Initial release
* 18/08/2012 - v0.2 Update for use with 2.2.x

## License

Copyright (c) 2012 Andy Dawson

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
