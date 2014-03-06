<?php
namespace SRF;
use SMWQueryResult;
use SMWResultPrinter;

/**
 * @package SRF
 * @author Kim Eik
 */
class HighchartsHelp extends SMWResultPrinter {

	/**
	 * Return serialised results in specified format.
	 * Implemented by subclasses.
	 */
	protected function getResultText( SMWQueryResult $res, $outputmode ) {
		global $shcFormats,$shcAgreedToHCLicense;

		$out = '';

		if(!$shcAgreedToHCLicense){
			$out .= '<div style="text-color:red;">'.wfMessage('srf-hc-license-warning')->text().'</div>';
		}

		$out .= "{| class=\"wikitable\" style=\"width:100%;\"\n";
		$out .= "|+ This is the \"highcharts\" result format for SMW, below you will find a list of all available highcharts formats and their parameters.\n";
		$out .= "|-\n";
		$out .= "!Format\n";
		$out .= "!Description\n";
		$out .= "!Parameters\n";

		foreach ($shcFormats as $name => $format) {

			$out .= "|-\n";
			$out .= "| $name\n";
			$out .= '| '.wfMessage("srf-hc-formatdesc-$name")->text()."\n";

			/**
			 * @var SMWResultPrinter
			 */
			$formatInstance = new $format;
			$out .= "|\n";
			foreach($formatInstance->getParamDefinitions(array()) as $name => $param){
				$out .= "*$name\n";
				$out .= "**".wfMessage($param['message'])->text()."\n";
			}
			$out .= "\n";
		}
		$out .= "|}\n";
		return $out;
	}
}
