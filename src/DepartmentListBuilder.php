<?php

namespace Drupal\employee_management;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Department entities.
 *
 * @ingroup employee_management
 */
class DepartmentListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header = [
      'id' => $this->t('Department ID'),
      'name' => $this->t('Name'),
      'description'=> $this->t('Description'),
      'employees'=> $this->t('Employees (count)'),
    ];
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\employee_management\Entity\Department $entity */
    $description = trim(strip_tags($entity->getDescription()));
    $row = [
      'id' => $entity->id(),
      'name' => Link::createFromRoute($entity->label(), 'entity.department.canonical', ['department' => $entity->id()]),
      'description'=>  strlen($description) > 50 ? substr($description,0,50) . ' ...' : $description,
      'employees' => count($entity->getRelatedEmployee())
    ];
    return $row + parent::buildRow($entity);
  }
}
