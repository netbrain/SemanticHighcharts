<?php
namespace SRF;
use SMWQueryResult;
use SMWResultPrinter;

/**
 * @package SRF
 * @author Kim Eik
 */
class HighchartsHelp extends SMWResultPrinter {

	public static function hasAgreedToLicense(){
		global $shcAgreedToHCLicense;
		return $shcAgreedToHCLicense;
	}

	public static function getLicenseWarning(){
		return '<div style="color:darkred; font-size: 16px;">'.wfMessage('srf-hc-license-warning')->text()."</div>\n";
	}

	/**
	 * Return serialised results in specified format.
	 * Implemented by subclasses.
	 */
	protected function getResultText( SMWQueryResult $res, $outputmode ) {
		global $shcFormats;

		$out = '';

		if(!self::hasAgreedToLicense()){
			$out .= self::getLicenseWarning();
		}

		$out .= "{| class=\"wikitable\" style=\"width:100%;\"\n";
		$out .= "|+ ".wfMessage('srf-hc-format-highcharts-table-caption')->text()."\n";
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
