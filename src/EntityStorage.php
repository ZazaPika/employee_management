<?php

namespace Drupal\employee_management;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Cache\MemoryCache\MemoryCacheInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Language\LanguageManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the storage handler class for entities.
 *
 * This extends the base storage class, adding required special handling for
 * entities.
 *
 * @ingroup employee_management
 */
class EntityStorage extends SqlContentEntityStorage implements EntityStorageInterface {


  /**
   * @param EntityTypeInterface $entity_type
   * @param Connection $database
   * @param EntityFieldManagerInterface $entity_field_manager
   * @param CacheBackendInterface $cache
   * @param LanguageManagerInterface $language_manager
   * @param MemoryCacheInterface $memory_cache
   * @param EntityTypeBundleInfoInterface $entity_type_bundle_info
   * @param EntityTypeManagerInterface $entity_type_manager
   */
  public function __construct(EntityTypeInterface           $entity_type,
                              Connection                    $database,
                              EntityFieldManagerInterface   $entity_field_manager,
                              CacheBackendInterface         $cache,
                              LanguageManagerInterface      $language_manager,
                              MemoryCacheInterface          $memory_cache,
                              EntityTypeBundleInfoInterface $entity_type_bundle_info,
                              EntityTypeManagerInterface    $entity_type_manager
  ) {
    parent::__construct($entity_type, $database, $entity_field_manager, $cache, $language_manager, $memory_cache, $entity_type_bundle_info, $entity_type_manager);
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('database'),
      $container->get('entity_field.manager'),
      $container->get('cache.entity'),
      $container->get('language_manager'),
      $container->get('entity.memory_cache'),
      $container->get('entity_type.bundle.info'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function save(EntityInterface $entity) {
    $is_new = $entity->isNew();
    if($result = parent::save($entity)) {

    }
    return $result;
  }
}
