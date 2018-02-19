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
    $this->client = new \MHlavac\Gearman\Client();
    $this->client->addServer($host, $port);
    $this->task = $task;
  }

  public function setTask($task) {
    $this->task = $task;
    return $this;
  }

  /**
   * Sends a command using SyrotaAutomation protocol
   *
   * @param string $address Device address
   * @param string $command Command to send to device (including any arguments, for things like set commands)
   */
  public function command($address, $command) {
    $res = $this->client->doNormal($this->task, chr(2) . $address . '>'. $command . "\n");
    // This pattern represents response pattern slave device is expected to send
    preg_match('%\x02>(.*)\n%', $res, $matches);
    if (!isset($matches[1])) {
      throw new Exception("RS485 response does not match pattern: {$res}");
    }
    return $matches[1];
  }
}
