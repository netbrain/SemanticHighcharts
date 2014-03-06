<?php

global $wgExtensionFunctions, $wgExtensionMessagesFiles, $wgExtensionCredits, $wgResourceModules, $shcAgreedToHCLicense;

//i18n
$wgExtensionMessagesFiles['SemanticHighcharts'] = __DIR__ . '/SemanticHighcharts.i18n.php';

$wgExtensionCredits['semantic'][] = array(
	'path' => __FILE__,
	'name' => 'SemanticHighcharts',
	'version' => '0.0.1',
	'author' => 'Kim Eik',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SemanticHighcharts',
	'descriptionmsg' => 'srf-hc-desc'
);

if (!defined('MEDIAWIKI')) {
	die('Not an entry point.');
}

if (!defined('ParamProcessor_VERSION')) {
	die($wgExtensionCredits['name'].' requires extension ParamProcessor');
}

if ( !defined( 'SMW_VERSION' ) ) {
	die($wgExtensionCredits['name'].' requires extension SemanticMediaWiki');
}

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	include_once( __DIR__ . '/vendor/autoload.php' );
}

$basePath = '';
if ( !file_exists( __DIR__ . '/vendor' ) ) {
	$basePath = '../../';
}

//Resources
$wgResourceModules['ext.srf.highcharts'] = array(
	'scripts' => array(
		$basePath.'vendor/netbrain/highcharts-js/highcharts.src.js',
		$basePath.'vendor/netbrain/highcharts-js/modules/exporting.src.js',
		$basePath.'vendor/netbrain/highcharts-js/modules/no-data-to-display.src.js',
		'src/js/srfhighcharts.js'
	),
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'SemanticHighcharts'
);

$wgExtensionFunctions[] = function() {
	global $smwgResultFormats, $smwgResultAliases, $shcFormats;

	$shcFormats = array(
		'highcharts' => 'SRF\HighchartsHelp',
		'hc:frequency-histogram' => 'SRF\Highcharts\FrequencyHistogram',
	);

	$formatAliases = array(
		'highcharts'   => array( 'hc' ),
	);

	foreach ( $shcFormats as $format => $formatClass ) {
			$smwgResultFormats[$format] = $formatClass;
			if ( isset( $smwgResultAliases ) && array_key_exists( $format, $formatAliases ) ) {
				$smwgResultAliases[$format] = $formatAliases[$format];
			}
	}
};