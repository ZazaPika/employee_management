<?php

namespace Drupal\employee_management;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the entities.
 */
class AccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view ' . $entity->getEntityTypeId() . ' entities');
      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit ' . $entity->getEntityTypeId() . ' entities');
      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete ' . $entity->getEntityTypeId() . ' entities');
    }
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return isset($context['entity_type_id']) ? AccessResult::allowedIfHasPermission($account, 'add '. $context['entity_type_id'] .' entities') :  AccessResult::neutral();
  }


}
