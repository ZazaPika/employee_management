<?php

namespace Drupal\employee_management\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Employee entities.
 *
 * @ingroup employee_management
 */
interface EmployeeInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

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

  /**
   * Gets the Employee revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Employee revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\employee_management\Entity\EmployeeInterface
   *   The called Employee entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Employee revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Employee revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\employee_management\Entity\EmployeeInterface
   *   The called Employee entity.
   */
  public function setRevisionUserId($uid);

}
