<?php

namespace Drupal\employee_management;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Employee entities.
 *
 * @ingroup employee_management
 */
class EmployeeListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header = [
      'id' => $this->t('Employee ID'),
      'name'=> $this->t('Name'),
      'address'=> $this->t('Address'),
      'phone'=> $this->t('Phone'),
      'hobbies'=> $this->t('Hobbies'),
      'department'=> $this->t('Department')
    ];
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\employee_management\Entity\EmployeeInterface $entity */

    $department = $entity->getDepartment(TRUE);
    $row = [
      'id' => $entity->id(),
      'name'=> Link::createFromRoute(
        sprintf('%s %s', ucfirst($entity->getFirstname()), strtoupper($entity->getLastname())),
        'entity.employee.canonical', ['employee' => $entity->id()]
      ),
      'address'=> $entity->getAddress(),
      'phone'=> $entity->getPhone(),
      'hobbies'=> join(', ',$entity->getHobbies()),
      'department'=>  $department ? Link::createFromRoute(
        $department->label(), 'entity.department.canonical', ['department' => $department->id()]
      ) : '',
    ];
    return $row + parent::buildRow($entity);
  }

}
