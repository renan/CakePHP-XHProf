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

/**
 * XHProf test case
 *
 */
class XHProfTest extends CakeTestCase {

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();

		TestXHProf::reset();
	}

/**
 * Start and stop test
 *
 * @return void
 */
	public function testStartStop() {
		$XHProf = $this->getMockClass('XHProf', array(
			'_initialize',
		));

		$XHProf::staticExpects($this->any())
			->method('_initialize');

		$XHProf::start();
		$this->assertTrue($XHProf::started());

		$result = $XHProf::stop();
		$this->assertFalse($XHProf::started());

		$this->assertInternalType('array', $result);
		$this->assertTrue(isset($result['main()==>XHProf::started']));
		$this->assertTrue(isset($result['main()==>XHProf::stop']));
	}

/**
 * Start and finish test
 *
 * @return void
 */
	public function testStartFinish() {
		$XHProf = $this->getMockClass('XHProf', array(
			'_initialize',
		));

		$XHProf::staticExpects($this->any())
			->method('_initialize');

		$XHProf::start();
		$this->assertTrue($XHProf::started());

		$result = $XHProf::finish();
		$this->assertFalse($XHProf::started());

		$this->assertInternalType('string', $result);
		$this->assertRegExp('/^[0-9a-f]{13}$/', $result);
	}
}
