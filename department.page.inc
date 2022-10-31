<?php

/**
 * @file
 * Contains department.page.inc.
 *
 * Page callback for Department entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Department templates.
 *
 * Default template: department.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_department(array &$variables) {
  // Fetch Department Entity Object.
  $department = $variables['elements']['#department'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
