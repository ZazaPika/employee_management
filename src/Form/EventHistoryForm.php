<?php
namespace Drupal\employee_management\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\employee_management\HistoryManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class EventHistoryForm extends FormBase {

  /**
   * @var HistoryManagerInterface
   */
  protected $historyManager;

  /** @var Request */
  protected $request;

  /**
   * @param HistoryManagerInterface $history_manager
   * @param Request $request
   */
  public function __construct(HistoryManagerInterface $history_manager, Request $request) {
    $this->historyManager = $history_manager;
    $this->request = $request;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('event_history.manager'),
      $container->get('request_stack')->getCurrentRequest()
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'event_history_form';
  }
  /**
   * @param $string
   * @return bool|\DateTime
   */
  protected function extractDate($string) {
    if(!$string || empty($string)) {
      return NULL;
    }
    return ($date = \DateTime::createFromFormat('Y-m-d', $string)) ? $date : NULL;
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    if($from = $this->extractDate($this->request->get('from'))) {
      $from->setTime(0,0);
    }
    if($to = $this->extractDate($this->request->get('to'))){
      $to->setTime(23, 59, 59);
    }
    $form += [
      'filters' => [
        '#type' => 'details',
        '#open' => TRUE,
        '#title' => $this->t('Filters'),
        'from' => [
          '#type' => 'date',
          '#title' => $this->t('From'),
          '#default_value' => $from ? $from->format('Y-m-d') : '',
        ],
        'to' => [
          '#type' => 'date',
          '#title' => $this->t('To'),
          '#default_value' => $to ? $to->format('Y-m-d') : '',
        ],
        'submit' => [
          '#type' => 'submit',
          '#value' => t('Filter'),
        ]
      ],
      'list' => [
        '#theme' => 'table',
        '#header' => [
          'date' => $this->t('Date'),
          'type' => $this->t('Type'),
          'user' => $this->t('User'),
          'context' => $this->t('Context'),
        ],
        '#rows' => $this->historyManager->getEventBetween($from, $to),
      ],
      'pager' => [
        '#type' => 'pager'
      ]

    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('from') && !($from = $this->extractDate($form_state->getValue('from')))) {
      $form_state->setError($form['filters']['from'], 'Invalid date.');
    }
    if ($form_state->getValue('to') && !($to = $this->extractDate($form_state->getValue('to')))) {
      $form_state->setError($form['filters']['to'], 'Invalid date.');
    }
    if ((isset($from) && isset($to)) && $to->getTimestamp() < $from->getTimestamp()) {
      $form_state->setError($form['filters']['to'], 'Invalid date range.');
    }
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $query = [
      'from' => trim($form_state->getValue('from')),
      'to' => trim($form_state->getValue('to')),
    ];
    $form_state->setRedirect('rh.history', [], ['query' => array_filter($query)]);
  }
}
