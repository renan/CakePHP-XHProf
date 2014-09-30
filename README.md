# CakePHP XHProf Plugin

[![Build Status](https://secure.travis-ci.org/renan/CakePHP-XHProf.png?branch=master)](http://travis-ci.org/renan/CakePHP-XHProf)
[![Coverage Status](https://coveralls.io/repos/renan/CakePHP-XHProf/badge.png)](https://coveralls.io/r/renan/CakePHP-XHProf)
[![Latest Stable Version](https://poser.pugx.org/renan/cakephp-xhprof/v/stable.svg)](https://packagist.org/packages/renan/cakephp-xhprof)


Plugin that quickly enables XHProf profiling for your CakePHP application.

## Requirements

* PHP 5.3+
* CakePHP 2.3+
* XHProf

## Installation
First, make sure you enabled the xhprof extension and downloaded [phacility/xhprof](https://github.com/phacility/xhprof).

### Manual

1. Download http://github.com/renan/CakePHP-XHProf/zipball/master
2. Unzip the downloaded file
3. Move the contents to `Plugin/XHProf`

### Git Submodule

```bash
git submodule add git://github.com/renan/CakePHP-XHProf.git Plugin/XHProf
git submodule update --init
```

### Git Clone

```bash
git clone git://github.com/renan/CakePHP-XHProf.git Plugin/XHProf
```

### Composer / Packagist

Extra information can be found at [Packagist](https://packagist.org/packages/renan/cakephp-xhprof).

This would install the latest 0.1 version to `Plugin/XHProf`:

```json
{
	"require": {
		"renan/cakephp-xhprof": "0.1.*"
	}
}
```
You might want to use "require-dev" if you only plan to use this for development.

## Configuration

The basic configuration consists of loading the plugin and pointing where the `xhprof_lib` directory is located on your system.

On your `Config/bootstrap.php` file:

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

Just include the `XHProfDispatcher` in your dispatcher filters list on `Config/bootstrap.php`:

```php
Configure::write('Dispatcher.filters.xhprof', 'XHProf.XHProfDispatcher');
```

By default it will try to replace `%XHProfRunId%` with the saved run id from the page's output.
It allows you to include a link to the xhprof report on the page.

On your `View/Layouts/default.ctp`:

```php
$url = sprintf(
	'/url/to/xhprof_html/index.php?run=%s&source=%s',
	Configure::read('XHProf.replaceRunId'),
	Configure::read('XHProf.namespace')
);
echo $this->Html->link('XHProf Output', $url);
```

#### DebugKit Panel
If you are using [DebugKit](https://github.com/cakephp/debug_kit), you can use the provided panel here.

Make sure you include html config of the URL endpoint of the xhprof_html folder:
```php
Configure::write('XHProf', array(
	'library' => '/usr/local/Cellar/php54-xhprof/270b75d/xhprof_lib',
	'html' => 'http://path/to/xhprof_html',
));
```

Then you can add the panel in your DebugKit components setup:
```php
public $components = array(
	'DebugKit.Toolbar' => array(
		'panels' => array('XHProf.XHProf')
	),
);
```

Done. It should now display the new panel with the link to the result of this page output.

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

## Changelog

### 1.0.0 (2014-09-30)

- Added a DebugKit panel instead of messing with the layout file.
  Thanks to @dereuromark for the patch.
- Collecting code coverage metrics and reporting to coveralls

### 0.1.0 (2012-11-03)

Initial release

## License

Copyright (c) 2014 Renan Gonçalves

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
