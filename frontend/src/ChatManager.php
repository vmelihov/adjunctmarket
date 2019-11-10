<?php

namespace frontend\src;

use common\models\Chat;
use common\models\Message;
use common\models\User;
use Exception;
use RuntimeException;

class ChatManager
{
    /** @var User */
    protected $user;

    /**
     * ChatManager constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->setUser($user);
    }

    /**
     * @return array
     */
    public function getChatList(): array
    {
        $user = $this->getUser();

        return Chat::findListByUser($user);
    }

    /**
     * @param int $param
     * @return Chat
     * @throws Exception
     */
    public function create(int $param): Chat
    {
        $user = $this->getUser();

        if ($user->isAdjunct()) {
            $institutionId = $param;
            $adjunctId = $user->getId();
        } elseif ($user->isInstitution()) {
            $adjunctId = $param;
            $institutionId = $user->getId();
        } else {
            throw new Exception('Something went wrong');
        }

        return $this->getChat($institutionId, $adjunctId);
    }

    /**
     * @param int $institutionId
     * @param int $adjunctId
     * @return Chat
     */
    protected function getChat(int $institutionId, int $adjunctId): Chat
    {
        $chat = Chat::findOne([
            'adjunct_user_id' => $adjunctId,
            'institution_user_id' => $institutionId,
        ]);

        if (!$chat) {
            $chat = new Chat();
            $chat->adjunct_user_id = $adjunctId;
            $chat->institution_user_id = $institutionId;

            if (!$chat->save()) {
                throw new RuntimeException('Chat save error.');
            }
        }

        return $chat;
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
     * @param Chat $chat
     * @return Message
     */
    public function createMessage(Chat $chat): Message
    {
        $message = new Message();
        $message->chat_id = $chat->id;
        $message->author_user_id = $this->getUser()->getId();

        return $message;
    }

    /**
     * @param Chat $chat
     */
    public function setReadStatusNewMessages($chat): void
    {
        $messages = $chat->getUnreadMessagesForUserId($this->getUser()->getId());

        foreach ($messages as $message) {
            $message->read = Message::STATUS_READ;
            $message->save();
        }
    }

}