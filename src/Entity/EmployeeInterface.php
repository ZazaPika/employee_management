<?php

namespace Drupal\employee_management\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Employee entities.
 *
 * @ingroup employee_management
 */
interface EmployeeInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Employee creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Employee.
   */
  public function getCreatedTime();

  /**
   * Sets the Employee creation timestamp.
   *
   * @param int $timestamp
   *   The Employee creation timestamp.
   *
   * @return \Drupal\employee_management\Entity\EmployeeInterface
   *   The called Employee entity.
   */
  public function setCreatedTime($timestamp);


}
