<?php

require_once 'uri.php';

class Url extends Uri {
  private $scheme;
  public function getScheme() { 
    return $this->scheme;
  }

  private $domain;
  public function getDomain() {
    return $this->domain;
  }

  private $port;
  public function getPort() { 
    return $this->port;
  }

  private $path;
  public function getPath() { 
    return $this->path;
  }

  private $query;
  public function getQuery() { 
    return $this->query;
  }

  private $fragment;
  public function getFragment() {
    return $this->fragment;
  }

  private static $_defaultOptions = array(
    'scheme' => 'http',
    'port' => 80,
    'path' => null,
    'query' => null,
    'fragment' => null
  );

  public function __construct($domain, $options = array()) {
    if (!isset($options['port']) || !is_numeric($options['port'])) {
      $options['port'] = self::$_defaultOptions['port'];
    }
    $_mergedOptions = array_merge(self::$_defaultOptions, $options);

    $this->domain = $domain;
    if ($_mergedOptions['scheme']) {
      $this->scheme = $_mergedOptions['scheme'];
    }

    $this->port = $_mergedOptions['port'];
    $this->path = $_mergedOptions['path'];
    $this->path = trim($this->path, '/');
    $this->query = $_mergedOptions['query'];
    $this->fragment = $_mergedOptions['fragment'];
  }

  public function __toString() {
    $s_uri = $this->scheme;
    $s_uri .= '://';
    $s_uri .= $this->domain;
    $s_uri .= $this->port != 80 ? 
              ':' . $this->port : 
              ($this->path || $this->query || $this->fragment) ? '/' : '';

    $s_uri .= ($this->path) ? $this->path : '';
    $s_uri .= ($this->query) ? '?' . $this->query : '';
    $s_uri .= ($this->fragment) ? '#' . $this->fragment : '';

    return $s_uri;
  }
}

?>