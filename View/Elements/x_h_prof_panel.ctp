<?php
/**
 * XHProf Panel
 */
?>
<h2>XHProf</h2>

<?php
if (Configure::read('XHProf.html')) {
	$url = sprintf(
		Configure::read('XHProf.html') . '/index.php?run=%s&source=%s',
		Configure::read('XHProf.replaceRunId'),
		Configure::read('XHProf.namespace')
	);
	echo $this->Html->link('XHProf Output', $url);
}
?>
