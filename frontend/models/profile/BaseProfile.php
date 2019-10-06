<?php

namespace frontend\models\profile;

use common\models\User;
use yii\base\Model;

abstract class BaseProfile
{
    /** @var Model */
    protected $form;

    /** @var User */
    protected $user;

    /**
     * BaseProfile constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->setUser($user);
        $this->setForm($this->createForm());
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Model
     */
    abstract public function createForm(): Model;

    /**
     * @return string
     */
    abstract public function getViewName(): string;

}