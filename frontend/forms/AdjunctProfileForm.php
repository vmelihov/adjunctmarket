<?php

namespace frontend\forms;

use common\models\Adjunct;
use common\models\User;
use common\src\helpers\FileHelper;
use yii\base\Exception;
use yii\base\Model;
use yii\base\UserException;
use yii\web\UploadedFile;

class AdjunctProfileForm extends Model
{
    public $id;
    public $user_id;
    public $title;
    public $description;
    public $age;
    public $sex;
    public $teaching_experience_type_id;
    public $teaching_experience;
    public $education_id;
    public $teach_type_id;
    public $teach_locations;
    public $teach_time_id;
    public $teach_period_id;
    public $specialities;
    public $confirm;
    public $phone;
    public $location_id;
    public $linledin;
    public $facebook;
    public $whatsapp;
    public $documents;

    public $first_name;
    public $last_name;
    public $email;
    public $new_password;
    public $repeat_password;
    public $image_file;
    public $doc_files;

    /** @var UploadedFile */
    public $uploadedFile;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id'], 'required'],
            [['documents'], 'safe'],
            [
                [
                    'title',
                    'description',
                    'specialities',
                    'teach_locations',
                    'phone',
                    'linledin',
                    'facebook',
                    'whatsapp',
                    'first_name',
                    'last_name',
                    'email',
                    'new_password',
                    'repeat_password',
                ],
                'trim'
            ],
            [
                [
                    'id',
                    'user_id',
                    'teaching_experience_type_id',
                    'education_id',
                    'teach_type_id',
                    'teach_time_id',
                    'teach_period_id',
                    'location_id',
                ],
                'number'
            ],
        ];
    }

    /**
     * @return bool
     * @throws Exception
     * @throws UserException
     */
    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $saveProfileResult = $this->saveAdjunct();
        $saveUserResult = $this->saveUser();

        return $saveUserResult && $saveProfileResult;
    }

    /**
     * @param mixed $array
     * @return string|null
     */
    protected function getArrayAsString($array): ?string
    {
        if ($array) {
            return json_encode($array);
        }

        return null;
    }

    /**
     * @return bool
     * @throws UserException
     * @throws Exception
     */
    protected function saveUser(): bool
    {
        $user = User::findOne($this->user_id);

        if (!$user) {
            throw new UserException('User undefined. id ' . $this->user_id);
        }

        return $user->saveByProfile($this);
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected function saveAdjunct(): bool
    {
        if ($this->id) {
            $adjunct = Adjunct::findOne($this->id);
        }

        if (!isset($adjunct)) {
            $adjunct = new Adjunct();
        }

        if (!$this->uploadDocuments($adjunct)) {
            return false;
        }

        $adjunct->user_id = $this->user_id;
        $adjunct->title = $this->title;
        $adjunct->description = $this->description;
        $adjunct->education_id = $this->education_id;
        $adjunct->teach_type_id = $this->teach_type_id;
        $adjunct->teach_time_id = $this->teach_time_id;
        $adjunct->teach_period_id = $this->teach_period_id;
        $adjunct->teaching_experience_type_id = $this->teaching_experience ? $this->teaching_experience_type_id : null;
        $adjunct->teach_locations = $this->getArrayAsString(explode(' ', $this->teach_locations));
        $adjunct->specialities = $this->getArrayAsString(explode(' ', $this->specialities));

        $adjunct->phone = $this->phone;
        $adjunct->location_id = $this->location_id;
        $adjunct->linledin = $this->linledin;
        $adjunct->facebook = $this->facebook;
        $adjunct->whatsapp = $this->whatsapp;
        $adjunct->documents = json_encode($this->documents);

        $result = $adjunct->save();

        $this->id = $adjunct->id;

        return $result;
    }

    /**
     * @param Adjunct $adjunct
     * @return bool
     * @throws Exception
     */
    protected function uploadDocuments(Adjunct $adjunct): bool
    {
        $user = $adjunct->user;
        $newFiles = [];
        $files = UploadedFile::getInstances($this, 'doc_files');

        foreach ($files as $file) {

            $fileName = FileHelper::prepareDocumentFileName($file->baseName, $file->extension);
            $folder = FileHelper::getDocumentFolder($user->getId());

            if ($file->saveAs($folder . '/' . $fileName)) {
                $newFiles[] = $fileName;
            } else {
                $this->addError('files', 'File upload error: ' . $file->name);
            }
        }

        if ($newFiles) {
            $this->mergeFiles($newFiles);
        }

        return true;
    }

    /**
     * @param array $newFiles
     */
    protected function mergeFiles(array $newFiles): void
    {
        $this->documents = array_unique(array_merge($this->getDocuments(), $newFiles));
    }

    /**
     * @return array
     */
    public function getDocuments(): array
    {
        return $this->documents ?? [];
    }

}
