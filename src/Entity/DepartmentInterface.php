<?php

namespace Drupal\employee_management\Entity;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\TypedData\Exception\MissingDataException;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Department entities.
 *
 * @ingroup employee_management
 */
interface DepartmentInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * @param $format
   * @return mixed
   * @throws MissingDataException
   */
  public function getDescription($format = FALSE);

  /**
   * @param $description
   * @param $format
   * @return \Drupal\employee_management\Entity\DepartmentInterface
   */
  public function setDescription($description='', $format = 'basic_html');
  /**
   * @param $load
   * @return EmployeeInterface[]
   * @throws InvalidPluginDefinitionException
   * @throws PluginNotFoundException
   */
  public function getRelatedEmployee($load = FALSE);

  /**
   * Gets the Department creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Department.
   */
  public function getCreatedTime();

  /**
   * Sets the Department creation timestamp.
   *
   * @param int $timestamp
   *   The Department creation timestamp.
   *
   * @return \Drupal\employee_management\Entity\DepartmentInterface
   *   The called Department entity.
   */
  public function setCreatedTime($timestamp);

}
