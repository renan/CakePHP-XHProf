<?php

App::uses('XHProf', 'XHProf.Lib');

/**
 * XHProf Extended class to set the state of it
 *
 */
class TestXHProf extends XHProf {

	public static function reset() {
		self::$_initiated = false;

		if (self::started()) {
			self::stop();
		}
	}

}
