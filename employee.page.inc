<?php

/**
 * @file
 * Contains employee.page.inc.
 *
 * Page callback for Employee entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Employee templates.
 *
 * Default template: employee.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_employee(array &$variables) {
  // Fetch Employee Entity Object.
  $employee = $variables['elements']['#employee'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
