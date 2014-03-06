<?php


namespace SRF\Highcharts;

use SMWQueryResult;
use SMWResultPrinter;

abstract class Chart extends SMWResultPrinter{

	/**
	 * Returns json output for highcharts
	 * @return string
	 */
	protected abstract function getChartJSON();


	/**
	 * Return serialised results in specified format.
	 * Implemented by subclasses.
	 */
	protected function getResultText( SMWQueryResult $res, $outputmode ) {
		global $shcAgreedToHCLicense;
		if(!$shcAgreedToHCLicense){
			return "This output format requires additional attention in regards to licensing. Please refer to https://www.mediawiki.org/wiki/Extension:SemanticHighcharts#License on how to proceed.";
		}
		SMWOutputs::requireResource( 'ext.srf.highcharts');
		$id = uniqid ('hc');
		$js = sprintf(
			'if (window.srfhighcharts === undefined) {window.srfhighcharts = {}};window.srfhighcharts[\'%s\'] = %s;',
			$id,$this->getChartJSON());

		$html = \Html::rawElement( 'div', array(
				'id' => $id,
				'style' => "min-width:{$this->params['min-width']}px; height:{$this->params['height']}px; margin 0 auto"
			)
		);
		$this->getOutput()->addInlineScript($js);
		return $html;
	}

	public function getParamDefinitions( array $definitions ) {
		$params = parent::getParamDefinitions( $definitions );

		$params['ytitle'] = array(
			'message' => 'srf-hc-paramdesc-ytitle',
			'default' => 'Y-axis',
		);

		$params['xtitle'] = array(
			'message' => 'srf-hc-paramdesc-xtitle',
			'default' => 'X-axis',
		);

		$params['title'] = array(
			'message' => 'srf-hc-paramdesc-title',
			'default' => 'Title',
		);

		$params['subtitle'] = array(
			'message' => 'srf-hc-paramdesc-subtitle',
			'default' => 'Subtitle',
		);

		$params['min-width'] = array(
			'message' => 'srf-hc-paramdesc-minwidth',
			'default' => '0',
		);

		$params['height'] = array(
			'message' => 'srf-hc-paramdesc-height',
			'default' => '400',
		);

		return $params;
	}
}