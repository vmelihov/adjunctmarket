<?php

namespace frontend\forms;

use common\models\Proposal;
use common\models\User;
use common\models\Vacancy;
use common\src\helpers\FileHelper;
use common\src\helpers\Helper;
use yii\base\Exception;
use yii\base\Model;
use yii\web\UploadedFile;

class ProposalForm extends Model
{
    public $id;
    public $letter;
    public $state;
    public $adjunct_id;
    public $vacancy_id;
    /**
     * @var UploadedFile[]
     */
    public $files;
    public $attaches;

    public function rules(): array
    {
        return [
            [['adjunct_id', 'vacancy_id', 'state', 'letter'], 'required'],
            [['id', 'state', 'adjunct_id', 'vacancy_id'], 'integer'],
            [['letter'], 'string', 'max' => 4000],
            [['attaches'], 'safe'],
            [['adjunct_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['adjunct_id' => 'id']],
            [['vacancy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vacancy::class, 'targetAttribute' => ['vacancy_id' => 'id']],
            [['files'], 'file', 'skipOnEmpty' => true, 'maxFiles' => 10],
        ];
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function save(): bool
    {
        if (!$adjunct = Helper::getUserIdentity()) {
            return false;
        }

        if (!$this->validate()) {
            return false;
        }

        if (!$this->upload($adjunct)) {
            return false;
        }

        if ($this->id) {
            $proposal = Proposal::findOne($this->id);
        } else {
            $proposal = new Proposal();
        }

        $proposal->letter = htmlspecialchars($this->letter);
        $proposal->adjunct_id = $adjunct->getId();
        $proposal->vacancy_id = $this->vacancy_id;
        $proposal->state = $this->state;
        $proposal->attaches = $this->attaches;

        if (!$proposal->save()) {
            $this->addErrors($proposal->getErrors());

            return false;
        }

        $this->id = $proposal->id;

        return true;
    }

    /**
     * @param User $user
     * @return bool
     * @throws Exception
     */
    public function upload(User $user): bool
    {
        $files = UploadedFile::getInstances($this, 'files');
        $newFiles = [];

        foreach ($files as $file) {

            $fileName = $this->normalizeFileName($file->baseName) . '.' . $file->extension;
            $folder = FileHelper::getVacancyFolder($user->id, $this->vacancy_id);

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

    public function normalizeFileName(string $name): string
    {
        $result = preg_replace('/\s+/', '_', $name);
        $result = preg_replace('/\W/', '', $result);

        return $result;
    }

    /**
     * @param Proposal $proposal
     * @return ProposalForm
     */
    public static function createByProposal(Proposal $proposal): self
    {
        $form = new self;
        $form->setAttributes($proposal->getAttributes());

        return $form;
    }

    /**
     * @return array
     */
    public function getAttachesArray(): array
    {
        return json_decode($this->attaches, true) ?? [];
    }

    /**
     * @param array $newFiles
     */
    protected function mergeFiles(array $newFiles): void
    {
        $this->attaches = json_encode(array_merge($this->getAttachesArray(), $newFiles));
    }
}