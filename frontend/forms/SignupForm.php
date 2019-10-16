<?php

namespace frontend\forms;

use common\models\Institution;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use common\models\User;
use yii\log\Logger;

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
    public $university_id;

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
                    'user_type',
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
            ['email', 'unique', 'skipOnError' => false, 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],
            ['password', 'string', 'min' => 8],
            ['password', 'match', 'pattern' => '/[0-9]+/', 'message' => 'Password should contain at least 1 number.'],
            ['password', 'match', 'pattern' => '/[A-Z]+/', 'message' => 'Password should contain at least 1 character in uppercase'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            ['user_type', 'in', 'range' => array_keys(User::getUserTypes())],
            ['university_id', 'number'],
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

            if ((int)$this->user_type === User::TYPE_INSTITUTION && $this->university_id) {
                $this->saveInstitutionProfile($user);
            }

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

    /**
     * @param User $user
     */
    private function saveInstitutionProfile(User $user): void
    {
        try {
            $profile = new Institution();
            $profile->user_id = $user->getId();
            $profile->university_id = $this->university_id;
            $profile->save();
        } catch (\Exception $e) {
            Yii::getLogger()->log('Error creating profile. ' . $e->getMessage(), Logger::LEVEL_ERROR);
        }
    }
}
