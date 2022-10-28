<?php
namespace Drupal\employee_management;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Database\Connection;

class HistoryManager implements HistoryManagerInterface {

  /**
   * @var Connection
   */
  protected $dbConnection;

  /**
   * @var TimeInterface
   */
  protected $time;

  public function __construct(Connection $connection, TimeInterface $time) {
    $this->dbConnection = $connection;
    $this->time = $time;
  }
}
