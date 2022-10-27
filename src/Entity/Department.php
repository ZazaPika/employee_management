<?php

namespace Drupal\employee_management\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\RevisionLogEntityTrait;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the Department entity.
 *
 * @ingroup employee_management
 *
 * @ContentEntityType(
 *   id = "department",
 *   label = @Translation("Department"),
 *   handlers = {
 *     "storage" = "Drupal\employee_management\DepartmentStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\employee_management\DepartmentListBuilder",
 *     "views_data" = "Drupal\employee_management\Entity\DepartmentViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\employee_management\Form\DepartmentForm",
 *       "add" = "Drupal\employee_management\Form\DepartmentForm",
 *       "edit" = "Drupal\employee_management\Form\DepartmentForm",
 *       "delete" = "Drupal\employee_management\Form\DepartmentDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\employee_management\DepartmentHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\employee_management\DepartmentAccessControlHandler",
 *   },
 *   base_table = "department",
 *   revision_table = "department_revision",
 *   revision_data_table = "department_field_revision",
 *   show_revision_ui = TRUE,
 *   translatable = FALSE,
 *   admin_permission = "administer department entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "uid",
 *     "owner" = "uid",
 *     "langcode" = "langcode",
 *   },
*   revision_metadata_keys = {
*     "revision_user" = "revision_uid",
*     "revision_created" = "revision_timestamp",
*     "revision_log_message" = "revision_log"
*   },
 *   links = {
 *     "canonical" = "/department/{department}",
 *     "add-form" = "/admin/department/add",
 *     "edit-form" = "/admin/department/{department}/edit",
 *     "delete-form" = "/admin/department/{department}/delete",
 *     "version-history" = "/admin/department/{department}/revisions",
 *     "revision" = "/admin/department/{department}/revisions/{department_revision}/view",
 *     "revision_revert" = "/admin/department/{department}/revisions/{department_revision}/revert",
 *     "revision_delete" = "/admin/department/{department}/revisions/{department_revision}/delete",
 *     "collection" = "/department",
 *   },
 *   field_ui_base_route = "department.settings"
 * )
 */
class Department extends ContentEntityBase implements DepartmentInterface {

  use EntityBaseTrait;
  use EntityChangedTrait;
  use RevisionLogEntityTrait;

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);
    $fields += static::revisionLogBaseFieldDefinitions($entity_type);
    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Department entity.'))
      ->setRevisionable(TRUE)
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
      ->setRevisionable(TRUE)
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
      ->setRevisionable(TRUE)
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
