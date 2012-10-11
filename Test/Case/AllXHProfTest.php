<?php

/**
 * Run All XHProf Tests in one
 *
 */
class AllXHProfTest extends PHPUnit_Framework_TestSuite {

/**
 * Suite define the tests for this suite
 *
 * @return void
 */
	public static function suite() {
		$path = CakePlugin::path('XHProf');

		$suite = new CakeTestSuite('All XHProf tests');
		$suite->addTestDirectoryRecursive($path . 'Test' . DS . 'Case' . DS);
		
		return $suite;
	}
}