<?php

/**
*@file cp864.php
* CP864 Mapping and Charset implementation.
*
*/

//
// +----------------------------------------------------------------------+
// | Akelos PHP Application Framework                                     |
// +----------------------------------------------------------------------+
// | Copyright (c) 2002-2005, Akelos Media, S.L.  http://www.akelos.org/  |
// | Released under the GNU Lesser General Public License                 |
// +----------------------------------------------------------------------+
// | You should have received the following files along with this library |
// | - COPYRIGHT (Additional copyright notice)                            |
// | - DISCLAIMER (Disclaimer of warranty)                                |
// | - README (Important information regarding this library)              |
// +----------------------------------------------------------------------+
//





/**
* CP864  driver for Charset Class
*
* Charset::cp864 provides functionality to convert
* CP864 strings, to UTF-8 multibyte format and vice versa.
*
* @package AKELOS
* @subpackage Localize
* @author Bermi Ferrer Martinez <bermi@akelos.org>
* @copyright Copyright (c) 2002-2005, Akelos Media, S.L. http://www.akelos.org
* @license GNU Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
* @link http://www.unicode.org/Public/MAPPINGS/ Original Mapping taken from Unicode.org
* @since 0.1
* @version $Revision 0.1 $
*/
class cp864 extends AkCharset
{


	// ------ CLASS ATTRIBUTES ------ //



	// ---- Private attributes ---- //


	/**
	* CP864 to UTF-8 mapping array.
	*
	* @access private
	* @var    array    $_toUtfMap
	*/
	var $_toUtfMap = array(0=>0,1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12,13=>13,14=>14,15=>15,16=>16,17=>17,18=>18,19=>19,20=>20,21=>21,22=>22,23=>23,24=>24,25=>25,26=>26,27=>27,28=>28,29=>29,30=>30,31=>31,32=>32,33=>33,34=>34,35=>35,36=>36,37=>1642,38=>38,39=>39,40=>40,41=>41,42=>42,43=>43,44=>44,45=>45,46=>46,47=>47,48=>48,49=>49,50=>50,51=>51,52=>52,53=>53,54=>54,55=>55,56=>56,57=>57,58=>58,59=>59,60=>60,61=>61,62=>62,63=>63,64=>64,65=>65,66=>66,67=>67,68=>68,69=>69,70=>70,71=>71,72=>72,73=>73,74=>74,75=>75,76=>76,77=>77,78=>78,79=>79,80=>80,81=>81,82=>82,83=>83,84=>84,85=>85,86=>86,87=>87,88=>88,89=>89,90=>90,91=>91,92=>92,93=>93,94=>94,95=>95,96=>96,97=>97,98=>98,99=>99,100=>100,101=>101,102=>102,103=>103,104=>104,105=>105,106=>106,107=>107,108=>108,109=>109,110=>110,111=>111,112=>112,113=>113,114=>114,115=>115,116=>116,117=>117,118=>118,119=>119,120=>120,121=>121,122=>122,123=>123,124=>124,125=>125,126=>126,127=>127,128=>176,129=>183,130=>8729,131=>8730,132=>9618,133=>9472,134=>9474,135=>9532,136=>9508,137=>9516,138=>9500,139=>9524,140=>9488,141=>9484,142=>9492,143=>9496,144=>946,145=>8734,146=>966,147=>177,148=>189,149=>188,150=>8776,151=>171,152=>187,153=>65271,154=>65272,157=>65275,158=>65276,160=>160,161=>173,162=>65154,163=>163,164=>164,165=>65156,168=>65166,169=>65167,170=>65173,171=>65177,172=>1548,173=>65181,174=>65185,175=>65189,176=>1632,177=>1633,178=>1634,179=>1635,180=>1636,181=>1637,182=>1638,183=>1639,184=>1640,185=>1641,186=>65233,187=>1563,188=>65201,189=>65205,190=>65209,191=>1567,192=>162,193=>65152,194=>65153,195=>65155,196=>65157,197=>65226,198=>65163,199=>65165,200=>65169,201=>65171,202=>65175,203=>65179,204=>65183,205=>65187,206=>65191,207=>65193,208=>65195,209=>65197,210=>65199,211=>65203,212=>65207,213=>65211,214=>65215,215=>65217,216=>65221,217=>65227,218=>65231,219=>166,220=>172,221=>247,222=>215,223=>65225,224=>1600,225=>65235,226=>65239,227=>65243,228=>65247,229=>65251,230=>65255,231=>65259,232=>65261,233=>65263,234=>65267,235=>65213,236=>65228,237=>65230,238=>65229,239=>65249,240=>65149,241=>1617,242=>65253,243=>65257,244=>65260,245=>65264,246=>65266,247=>65232,248=>65237,249=>65269,250=>65270,251=>65245,252=>65241,253=>65265,254=>9632);
		

	/**
	*  UTF-8 to CP864 mapping array.
	*
	* @access private
	* @var    array    $_fromUtfMap
	*/
	var $_fromUtfMap = null;


	// ------------------------------



	// ------ CLASS METHODS ------ //


	// ---- Public methods ---- //


	/**
	* Encodes given CP864 string into UFT-8
	*
	* @access public
	* @see UtfDecode
	* @param    string    $string CP864 string
	* @return    string    UTF-8 string data
	*/
	function _Utf8StringEncode($string)
	{
		return parent::_Utf8StringEncode($string, $this->_toUtfMap);
	
	}// -- end of &Utf8StringEncode -- //

	/**
	* Decodes given UFT-8 string into CP864
	*
	* @access public
	* @see UtfEncode
	* @param    string    $string UTF-8 string
	* @return    string    CP864 string data
	*/
	function _Utf8StringDecode($string)
	{
		$this->_LoadInverseMap();
		return parent::_Utf8StringDecode($string, $this->_fromUtfMap);
	}// -- end of &Utf8StringDecode -- //
		
		
	// ---- Private methods ---- //
		
	/**
	* Flips $this->_toUtfMap to $this->_fromUtfMap
	*
	* @access private
	* @return	null
	*/
	function _LoadInverseMap()
	{
		static $loaded;
		if(!isset($loaded)){
			$loaded = true;
			$this->_fromUtfMap = array_flip($this->_toUtfMap);
		}
	}// -- end of _LoadInverseMap -- //
	
}

?>