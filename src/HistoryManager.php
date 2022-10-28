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

  /**
   * @return array[]
   */
  public static function getSchema() {
    return [
      static::TABLE => [
        'fields' => [
          'hid' => [
            'type' => 'serial',
            'not null' => TRUE,
            'description' => 'Primary Key: Unique log ID.'
          ],
          'uid' => [
            'type' => 'int',
            'not null' => TRUE,
            'description' => 'User id'
          ],
          'event' => [
            'type' => 'int',
            'not null' => TRUE,
            'description' => 'Event type'
          ],
          'context' => [
            'type' => 'blob',
            'not null' => TRUE,
            'size' => 'big'
          ]
        ],
        'primary key' => ['hid']
      ]
    ];
  }
}
