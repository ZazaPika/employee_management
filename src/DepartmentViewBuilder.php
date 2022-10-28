<?php

namespace Drupal\employee_management;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Entity\EntityViewBuilder;
use Drupal\Core\Link;
use Drupal\employee_management\Entity\DepartmentInterface;
use Drupal\employee_management\Entity\EmployeeInterface;

class DepartmentViewBuilder extends EntityViewBuilder {
  /**
   * {@inheritdoc}
   */
  public function buildMultiple(array $build_list) {
    return array_map(function (array $build) {
      $this->attachEmployees($build);
      return $build;
    }, parent::buildMultiple($build_list));
  }

  /**
   * @param array $build
   * @return void
   * @throws InvalidPluginDefinitionException
   * @throws PluginNotFoundException
   */
  protected function attachEmployees(array &$build) {
    if (!isset($build['#view_mode']) || !isset($build['#department']) || !in_array($build['#view_mode'], ['full', 'default']))
      return;
    /** @var DepartmentInterface $entity */
    $entity = $build['#department'];
    $employees = $entity->getRelatedEmployee(TRUE);
    $build['employees'] = [
      '#type' => 'table',
      '#header' => [
        'id' => $this->t('Employee ID'),
        'name'=> $this->t('Name')
      ],
      '#rows' => array_map(function (EmployeeInterface $employee) {
        return[
          'data' => [
            ['data' => $employee->id()],
            ['data' => Link::createFromRoute(
              sprintf('%s %s', ucfirst($employee->getFirstname()), strtoupper($employee->getLastname())),
              'entity.employee.canonical', ['employee' => $employee->id()]
            ),]
          ],
        ];
      }, $employees),
      '#empty' => 'No DATA'
    ];
  }
}
