<?php
/**
* Some usefull functions and little helpers
* @package HTML2PDF
**/

if (eregi(__FILE__, $_SERVER['SCRIPT_NAME'])) header("Location:http://".$_SERVER['SERVER_NAME']);

/**
* @return decimal
* @param int
* @desc conversion pixel -> millimeter in 72 dpi
**/
function px2mm($px)
{
	return $px*25.4/72;
}

/**
* @return string
* @param string
* @desc Like unhtmlentities, reverse function of htmlentities
* @see http://www.php.net/manual/en/function.htmlentities.php
**/
function txtentities($html)
{
	$trans = get_html_translation_table(HTML_ENTITIES);
	$trans = array_flip($trans);
	return strtr($html, $trans);
}

/**
* @return void
* @param mixed
* @desc Prints output of print_r in HTML
* @see http://www.php.net/manual/en/function.print-r.php
**/
function print_array($array)
{ 
	ob_start();
  print_r($array);
  $ret = ob_get_contents();
  ob_end_clean();
  echo nl2br(str_replace(" ", "&nbsp;", htmlentities($ret)));
}

/**
* @return string
* @param string $string to short
* @param int $len words to leave
* @desc Function returns the number $len of words from given $string
**/
function snipstr($string,$len=15) 
{
  $string = remove_code($string);
  $tok = strtok ($string," ");
  $i = 0;
  $snippsel = "";
  while ($tok && $i<$len) 
  {
    $snippsel = $snippsel." ".$tok;
    $tok = strtok (" ");
    $i++;
  }
  if (substr_count($string," ")>$len) { $snippsel = $snippsel."&nbsp;...";}
  return $snippsel;
}

/**
* @return string
* @desc Returns iterated class defintions. 
**/
function clr_cl()
{
  static $j=0;
  $j++;
  if ($j % 2 == 0) return "class=lightgrey";
  else return "class=white";
}

/**
 * @return string
 * @param string string
 * @desc Removes HTML-, JS-code from given string
**/
function remove_code($string)
{ 
  $search = array ("'<script[^>]*?>.*?</script>'si",
                 "'<[\/\!]*?[^<>]*?>'si");
  $replace = array ("", "");
  $ret_str = preg_replace($search, $replace, $string);
  return trim($ret_str);
}

/**
* @return array
* @param string $file
* @desc Parses a given CSS file into an array with properties for html2pdf class
*       Filename has to include path. Perhaps usefull in other applications. 
*       That's why it is a simple function not a method of html2pdf class.
*       Similar functionality in method LoadCSSfile.
* @see LoadCSSfile
**/
function parse_css($file)
{ 
	global $errmsg2, $orders_0;
  if ($fp = fopen("$file", "r"))
  { 
  	while ($line = fgets($fp, 2048))
    { 
    	$file_arr[] = trim($line,"\x7f..\xff\x0..\x1f"); 
    }
    fclose($fp);
  }
  $styles_str = implode("", $file_arr);
  $styles_str = str_replace(" ", "", $styles_str);
  $styles_arr = explode("}", $styles_str);
  $i=1;
  foreach ($styles_arr as $sta)
  {
    $sta = trim($sta);
    if ($sta=="") break;
    $tmp_style = explode("{", $sta);
    if (substr($tmp_style[0],0,2)=="a:") continue;
    $test_multiple_def = explode(",", $tmp_style[0]);
    if (is_array($test_multiple_def)) $tmp_style[0] = $test_multiple_def[0];
    $prop = explode(";", trim($tmp_style[1]));
    foreach ($prop as $pv) 
    {
	    if ($pv!="")
	    { 
	    	$tmp_prop = explode(":", $pv);
	      $newprop[$tmp_style[0]][trim($tmp_prop[0])] = trim($tmp_prop[1]);
	    }     
    }
  }
  return $newprop;
}

/**
* @return array
* @param string $htmlcolor
* @desc Returns an associative array (keys: R,G,B) from
*       a hex html code (e.g. #3FE5AA)
* @author By Clément Lavoillotte's WriteHTML
**/
function hex2dec($htmlcolor = "#000000")
{
  $R = substr($htmlcolor, 1, 2);
  $rouge = hexdec($R);
  $G = substr($htmlcolor, 3, 2);
  $vert = hexdec($G);
  $B = substr($htmlcolor, 5, 2);
  $bleu = hexdec($B);
  $rgb_color = array();
  $rgb_color['R']=$rouge;
  $rgb_color['G']=$vert;
  $rgb_color['B']=$bleu;
  return $rgb_color;
}

?>