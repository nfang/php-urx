<?php

class Uri {
  /**
   * URN Syntax (http://www.ietf.org/rfc/rfc2141.txt
   */
  private static $URN_PATTERN = '/^urn:([A-Za-z0-9-]{1,31}):([A-Za-z0-9()+,.:=@;$_!*-]+)$/';

  /**
   * Uniform Resource Identifier (URI): Generic Syntax: http://tools.ietf.org/html/rfc3986
   */   
  private static $URI_PATTERN = '/^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?$/';

  private function __constructor() { }

  public static function create($str) {
    if (preg_match(self::$URN_PATTERN, $str, $matches)) {
      return new Urn($matches[1], $matches[2]);
    }

    if (preg_match(self::$URI_PATTERN, $str, $matches)) {
      list($_uri_domain, $_uri_port) = explode(':', $matches[4]);
      $_uri_options = array(
        'scheme' => $matches[2],
        'port' => $_uri_port ? intval($_uri_port) : null,
        'path' => $matches[5] ? preg_replace('/[^A-Za-z0-9_\/.]/', urlencode('\1'), $matches[5]) : '',
        'query' => $matches[7] ? $matches[7] : '',
        'fragment' => $matches[9] ? urlencode($matches[9]) : ''
      );
      return new Url($_uri_domain, $_uri_options);
    }

    return null;
  }
}

?>