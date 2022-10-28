<?php

namespace Drupal\employee_management\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the Employee entity.
 *
 * @ingroup employee_management
 *
 * @ContentEntityType(
 *   id = "employee",
 *   label = @Translation("Employee"),
 *   handlers = {
 *     "storage" = "Drupal\Core\Entity\Sql\SqlContentEntityStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\employee_management\EmployeeListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\employee_management\Form\EmployeeForm",
 *       "add" = "Drupal\employee_management\Form\EmployeeForm",
 *       "edit" = "Drupal\employee_management\Form\EmployeeForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\employee_management\DefaultRouteProvider",
 *     },
 *     "access" = "Drupal\employee_management\AccessControlHandler",
 *   },
 *   base_table = "employee",
 *   translatable = FALSE,
 *   admin_permission = "administer employee entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "lastname",
 *     "uuid" = "uuid",
 *     "uid" = "uid",
 *     "owner" = "uid",
 *     "langcode" = "langcode",
 *   },
 *   links = {
 *     "canonical" = "/admin/employee/{employee}",
 *     "add-form" = "/admin/employee/add",
 *     "edit-form" = "/admin/employee/{employee}/edit",
 *     "delete-form" = "/admin/employee/{employee}/delete",
 *     "collection" = "/admin/employee",
 *   },
 *   field_ui_base_route = "employee.settings"
 * )
 */
class Employee extends ContentEntityBase implements EmployeeInterface {

  use EntityBaseTrait;
  use EntityChangedTrait;

  /**
   * @return string|null
   */
  public function getLastname() {
    return $this->get('lastname')->value;
  }

  /**
   * @param $lastname
   * @return $this
   */
  public function setLastname($lastname) {
    $this->set('lastname', $lastname);
    return $this;
  }

  /**
   * @return string|null
   */
  public function getFirstname() {
    return $this->get('firstname')->value;
  }

  /**
   * @param $firstname
   * @return $this
   */
  public function setFirstname($firstname) {
    $this->set('firstname', $firstname);
    return $this;
  }

  /**
   * @return string|null
   */
  public function getAddress() {
    return $this->get('address')->value;
  }

  /**
   * @param $address
   * @return $this
   */
  public function setAddress($address) {
    $this->set('address', $address);
    return $this;
  }

  /**
   * @return string|null
   */
  public function getPhone() {
    return $this->get('phone')->value;
  }

  /**
   * @param $phone
   * @return $this
   */
  public function setPhone($phone = '') {
    $this->set('phone', $phone);
    return $this;
  }

  /**
   * @return array
   */
  public function getHobbies() {
    if (!$values = $this->get('hobbies')->getValue())
      return [];
    return array_filter(
      array_map(function ($item) {
      return $item['value'] ?? NULL;
    }, $values));
  }

  /**
   * @param $hobbies
   * @return $this
   */
  public function setHobbies($hobbies = []) {
    $this->set('hobbies', $hobbies);
    return $this;
  }

  /**
   * @param $load
   * @return DepartmentInterface|NULL
   */
  public function getDepartment($load  = FALSE) {
    $id = $this->get('department')->target_id;
    if (!$load || !$id)
      return $id;
    /** @var \Drupal\Core\Entity\Plugin\DataType\EntityReference $entityReference */
    $reference =  $this->get('department')->first()->get('entity');
    return $reference->getTarget()->getValue();
  }

  /**
   * @param $id
   * @return $this
   */
  public function setDepartment($id) {
    $this->set('department', $id);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);
    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['lastname'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Lastname'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -1,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['firstname'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Firstname'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -1,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['address'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Address'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['phone'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Phone number'))
      ->setSettings([
        'max_length' => 20,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['hobbies'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Hobbies'))
      ->setCardinality(-1)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['department'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Department'))
      ->setSetting('target_type', 'department')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 0,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'));

    return $fields;
  }

}
