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
   * @return string|null
   */
  public function getLastname();
  /**
   * @param $lastname
   * @return $this
   */
  public function setLastname($lastname);
  /**
   * @return string|null
   */
  public function getFirstname();
  /**
   * @param $firstname
   * @return $this
   */
  public function setFirstname($firstname);
  /**
   * @return string|null
   */
  public function getAddress();
  /**
   * @param $address
   * @return $this
   */
  public function setAddress($address);
  /**
   * @return string|null
   */
  public function getPhone();
  /**
   * @param $phone
   * @return $this
   */
  public function setPhone($phone = '');
  /**
   * @return array
   */
  public function getHobbies();
  /**
   * @param $hobbies
   * @return $this
   */
  public function setHobbies($hobbies = []);
  /**
   * @param $load
   * @return mixed
   */
  public function getDepartment($load  = FALSE);
  /**
   * @param $id
   * @return $this
   */
  public function setDepartment($id);

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
