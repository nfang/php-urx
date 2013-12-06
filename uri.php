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

  /**
   * Factory method to create URL/URN instances based on passed string
   */
  public static function create($str) {
    if (preg_match(self::$URN_PATTERN, $str, $matches)) {
      return new Urn($matches[1], $matches[2]);
    }

    /**
     * - Letters (A–Z and a–z), numbers (0–9) and the characters '.','-','~' and '_' are left as-is
     * - SPACE is encoded as '+' or "%20"
     * - All other characters are encoded as %HH hex representation with any non-ASCII characters 
     *   first encoded as UTF-8 (or other specified encoding)
     */
    if (preg_match(self::$URI_PATTERN, $str, $matches)) {
      list($_uri_domain, $_uri_port) = explode(':', $matches[4]);
      $_uri_options = array(
        'scheme' => $matches[2],
        'port' => $_uri_port ? intval($_uri_port) : null,
        'path' => $matches[5] ? 
                  preg_replace_callback(
                    '/[^A-Za-z0-9.-_~\/]/',
                    function ($m) { return urlencode($m[0]); }, 
                    $matches[5]) : 
                  '',
        'query' => $matches[7] ? 
                  preg_replace_callback(
                    '/[^A-Za-z0-9.-_~=&]/',
                    function ($m) { return urlencode($m[0]); }, 
                    $matches[7]) : 
                  '',
        'fragment' => $matches[9] ? urlencode($matches[9]) : ''
      );
      return new Url($_uri_domain, $_uri_options);
    }

    return null;
  }
}

?>