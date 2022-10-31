<?php
namespace Drupal\employee_management;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\employee_management\Entity\DepartmentInterface;
use Drupal\employee_management\Entity\EmployeeInterface;

class RestCallbackHandler implements RestCallbackHandlerInterface {

  /**
   * @var EntityTypeManagerInterface
   */
  protected $entityTypeManager;
  /**
   * @var LoggerChannelInterface
   */
  protected $loggerChannel;

  /**
   * @param EntityTypeManagerInterface $entity_type_manager
   * @param LoggerChannelFactoryInterface $logger_factory
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, LoggerChannelFactoryInterface $logger_factory) {
    $this->entityTypeManager = $entity_type_manager;
    $this->loggerChannel = $logger_factory->get('employee_management');
  }

  /**
   * @param $id
   * @return EmployeeInterface|null
   */
  public function getEmployeeById($id) {
    try {
      /** @var EntityStorageInterface $storage */
      $storage = $this->entityTypeManager->getStorage('employee');
      return $storage->load($id);
    }
    catch (\Exception $exception) {
      $this->loggerChannel->error($exception->getMessage());
      return NULL;
    }
  }

  /**
   * @return EmployeeInterface[]
   */
  public function getEmployees() {
    try {
      /** @var EntityStorageInterface $storage */
      $storage = $this->entityTypeManager->getStorage('employee');
      return $storage->loadMultiple();
    }
    catch (\Exception $exception) {
      $this->loggerChannel->error($exception->getMessage());
      return [];
    }
  }

  /**
   * @param $id
   * @return DepartmentInterface|null
   */
  public function getDepartmentById($id) {
    try {
      /** @var EntityStorageInterface $storage */
      $storage = $this->entityTypeManager->getStorage('department');
      return $storage->load($id);
    }
    catch (\Exception $exception) {
      $this->loggerChannel->error($exception->getMessage());
      return NULL;
    }
  }

  /**
   * @return DepartmentInterface[]
   */
  public function getDepartments() {
    try {
      /** @var EntityStorageInterface $storage */
      $storage = $this->entityTypeManager->getStorage('department');
      return $storage->loadMultiple();
    }
    catch (\Exception $exception) {
      $this->loggerChannel->error($exception->getMessage());
      return [];
    }
  }

}
