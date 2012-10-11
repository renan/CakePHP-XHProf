# CakePHP XHProf Plugin [![Build Status](https://secure.travis-ci.org/renansaddam/CakePHP-XHProf-Plugin.png)](http://travis-ci.org/renansaddam/CakePHP-XHProf-Plugin)

Plugin that quickly enables XHProf profiling for your CakePHP application.

## Requirements

* PHP 5.2+
* XHProf
* CakePHP 2.1+ (2.2+ is needed for using the Dispatcher Filter)

## Installation

### Manual

1. Download http://github.com/renansaddam/CakePHP-XHProf-Plugin/zipball/master
2. Unzip the downloaded file
3. Move the contents to `app/Plugin/XHProf`

### Git Submodule

```bash
git submodule add git://github.com/renansaddam/CakePHP-XHProf-Plugin.git app/Plugin/XHProf
git submodule update --init
```

### Git Clone

```bash
git clone git://github.com/renansaddam/CakePHP-XHProf-Plugin.git app/Plugin/XHProf
```

### Composer / Packagist

```json
{
	"require": {
		"renansaddam/cakephp-xhprof-plugin": "dev-master"
	},
	"extra": {
		"installer-paths": {
			"Plugin/XHProf/": ["renansaddam/cakephp-xhprof-plugin"]
		}
	}
}
```

## Configuration

The basic configuration consists in loading the plugin and pointing where the `xhprof_lib` directory is located on your system.

On your `app/Config/bootstrap.php` file:

```php
// Load XHProf Plugin
CakePlugin::load('XHProf');

// XHProf Configuration
Configure::write('XHProf', array(
	'library' => '/usr/local/Cellar/php54-xhprof/270b75d/xhprof_lib',
));
```

Options:

* `library`: Path to your xhprof_lib directory (required)
* `namespace`: Namespace to save your xhprof runs, default is your application directory name
* `flags`: Flags passed over to profiler, default is `0`. For a list of flags visit: http://php.net/xhprof.constants.php
* `ignored_functions`: Array of functions to ignore, default is `call_user_func` and `call_user_func_array`
* `replaceRunId`: Placeholder used to replace the run id in order to display a link in the page, set `false` to disable, default is `%XHProfRunId%`. Read the usage for more information

All options example:

```php
Configure::write('XHProf', array(
	'library' => '/usr/local/Cellar/php54-xhprof/270b75d/xhprof_lib',
	'namespace' => 'myapp',
	'flags' => XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY,
	'ignored_functions' => array(
		'my_function',
		'my_other_function',
	),
	'replaceRunId' => false,
));
```

## Usage

### Dispatcher Filter

Just include the `XHProfDispatcher` on your dispatcher filters list on `app/Config/bootstrap.php`:

```php
Configure::write('Dispatcher.filters', array(
	'XHProf.XHProfDispatcher',
));
```

By default it will try replace `%replaceRunId%` to the saved run id from the page's output. It allows you to include a link to the xhprof report on the page.

On your `app/View/Layouts/default.ctp`:

```php
$url = sprintf(
	'/path/to/xhprof_html/index.php?run=%s&source=%s',
	'%XHProfRunId%',
	Configure::read('XHProf.namespace')
);
echo $this->Html->link('XHProf Output', $url);
```

### Manual

This method is very useful when profiling specific points on your code.
For that, just use the `XHProf` class to assist you.

Example:

```php
// Declare the class location
App::uses('XHProf', 'XHProf.Lib');

// Start the profiler
XHProf::start();

// ... your application code

// Stop the profiler
// 1. Returning the profiler data
$data = XHProf::stop();

// 2. or Save the profiler data, returning the run id
$runId = XHProf::finish();
```

_Note_: There are two ways to stop the profiler as explained above. However only one can be used at each run.

## License

Copyright (c) 2012 Renan Gonçalves

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
