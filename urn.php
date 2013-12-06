<?php

require_once 'uri.php';

/**
 * URN abstraction based on RFC2141 (http://www.ietf.org/rfc/rfc2141.txt)
 */
class Urn extends Uri {
  private $nid;
  public function getNamespaceIdentifier() {
    return $this->nid;
  }

  private $nss;
  public function getNamespaceSpecificString() {
    return $this->nss;
  }

  public function __construct($nid, $nss) {
    $this->nid = $nid;
    $this->nss = $nss;
  }

  public function __toString() {
    $s_urn = 'urn:';
    $s_urn .= $this->nid;
    $s_urn .= ':' . $this->nss;
    return $s_urn;
  }
}

?>