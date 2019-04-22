<?php

namespace frontend\models\profile;

use common\models\User;
use yii\base\Model;

abstract class BaseProfile
{
    /** @var Model */
    protected $form;

    /**
     * BaseProfile constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $attributes = $user->profile ? $user->profile->getAttributes() : [];

        $this->setForm($this->createForm($user->getId(), $attributes));
    }

    /**
     * @param Model $form
     */
    protected function setForm(Model $form): void
    {
        $this->form = $form;
    }

    /**
     * @return Model
     */
    public function getForm(): Model
    {
        return $this->form;
    }

    /**
     * @param int $userId
     * @param array $attributes
     * @return Model
     */
    abstract public function createForm(int $userId, array $attributes): Model;

    /**
     * @return string
     */
    abstract public function getViewName(): string;

}