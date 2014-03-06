<?php
namespace SRF;
use SMWOutputs;
use SMWQueryResult;
use SMWResultPrinter;

/**
 * Class SRFHighCharts
 * @package SRF
 * @author Kim Eik
 */
class HighCharts extends SMWResultPrinter {

	/**
	 * Return serialised results in specified format.
	 * Implemented by subclasses.
	 */
	protected function getResultText( SMWQueryResult $res, $outputmode ) {
		global $shcFormats;

		$out = "{| class=\"wikitable\" style=\"width:100%;\"\n";
		$out .= "|+ This is the \"highcharts\" result format for SMW, below you will find a list of all available highcharts formats and their parameters.\n";
		$out .= "|-\n";
		$out .= "!Format\n";
		$out .= "!Description\n";
		$out .= "!Parameters\n";

		foreach ($shcFormats as $name => $format) {

			$out .= "|-\n";
			$out .= "| $name\n";
			$out .= '| '.wfMessage("srf-hc-formatdesc-$name")->text()."\n";
			$out .= '| ';

			/**
			 * @var SMWResultPrinter
			 */
			$formatInstance = new $format;
			foreach($formatInstance->getParamDefinitions(array()) as $param){
				$out .= var_dump($param);
			}
			$out .= "\n";
		}
		$out .= "|}\n";
		return $out;
	}
}
