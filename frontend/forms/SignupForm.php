<?php

namespace frontend\forms;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $user_type;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $password_repeat;
    public $confirm;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'first_name',
                    'last_name',
                    'email',
                    'password',
                    'password_repeat',
                ],
                'required'
            ],
            ['first_name', 'trim'],
            ['last_name', 'trim'],
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],
            ['password', 'string', 'min' => 8],
            ['password', 'match', 'pattern' => '/[0-9]+/', 'message' => 'Password should contain at least 1 number.'],
            ['password', 'match', 'pattern' => '/[A-Z]+/', 'message' => 'Password should contain at least 1 character in uppercase'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            ['user_type', 'in', 'range' => array_keys(User::getUserTypes())],
            ['confirm', 'compare', 'compareValue' => 1, 'message' => 'You must confirm'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     */
    public function signup(): ?User
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->first_name = $this->first_name;
        $user->user_type = $this->user_type;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        if (!empty($this->password)) {
            $user->setPassword($this->password);
        }
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        if ($user->save()) {
            $this->sendEmail($user);

            return $user;
        }

        return null;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function sendEmail(User $user): bool
    {
        if ($user === null) {
            return false;
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
