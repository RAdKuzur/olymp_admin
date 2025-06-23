<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $firstname
 * @property string $surname
 * @property string|null $patronymic
 * @property string $phone_number
 * @property string $birthdate
 * @property int $gender
 * @property int $role
 * @property int $active
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function fill(
        $id,
        $email,
        $password,
        $firstname,
        $surname,
        $patronymic,
        $phoneNumber,
        $birthdate,
        $gender,
        $role,
        $active = 1
    )
    {
        $entity = new static();
        $entity->id = $id;
        $entity->email = $email;
        $entity->password = $password;
        $entity->firstname = $firstname;
        $entity->surname = $surname;
        $entity->patronymic = $patronymic;
        $entity->phone_number = $phoneNumber;
        $entity->birthdate = $birthdate;
        $entity->gender = $gender;
        $entity->role = $role;
        $entity->active = $active;

    }
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['patronymic'], 'default', 'value' => null],
            [['email', 'password', 'firstname', 'surname', 'phone_number', 'birthdate', 'gender', 'role', 'active'], 'required'],
            [['password'], 'string'],
            [['birthdate'], 'safe'],
            [['gender', 'role', 'active'], 'integer'],
            [['email', 'firstname', 'surname', 'patronymic', 'phone_number'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'firstname' => 'Firstname',
            'surname' => 'Surname',
            'patronymic' => 'Patronymic',
            'phone_number' => 'Phone Number',
            'birthdate' => 'Birthdate',
            'gender' => 'Gender',
            'role' => 'Role',
            'active' => 'Active',
        ];
    }
    public function getFullFio(){
        return $this->firstname . ' ' . $this->surname . ' ' . $this->patronymic;
    }
    public function beforeValidate()
    {
        $this->active = 1;
        return parent::beforeValidate();
    }
    public function beforeSave($insert){
        $this->password = Yii::$app->security->generatePasswordHash($this->password);
        return parent::beforeSave($insert);
    }
}