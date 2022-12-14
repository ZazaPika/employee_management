<?php

namespace Drupal\employee_management\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\file\FileInterface;

/**
 * Defines the Department entity.
 *
 * @ingroup employee_management
 *
 * @ContentEntityType(
 *   id = "department",
 *   label = @Translation("Department"),
 *   handlers = {
 *     "storage" = "Drupal\employee_management\EntityStorage",
 *     "view_builder" = "Drupal\employee_management\DepartmentViewBuilder",
 *     "list_builder" = "Drupal\employee_management\DepartmentListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\employee_management\Form\DepartmentForm",
 *       "add" = "Drupal\employee_management\Form\DepartmentForm",
 *       "edit" = "Drupal\employee_management\Form\DepartmentForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\employee_management\DefaultRouteProvider",
 *     },
 *     "access" = "Drupal\employee_management\AccessControlHandler",
 *   },
 *   base_table = "department",
 *   translatable = FALSE,
 *   admin_permission = "administer department entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "uid",
 *     "owner" = "uid",
 *     "langcode" = "langcode",
 *   },
 *   links = {
 *     "canonical" = "/admin/human-resources/department/{department}",
 *     "add-form" = "/admin/human-resources/department/add",
 *     "edit-form" = "/admin/human-resources/department/{department}/edit",
 *     "delete-form" = "/admin/human-resources/department/{department}/delete",
 *     "collection" = "/admin/human-resources/department",
 *   },
 *   field_ui_base_route = "department.settings"
 * )
 */
class Department extends ContentEntityBase implements DepartmentInterface {

  use EntityBaseTrait;
  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public function getDescription($format = FALSE){
    return $format ? $this->get('description')->first()->getValue() : $this->get('description')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setDescription($description='', $format = 'basic_html'){
    $this->set('created', ['value' => $description, 'format' => $format]);
    return $this;
  }

  /**
   * @param $load
   * @return FileInterface|null
   */
  public function getImage($load = FALSE) {
    $id = $this->get('image')->target_id;
    if (!$load || !$id)
      return $id;
    /** @var \Drupal\Core\Entity\Plugin\DataType\EntityReference $entityReference */
    $reference =  $this->get('image')->first()->get('entity');
    return $reference->getTarget()->getValue();
  }

  /**
   * {@inheritdoc}
   */
  public function getRelatedEmployee($load = FALSE) {
    $storage = $this->entityTypeManager()->getStorage('employee');
    if ($this->isNew())
      return [];
    $query = $storage->getQuery();
    $ids = $query->condition('department', $this->id())->execute();
    return $load ? $storage->loadMultiple($ids) : $ids;
  }

  /**
   * {@inheritdoc}
   */
  public function toArray($full = FALSE) {
    $image = $this->getImage(TRUE);
    if (!$full) {
      return [
        'id' => (int)$this->id(),
        'name' => $this->label(),
        'image' => $image ? $image->createFileUrl(FALSE) : NULL,
        'employees' => count($this->getRelatedEmployee())
      ];
    }
    return [
      'id' => (int)$this->id(),
      'name' => $this->label(),
      'image' => $image ? $image->createFileUrl(FALSE) : NULL,
      'employees' => array_map(function (EmployeeInterface $employee) {
        return $employee->toArray(FALSE);
      }, $this->getRelatedEmployee(TRUE))
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);
    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Department entity.'))
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

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Department.'))
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

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'text_default',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'text_textfield',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['image'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Image'))
      ->setDescription(t('The picture of the Department.'))
      ->setSettings([
        'alt_field_required' => FALSE,
        'file_extensions' => 'png gif jpg jpeg',
      ])
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'default',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'label' => 'hidden',
        'type' => 'image_image',
        'weight' => 0,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
