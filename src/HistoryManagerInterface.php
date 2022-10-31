<?php
namespace Drupal\employee_management;

interface HistoryManagerInterface {
  const TABLE = 'event_history';

  const ADD_EVENT = 1;

  const UPDATE_EVENT = 2;

  const DELETE_EVENT = 3;

  const API_CALLBACK_EVENT = 4;

  const EVENTS_LABEL = [
    self::ADD_EVENT => 'Add entry',
    self::UPDATE_EVENT => 'Update entry',
    self::DELETE_EVENT => 'Delete entry',
    self::API_CALLBACK_EVENT => 'Callback API'
  ];
}
