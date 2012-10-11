<?php

App::uses('TestXHProf', 'XHProf.Test/Lib');

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
		$XHProf = $this->getMockClass('TestXHProf', array(
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
		$XHProf = $this->getMockClass('TestXHProf', array(
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
