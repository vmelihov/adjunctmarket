<?php
namespace common\models;

use common\src\helpers\UserImageHelper;
use frontend\forms\AdjunctProfileForm;
use frontend\forms\InstitutionProfileForm;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_type
 * @property string $first_name
 * @property string $last_name
 * @property string $password write-only password
 * @property string $image
 *
 * @property Adjunct|Institution $profile
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const STATUS_DELETED = 0;
    public const STATUS_INACTIVE = 9;
    public const STATUS_ACTIVE = 10;

    public const SEX_MALE = 1;
    public const SEX_FEMALE = 2;

    public const TYPE_ADJUNCT = 1;
    public const TYPE_INSTITUTION = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * @return null|ActiveQuery
     */
    public function getProfile(): ?ActiveQuery
    {
        if ($this->user_type === self::TYPE_ADJUNCT) {
            return $this->hasOne(Adjunct::class, ['user_id' => 'id']);
        }

        if ($this->user_type === self::TYPE_INSTITUTION) {
            return $this->hasOne(Institution::class, ['user_id' => 'id']);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['email', 'email'],
            ['email', 'unique'],
            [['first_name', 'last_name'], 'string'],
            [['password_reset_token'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => array_keys(self::getStatuses())],
            ['user_type', 'in', 'range' => array_keys(self::getUserTypes())],
        ];
    }

    /**
     * @return array
     */
    public static function getUserTypes(): array
    {
        return [
            self::TYPE_ADJUNCT => 'adjunct',
            self::TYPE_INSTITUTION => 'institution',
        ];
    }

    /**
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_DELETED => 'deleted',
            self::STATUS_INACTIVE => 'inactive',
            self::STATUS_ACTIVE => 'active',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail(string $email): ?User
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @param string $newEmail
     * @return bool
     */
    public function isEmailUniqueForOtherUsers(string $newEmail): bool
    {
        return !static::find()->where('id != :id and email = :email', ['id' => $this->getId(), 'email' => $newEmail])->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token): ?self
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword($password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws Exception
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws Exception
     */
    public function generatePasswordResetToken(): void
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * @throws Exception
     */
    public function generateEmailVerificationToken(): void
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken(): void
    {
        $this->password_reset_token = null;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return bool
     */
    public function isInstitution(): bool
    {
        return $this->user_type === self::TYPE_INSTITUTION;
    }

    /**
     * @return bool
     */
    public function isAdjunct(): bool
    {
        return $this->user_type === self::TYPE_ADJUNCT;
    }

    /**
     * @param Model|InstitutionProfileForm|AdjunctProfileForm $profile
     * @return bool
     * @throws Exception
     */
    public function saveByProfile(Model $profile): bool
    {
        $needSave = false;

        if ($profile->email && $this->email != $profile->email) {
            if ($this->isEmailUniqueForOtherUsers($profile->email)) {
                $this->email = $profile->email;
                $needSave = true;
            } else {
                $profile->addError('email', 'This email address has already been taken.');

                return false;
            }
        }

        if ($profile->first_name && $this->first_name != $profile->first_name) {
            $this->first_name = $profile->first_name;
            $needSave = true;
        }

        if ($profile->last_name && $this->last_name != $profile->last_name) {
            $this->last_name = $profile->last_name;
            $needSave = true;
        }

        if ($profile->new_password) {
            if (!$profile->repeat_password) {
                $profile->addError('repeat_password', 'Please repeat password');

                return false;
            }

            if ($profile->new_password === $profile->repeat_password) {
                $this->setPassword($profile->new_password);
                $needSave = true;
            } else {
                $profile->addError('repeat_password', 'Password dont match');

                return false;
            }
        }

        if ($profile->uploadedFile) {
            $fileName = UserImageHelper::generateImageName($this) . '.' . $profile->uploadedFile->extension;
            $folder = UserImageHelper::getUserFolder($this->getId());

            if ($this->image) {
                UserImageHelper::unlinkUserImage($this);
            }

            if ($profile->uploadedFile->saveAs($folder . '/' . $fileName)) {
                $profile->uploadedFile = null;
                $this->image = $fileName;
                $needSave = true;
            } else {
                $profile->addError('image_file', 'Error saving image');

                return false;
            }
        }

        if ($needSave && !$this->save()) {
            $profile->addErrors($this->getErrors());

            return false;
        }

        return true;
    }
}
