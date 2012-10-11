<?php

App::uses('XHProfDispatcher', 'XHProf.Routing/Filter');
App::uses('CakeEvent', 'Event');
App::uses('CakeResponse', 'Network');

/**
 * XHProfDispatcher test case
 *
 */
class XHProfDispatcherTest extends CakeTestCase {

/**
 * Test that beforeDispatcher replaces run id
 *
 * @return void
 */
	public function testReplaceRunId() {
		$filter = new XHProfDispatcher();
		$response = new CakeResponse();
		$response->body('Run id: %XHProfRunId%.');

		$event = new CakeEvent('DispatcherTest', $this, compact('response'));
		$filter->beforeDispatch($event);
		$this->assertSame($response, $filter->afterDispatch($event));
		$this->assertRegExp('/^Run id: [0-9a-f]{13}\.$/', $response->body());
	}
}
