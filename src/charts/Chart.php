<?php


namespace SRF\Highcharts;

use SMWOutputs;
use SMWQueryResult;
use SMWResultPrinter;
use SRF\HighchartsHelp;

abstract class Chart extends SMWResultPrinter{
	/**
	 * @var SMWQueryResult the query result.
	 */
	protected $queryResult;

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
		if(!HighchartsHelp::hasAgreedToLicense()){
			return HighchartsHelp::getLicenseWarning();
		}
		$this->queryResult = $res;
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
			'default' => '',
		);

		$params['xtitle'] = array(
			'message' => 'srf-hc-paramdesc-xtitle',
			'default' => '',
		);

		$params['title'] = array(
			'message' => 'srf-hc-paramdesc-title',
			'default' => '',
		);

		$params['subtitle'] = array(
			'message' => 'srf-hc-paramdesc-subtitle',
			'default' => '',
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