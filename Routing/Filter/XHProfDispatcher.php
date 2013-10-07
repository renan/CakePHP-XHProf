<?php

App::uses('DispatcherFilter', 'Routing');
App::uses('XHProf', 'XHProf.Lib');

/**
 * XHProf Dispatcher Filter
 *
 */
class XHProfDispatcher extends DispatcherFilter {

/**
 * Start the profiler
 *
 * @param CakeEvent $event
 * @return void
 */
	public function beforeDispatch(CakeEvent $event) {
		XHProf::start();
	}

/**
 * Stop the profiler
 *
 * @return mixed Void or modified response if replaceRunId is defined
 */
	public function afterDispatch(CakeEvent $event) {
		$runId = XHProf::finish();
		$replaceRunId = Configure::read('XHProf.replaceRunId');

		if (!empty($replaceRunId)) {
			$body = $event->data['response']->body();
			$body = str_replace($replaceRunId, $runId, $event->data['response']);

			$event->data['response']->body($body);
			return $event->data['response'];
		}
	}
}
