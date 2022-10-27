<?php

namespace Drupal\employee_management\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Department entities.
 *
 * @ingroup employee_management
 */
interface DepartmentInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

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

  /**
   * Gets the Department revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Department revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\employee_management\Entity\DepartmentInterface
   *   The called Department entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Department revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Department revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\employee_management\Entity\DepartmentInterface
   *   The called Department entity.
   */
  public function setRevisionUserId($uid);

}
