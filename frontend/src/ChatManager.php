<?php

namespace frontend\src;

use common\models\Chat;
use common\models\Message;
use common\models\User;
use common\models\Vacancy;
use Exception;
use RuntimeException;

class ChatManager
{
    /** @var User */
    protected $user;

    public function __construct(User $user)
    {
        $this->setUser($user);
    }

    public function getChatList(): array
    {
        $user = $this->getUser();

        return Chat::findByUserId($user->getId());
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
            $vacancyId = $param;
            $adjunctId = $user->getId();

            return $this->createAdjunctChat($vacancyId, $adjunctId);
        }

        if ($user->isInstitution()) {
            $adjunctId = $param;
            $institutionId = $user->getId();

            return $this->createInstitutionChat($institutionId, $adjunctId);
        }

        throw new Exception('Something went wrong');
    }

    /**
     * @param int $vacancyId
     * @param int $adjunctId
     * @return Chat
     */
    protected function createAdjunctChat(int $vacancyId, int $adjunctId): Chat
    {
        /** @var Vacancy $vacancy */
        $vacancy = Vacancy::findOne($vacancyId);

        $chat = Chat::findOne([
            'vacancy_id' => $vacancyId,
            'adjunct_user_id' => $adjunctId,
            'institution_user_id' => $vacancy->institution_user_id,
        ]);

        if (!$chat) {
            $chat = new Chat();
            $chat->vacancy_id = $vacancyId;
            $chat->adjunct_user_id = $adjunctId;
            $chat->institution_user_id = $vacancy->institution_user_id;

            if (!$chat->save()) {
                throw new RuntimeException('Chat save error.');
            }
        }

        return $chat;
    }

    /**
     * @param int $institutionId
     * @param int $adjunctId
     * @return Chat
     */
    protected function createInstitutionChat(int $institutionId, int $adjunctId): Chat
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

}