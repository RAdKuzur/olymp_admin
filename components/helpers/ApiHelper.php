<?php

namespace app\components\helpers;

class ApiHelper
{
    public const STATUS_OK = 200;
    public const STATUS_NO_CONTENT = 204;
    public const STATUS_BAD_REQUEST = 400;
    public const STATUS_UNAUTHORIZED = 401;
    public const STATUS_NOT_FOUND = 404;
    public const AUTH_URL_API = 'http://172.16.1.39:8181/users/login';
    public const USER_URL_API = 'http://172.16.1.39:8181/users';
    public const EVENT_UPL_API = 'http://172.16.1.39:8080/events';
}