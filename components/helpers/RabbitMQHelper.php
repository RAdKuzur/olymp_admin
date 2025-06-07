<?php

namespace app\components\helpers;

class RabbitMQHelper
{
    public const CREATE = 'create';
    public const UPDATE = 'update';
    public const DELETE = 'delete';
    public const EVENT_SERVICE = 'event';
    public const NOTIFICATION_SERVICE = 'notification';
    public const APPLICATION_SERVICE = 'application';
    public const RESULT_SERVICE = 'result';
}