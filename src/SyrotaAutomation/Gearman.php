<?php

namespace SyrotaAutomation;

class Gearman
{

  /*
   * Gearman client
   */
  private $client;

  /*
   * Gearman task identifier
   */
  private $task;

  public function __construct($task, $host = 'localhost', $port = 4730) {
    $this->client = new GearmanClient();
    $this->client->addServer($host, $port);
    $this->task = $task;
  }

  public function setTask($task) {
    $this->task = $task;
    return $this;
  }

  public function command($address, $command) {
    $res = $this->client->doNormal($this->task, chr(2) . $address . '>'. $command . "\n");
    switch($this->client->returnCode()) {
      case GEARMAN_SUCCESS:
        continue;
      case GEARMAN_TIMEOUT:
        throw new Exception("Gearman request timed out");
        break;
      default:
        throw new Exception("Gearman error #{$this->getErrno()}: {$this->client->error()}");
    }
    preg_match('%\x02>(.*)\n%', $res, $matches);
    if (!isset($matches[1])) {
      throw new Exception("RS485 response does not match pattern: {$res}");
    }
    return $matches[1];
  }
}
