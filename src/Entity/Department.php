<?php

namespace Drupal\employee_management\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EditorialContentEntityBase;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

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
class Department extends EditorialContentEntityBase implements DepartmentInterface {

  use EntityBaseTrait;
  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
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

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
