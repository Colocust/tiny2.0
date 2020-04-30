<?php

namespace Tiny;

use Config\CaptchaDBConfig;

class Captcha extends Redis {

  public function __construct() {
    parent::__construct(CaptchaDBConfig::HOST, CaptchaDBConfig::PORT, CaptchaDBConfig::TIMEOUT, CaptchaDBConfig::DB);
  }

  public function get(string $telephone, int $default = 123456, int $ttl = 5 * 60): int {
    $this->db->setex($telephone, $ttl, $default);
    return $this->db->get($telephone);
  }

  public function check(string $telephone, int $captcha): bool {
    if ($this->db->get($telephone) === $captcha) {
      $this->db->del($telephone);
      return true;
    }
    Logger::getInstance()->error($telephone . " and " . $captcha . " is not matched");
    return false;
  }
}