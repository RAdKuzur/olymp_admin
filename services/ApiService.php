<?php
namespace app\services;
use Yii;
use yii\base\Component;
use yii\httpclient\Client;
use yii\web\HttpException;
use yii\web\Response;

class ApiService extends Component
{
    /**
     * @var string Базовый URL API
     */
    public $baseUrl;

    /**
     * @var int Таймаут соединения в секундах
     */
    public $timeout = 30;

    /**
     * @var Client HTTP клиент
     */
    private $_client;

    /**
     * @var array Заголовки по умолчанию
     */
    public $defaultHeaders = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ];

    /**
     * Инициализация сервиса
     */
    public function init()
    {
        parent::init();

        if (empty($this->baseUrl)) {
            throw new \InvalidArgumentException('Base URL must be set');
        }

        $this->_client = new Client([
            'baseUrl' => $this->baseUrl,
            'requestConfig' => [
                'format' => Client::FORMAT_JSON
            ],
            'responseConfig' => [
                'format' => Client::FORMAT_JSON
            ],
        ]);
    }

    /**
     * Отправка GET запроса
     *
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return array
     * @throws HttpException
     */
    public function get($url, $params = [], $headers = [])
    {
        return $this->sendRequest('GET', $url, $params, $headers);
    }

    /**
     * Отправка POST запроса
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return array
     * @throws HttpException
     */
    public function post($url, $data = [], $headers = [])
    {
        return $this->sendRequest('POST', $url, $data, $headers);
    }

    /**
     * Отправка PUT запроса
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return array
     * @throws HttpException
     */
    public function put($url, $data = [], $headers = [])
    {
        return $this->sendRequest('PUT', $url, $data, $headers);
    }

    /**
     * Отправка DELETE запроса
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return array
     * @throws HttpException
     */
    public function delete($url, $data = [], $headers = [])
    {
        return $this->sendRequest('DELETE', $url, $data, $headers);
    }

    /**
     * Отправка запроса к API
     *
     * @param string $method HTTP метод
     * @param string $url URL endpoint
     * @param array $data Данные для отправки
     * @param array $headers Дополнительные заголовки
     * @return array
     * @throws HttpException
     */
    protected function sendRequest($method, $url, $data = [], $headers = [])
    {
        $request = $this->_client->createRequest()
            ->setMethod($method)
            ->setUrl($url)
            ->setHeaders(array_merge($this->defaultHeaders, $headers))
            ->setOptions([
                'timeout' => $this->timeout,
                'sslVerifyPeer' => false,
                'sslVersion' => 6,
            ]);

        if ($method === 'GET') {
            $request->setData($data);
        } else {
            $request->setContent(json_encode($data));
        }
        $response = $request->send();

        if (!$response->isOk) {
            Yii::$app->session->setFlash('error', $response->getContent());
        }
        return [
            'content' => $response->content,
            'cookies' => $response->getCookies()
        ];
    }
    public function answer($data, $message = null, $success = true, $code = 200)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $response = [
            'success' => $success,
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'timestamp' => time(),
        ];

        \Yii::$app->response->statusCode = $code;
        return $response;
    }
}