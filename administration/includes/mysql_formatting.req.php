<?php   
  function getHtmlFromMysql($inputText) {
    return stripslashes($inputText);
  }
  function setHtmlToMysql($inputText) {
    return addslashes($inputText);
  }
  function accentshtmlentities($string) {
    $string = preg_replace('/€/', '&euro;', $string);
    $string = preg_replace('/á/', '&aacute;', $string);
    $string = preg_replace('/Á/', '&Aacute;', $string);
    $string = preg_replace('/â/', '&acirc;', $string);
    $string = preg_replace('/Â/', '&Acirc;', $string);
    $string = preg_replace('/à/', '&agrave;', $string);
    $string = preg_replace('/À/', '&Agrave;', $string);
    $string = preg_replace('/å/', '&aring;', $string);
    $string = preg_replace('/Å/', '&Aring;', $string);
    $string = preg_replace('/ã/', '&atilde;', $string);
    $string = preg_replace('/Ã/', '&Atilde;', $string);
    $string = preg_replace('/ä/', '&auml;', $string);
    $string = preg_replace('/Ä/', '&Auml;', $string);
    $string = preg_replace('/æ/', '&aelig;', $string);
    $string = preg_replace('/Æ/', '&AElig;', $string);
    $string = preg_replace('/ç/', '&ccedil;', $string);
    $string = preg_replace('/Ç/', '&Ccedil;', $string);
    $string = preg_replace('/é/', '&eacute;', $string);
    $string = preg_replace('/É/', '&Eacute;', $string);
    $string = preg_replace('/ê/', '&ecirc;', $string);
    $string = preg_replace('/Ê/', '&Ecirc;', $string);
    $string = preg_replace('/è/', '&egrave;', $string);
    $string = preg_replace('/È/', '&Egrave;', $string);
    $string = preg_replace('/ë/', '&euml;', $string);
    $string = preg_replace('/Ë/', '&Euml;', $string);
    $string = preg_replace('/í/', '&iacute;', $string);
    $string = preg_replace('/Í/', '&Iacute;', $string);
    $string = preg_replace('/î/', '&icirc;', $string);
    $string = preg_replace('/Î/', '&Icirc;', $string);
    $string = preg_replace('/ì/', '&igrave;', $string);
    $string = preg_replace('/Ì/', '&Igrave;', $string);
    $string = preg_replace('/ï/', '&iuml;', $string);
    $string = preg_replace('/Ï/', '&Iuml;', $string);
    $string = preg_replace('/ñ/', '&ntilde;', $string);
    $string = preg_replace('/Ñ/', '&Ntilde;', $string);
    $string = preg_replace('/ó/', '&oacute;', $string);
    $string = preg_replace('/Ó/', '&Oacute;', $string);
    $string = preg_replace('/ô/', '&ocirc;', $string);
    $string = preg_replace('/Ô/', '&Ocirc;', $string);
    $string = preg_replace('/ò/', '&ograve;', $string);
    $string = preg_replace('/Ò/', '&Ograve;', $string);
    $string = preg_replace('/ø/', '&oslash;', $string);
    $string = preg_replace('/Ø/', '&Oslash;', $string);
    $string = preg_replace('/õ/', '&otilde;', $string);
    $string = preg_replace('/Õ/', '&Otilde;', $string);
    $string = preg_replace('/ö/', '&ouml;', $string);
    $string = preg_replace('/Ö/', '&Ouml;', $string);
    $string = preg_replace('/œ/', '&oelig;', $string);
    $string = preg_replace('/Œ/', '&OElig;', $string);
    $string = preg_replace('/š/', '&scaron;', $string);
    $string = preg_replace('/Š/', '&Scaron;', $string);
    $string = preg_replace('/ß/', '&szlig;', $string);
    $string = preg_replace('/ð/', '&eth;', $string);
    $string = preg_replace('/Ð/', '&ETH;', $string);
    $string = preg_replace('/þ/', '&thorn;', $string);
    $string = preg_replace('/Þ/', '&THORN;', $string);
    $string = preg_replace('/ú/', '&uacute;', $string);
    $string = preg_replace('/Ú/', '&Uacute;', $string);
    $string = preg_replace('/û/', '&ucirc;', $string);
    $string = preg_replace('/Û/', '&Ucirc;', $string);
    $string = preg_replace('/ù/', '&ugrave;', $string);
    $string = preg_replace('/Ù/', '&Ugrave;', $string);
    $string = preg_replace('/ü/', '&uuml;', $string);
    $string = preg_replace('/Ü/', '&Uuml;', $string);
    $string = preg_replace('/ý/', '&yacute;', $string);
    $string = preg_replace('/Ý/', '&Yacute;', $string);
    $string = preg_replace('/ÿ/', '&yuml;', $string);
    $string = preg_replace('/Ÿ/', '&Yuml;', $string);
    $string = preg_replace('/…/', '&hellip;', $string);
    $string = preg_replace('/“/', '&ldquo;', $string);
    $string = preg_replace('/”/', '&rdquo;', $string);
    $string = preg_replace('/„/', '&bdquo;', $string);
    $string = preg_replace('/«/', '&laquo;', $string);
    $string = preg_replace('/»/', '&raquo;', $string);
    $string = preg_replace('/‹/', '&lsaquo;', $string);
    $string = preg_replace('/›/', '&rsaquo;', $string);
    return $string;
  }
?>