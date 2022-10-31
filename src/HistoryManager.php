<?php
namespace Drupal\employee_management;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Console\Bootstrap\Drupal;
use Drupal\Core\Database\Connection;
use Drupal\Core\Database\Query\PagerSelectExtender;
use Drupal\Core\Session\AccountProxyInterface;

class HistoryManager implements HistoryManagerInterface {

  /**
   * @var Connection
   */
  protected $dbConnection;

  /**
   * @var TimeInterface
   */
  protected $time;
  /**
   * @var AccountProxyInterface
   */
  protected $account;

  /**
   * @param Connection $connection
   * @param TimeInterface $time
   * @param AccountProxyInterface $account
   */
  public function __construct(Connection $connection, TimeInterface $time, AccountProxyInterface $account ) {
    $this->dbConnection = $connection;
    $this->time = $time;
    $this->account = $account;
  }

  public function insertEntry($event, $context) {
    return $this->dbConnection->insert(static::TABLE)
      ->fields([
        'uid' => $this->account->id(),
        'timestamp' => $this->time->getRequestTime(),
        'event' => $event,
        'context' => serialize($context)
      ])->execute();
  }

  /**
   * @param \DateTime|NULL $from
   * @param \DateTime|NULL $to
   * @return \Drupal\Core\Database\Query\SelectInterface
   */
  protected function getQuery(\DateTime $from = NULL, \DateTime $to = NULL) {
    $query = $this->dbConnection->select(static::TABLE, 'E');
    $query->join('users_field_data', 'U', 'E.uid = U.uid');
    $query->fields('E', ['hid', 'uid', 'timestamp', 'event', 'context'])
      ->addField('U', 'name', 'username');
    $query->orderBy('timestamp', 'DESC');
    if($from) {
      $query->condition('E.timestamp' , $from->getTimestamp() , '>=');
    }
    if($to) {
      $query->condition('E.timestamp' , $to->getTimestamp() , '<=');
    }
    return $query;
  }

  /**
   * @param $resulset
   * @return array
   */
  protected function formatResultSet($resulset) {
    $date = new \DateTime();
    $date->setTimestamp( $resulset['timestamp']);
    return [
      'date' => $date->format('d/m/Y - H:i'),
      'type' => HistoryManagerInterface::EVENTS_LABEL[$resulset['event']] ?? '',
      'user' => sprintf('%s (%d)', (!empty($resulset['username']) ? $resulset['username'] :  'anonymous'), $resulset['uid']),
      'context' => json_encode(@unserialize($resulset['context']))
    ];
  }

  /**
   * @param \DateTime|NULL $from
   * @param \DateTime|NULL $to
   * @return array
   */
  public function getEventBetween(\DateTime $from = NULL, \DateTime $to = NULL) {
    $query = $this->getQuery($from, $to);
    $pager = $query->extend(PagerSelectExtender::class)
      ->limit(20);

    return array_map(function ($resultset) {
      return $this->formatResultSet((array)$resultset);
    }, $pager->execute()->fetchAll());
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
          'timestamp' => [
            'type' => 'int',
            'not null' => TRUE,
            'default' => 0,
            'description' => 'Unix timestamp of when query occurred.'
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
