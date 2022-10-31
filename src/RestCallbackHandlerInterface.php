<?php
namespace Drupal\employee_management;
use Drupal\employee_management\Entity\DepartmentInterface;
use Drupal\employee_management\Entity\EmployeeInterface;

interface RestCallbackHandlerInterface {
  /**
   * @param $id
   * @return EmployeeInterface|null
   */
  public function getEmployeeById($id);
  /**
   * @return EmployeeInterface[]
   */
  public function getEmployees();
  /**
   * @param $id
   * @return DepartmentInterface|null
   */
  public function getDepartmentById($id);
  /**
   * @return DepartmentInterface[]
   */
  public function getDepartments();
}
