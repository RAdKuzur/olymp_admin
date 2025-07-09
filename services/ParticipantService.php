<?php

namespace app\services;

use app\models\Participant;
use app\repositories\SchoolRepository;
use app\repositories\UserRepository;

class ParticipantService
{
    private UserRepository $userRepository;
    private SchoolRepository $schoolRepository;
    private UserService $userService;
    private SchoolService $schoolService;
    public function __construct(
        UserRepository $userRepository,
        SchoolRepository $schoolRepository,
        UserService $userService,
        SchoolService $schoolService
    )
    {
        $this->userRepository = $userRepository;
        $this->schoolRepository = $schoolRepository;
        $this->userService = $userService;
        $this->schoolService = $schoolService;
    }

    public function transform($data)
    {
        $json = $data['content'];
        $data = json_decode($json, true);
        $models = [];
        foreach ($data['data'] as $item) {
            $model = new Participant();
            $model->id = $item['id'];
            $model->citizenship = $item['citizenship'];
            $model->disability = $item['disability'];
            $model->class = $item['class_number'];
            $model->user_id = $item['user_id'];
            $model->school_id = $item['school_id'];
            $model->userAPI = $this->userService->transformModel(($this->userRepository->getByApiId($model->user_id)));
            $model->schoolAPI = $this->schoolService->transformModel(($this->schoolRepository->getByApiId($model->school_id)));
            $models[] = $model;
        }
        return $models;
    }
    public function transformModel($data)
    {
        $json = $data['content'];
        $item = json_decode($json, true)['data'];
        $model = new Participant();
        $model->id = $item['id'];
        $model->citizenship = $item['citizenship'];
        $model->disability = $item['disability'];
        $model->class = $item['class_number'];
        $model->user_id = $item['user_id'];
        $model->school_id = $item['school_id'];
        $model->userAPI = $this->userService->transformModel(($this->userRepository->getByApiId($model->user_id)));
        $model->schoolAPI = $this->schoolService->transformModel(($this->schoolRepository->getByApiId($model->school_id)));
        return $model;
    }
}