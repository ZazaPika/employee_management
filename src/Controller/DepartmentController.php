<?php

namespace Drupal\employee_management\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\employee_management\Entity\DepartmentInterface;
use Drupal\employee_management\HistoryManagerInterface;
use Drupal\employee_management\RestCallbackHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DepartmentController.
 *
 *  Returns responses for Department routes.
 */
class DepartmentController extends ControllerBase implements ContainerInjectionInterface {
  /**
   * @var RestCallbackHandlerInterface
   */
  protected $callbackHandler;
  /**
   * @var HistoryManagerInterface
   */
  protected $historyManager;

  /**
   * @param RestCallbackHandlerInterface $callback_handler
   * @param HistoryManagerInterface $history_manager
   */
  public function __construct(RestCallbackHandlerInterface $callback_handler , HistoryManagerInterface $history_manager){
    $this->callbackHandler = $callback_handler;
    $this->historyManager = $history_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('api.handler'),
      $container->get('event_history.manager')
    );
  }

  /**
   * @param $department
   * @param Request $request
   * @return JsonResponse
   */
  public function getDepartment($department = NULL, Request $request){
    $response = new JsonResponse();
    $entity = $this->callbackHandler->getDepartmentById($department);
    $response->setStatusCode($entity ? 200 : 204);
    if($entity){
      $response->setData($entity->toArray(TRUE));
    }
    $this->historyManager->insertEntry(HistoryManagerInterface::API_CALLBACK_EVENT,
      ['path' => $request->getPathInfo()] + $request->headers->all());
    return $response;
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function getDepartmentList(Request $request){
    $response = new JsonResponse();
    $departments = $this->callbackHandler->getDepartments();
    $response->setStatusCode($departments ? 200 : 204);
    if($departments){
      $response->setData([
        'numfound' => count($departments),
        'entries' => array_map(function (DepartmentInterface $department) {
          return $department->toArray();
        },$departments)]);
    }
    $this->historyManager->insertEntry(HistoryManagerInterface::API_CALLBACK_EVENT,
      ['path' => $request->getPathInfo()] + $request->headers->all());
    return $response;
  }
}
