<?php

namespace Drupal\employee_management\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EditorialContentEntityBase;
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
 *     "storage" = "Drupal\employee_management\EmployeeStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\employee_management\EmployeeListBuilder",
 *     "views_data" = "Drupal\employee_management\Entity\EmployeeViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\employee_management\Form\EmployeeForm",
 *       "add" = "Drupal\employee_management\Form\EmployeeForm",
 *       "edit" = "Drupal\employee_management\Form\EmployeeForm",
 *       "delete" = "Drupal\employee_management\Form\EmployeeDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\employee_management\EmployeeHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\employee_management\EmployeeAccessControlHandler",
 *   },
 *   base_table = "employee",
 *   revision_table = "employee_revision",
 *   revision_data_table = "employee_field_revision",
 *   show_revision_ui = TRUE,
 *   translatable = FALSE,
 *   admin_permission = "administer employee entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
*   revision_metadata_keys = {
*     "revision_user" = "revision_uid",
*     "revision_created" = "revision_timestamp",
*     "revision_log_message" = "revision_log"
*   },
 *   links = {
 *     "canonical" = "/employee/{employee}",
 *     "add-form" = "/admin/employee/add",
 *     "edit-form" = "/admin/employee/{employee}/edit",
 *     "delete-form" = "/admin/employee/{employee}/delete",
 *     "version-history" = "/admin/employee/{employee}/revisions",
 *     "revision" = "/admin/employee/{employee}/revisions/{employee_revision}/view",
 *     "revision_revert" = "/admin/employee/{employee}/revisions/{employee_revision}/revert",
 *     "revision_delete" = "/admin/employee/{employee}/revisions/{employee_revision}/delete",
 *     "collection" = "/employee",
 *   },
 *   field_ui_base_route = "employee.settings"
 * )
 */
class Employee extends EditorialContentEntityBase implements EmployeeInterface {

  use EntityBaseTrait;
  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);
    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Employee entity.'))
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

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
