<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property int $chat_id
 * @property int $author_user_id
 * @property string $message
 * @property int $created
 * @property int $updated
 * @property int $read
 *
 * @property User $author
 * @property Chat $chat
 */
class Message extends ActiveRecord
{
    public const STATUS_UNREAD = 0;
    public const STATUS_READ = 1;

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['chat_id', 'author_user_id', 'message'], 'required'],
            [['chat_id', 'author_user_id', 'created', 'updated', 'read'], 'integer'],
            [['message'], 'string', 'max' => 255],
            [
                ['author_user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['author_user_id' => 'id']
            ],
            [
                ['chat_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Chat::class,
                'targetAttribute' => ['chat_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'chat_id' => 'chat ID',
            'author_user_id' => 'Author User ID',
            'message' => 'Message',
            'created' => 'Created',
            'updated' => 'Updated',
            'read' => 'Read',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getChat(): ActiveQuery
    {
        return $this->hasOne(Chat::class, ['id' => 'chat_id']);
    }
}
