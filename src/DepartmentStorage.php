<?php

namespace Drupal\employee_management;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Cache\MemoryCache\MemoryCacheInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;

class DepartmentStorage extends EntityStorage {
  /**
   * @var EntityStorageInterface
   */
  protected $employeeStorage;
  /**
   * {@inheritdoc}
   */
  public function __construct(EntityTypeInterface           $entity_type,
                              Connection                    $database,
                              EntityFieldManagerInterface   $entity_field_manager,
                              CacheBackendInterface         $cache,
                              LanguageManagerInterface      $language_manager,
                              MemoryCacheInterface          $memory_cache,
                              EntityTypeBundleInfoInterface $entity_type_bundle_info,
                              EntityTypeManagerInterface    $entity_type_manager,
                              HistoryManagerInterface       $history_manager
  ){
    parent::__construct($entity_type, $database, $entity_field_manager, $cache, $language_manager, $memory_cache, $entity_type_bundle_info, $entity_type_manager, $history_manager);
    $this->employeeStorage = $entity_type_manager->getStorage('employee');
  }
}
