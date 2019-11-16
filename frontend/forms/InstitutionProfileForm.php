<?php

namespace frontend\forms;

use common\models\Institution;
use common\models\University;
use common\models\User;
use yii\base\Exception;
use yii\base\Model;
use yii\base\UserException;
use yii\web\UploadedFile;

class InstitutionProfileForm extends Model
{
    public $id;
    public $user_id;
    public $title;
    public $description;
    public $university_id;
    public $position;
    public $first_name;
    public $last_name;
    public $email;
    public $new_password;
    public $repeat_password;
    public $image_file;

    /** @var UploadedFile */
    public $uploadedFile;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'university_id', 'first_name', 'last_name', 'email'], 'required'],
            [['title', 'description', 'position'], 'trim'],
            [['id', 'user_id'], 'number'],
            [['university_id'], 'exist', 'skipOnError' => true, 'targetClass' => University::class, 'targetAttribute' => ['university_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],

            ['email', 'email'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['first_name', 'last_name'], 'trim'],

            ['new_password', 'string', 'skipOnEmpty' => true, 'min' => 8],
            ['new_password', 'match', 'skipOnEmpty' => true, 'pattern' => '/[0-9]+/', 'message' => 'Password should contain at least 1 number.'],
            ['new_password', 'match', 'skipOnEmpty' => true, 'pattern' => '/[A-Z]+/', 'message' => 'Password should contain at least 1 character in uppercase'],
            ['repeat_password', 'compare', 'compareAttribute' => 'new_password', 'message' => "Passwords don't match"],

            [['image_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * @return bool
     * @throws UserException
     * @throws Exception
     */
    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $saveUserResult = $this->saveUser();

        $saveInstitutionResult = $this->saveInstitution();

        return $saveUserResult && $saveInstitutionResult;
    }

    /**
     * @return bool
     * @throws UserException
     * @throws Exception
     */
    private function saveUser(): bool
    {
        $user = User::findOne($this->user_id);

        if (!$user) {
            throw new UserException('User undefined. id ' . $this->user_id);
        }

        return $user->saveByProfile($this);
    }

    /**
     * @return bool
     */
    private function saveInstitution(): bool
    {
        if ($this->id) {
            $institution = Institution::findOne($this->id);
        }

        if (!isset($institution)) {
            $institution = new Institution();
        }

        $institution->user_id = $this->user_id;
        $institution->title = $this->title;
        $institution->description = $this->description;
        $institution->university_id = $this->university_id;
        $institution->position = $this->position;

        if (!$institution->save()) {
            $this->addErrors($institution->getErrors());

            return false;
        }

        return true;
    }

}