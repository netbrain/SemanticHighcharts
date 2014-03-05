<?php

if (!defined('MEDIAWIKI')) {
	die('Not an entry point.');
}

if (!defined('ParamProcessor_VERSION')) {
	die('SideBarMenu requires extension ParamProcessor');
}

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	include_once( __DIR__ . '/vendor/autoload.php' );
}

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'SemanticHighcharts',
	'version' => '0.0.1',
	'author' => 'Kim Eik',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SemanticHighcharts',
	'descriptionmsg' => 'semantichighcharts-desc'
);

//i18n
$wgExtensionMessagesFiles['SemanticHighcharts'] = dirname(__FILE__) . '/SemanticHighcharts.i18n.php';

//Resources
$wgResourceModules['ext.semantichighcharts.core'] = array(
	'scripts' => array(
		'src/js/srfhighcharts.js'
	),
	'localBasePath' => dirname(__FILE__),
	'remoteExtPath' => 'SideBarMenu'
);

$wgExtensionFunctions[] = function() {
	$formatFactory = \SMW\FormatFactory::singleton();
	$formatFactory->registerFormat('highcharts','\SRF\HighCharts');
	$formatFactory->registerAliases('highcharts',array('hc'));
};