<?php

namespace frontend\controllers;

use common\models\Chat;
use common\models\User;
use common\src\helpers\Helper;
use frontend\src\ChatManager;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ErrorAction;

class ChatController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
//                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $user = Helper::getUserIdentity();
        $chatManager = $this->createChatManager();
        $chats = $chatManager->getChatList();

        return $this->render('index', [
            'chats' => $chats,
            'user' => $user,
        ]);
    }

    /**
     * @param int $chatId
     * @return mixed
     */
    public function actionView(int $chatId)
    {
        if ($chat = Chat::findOne($chatId)) {
            $chatManager = $this->createChatManager();
            $chatManager->setReadStatusNewMessages($chat);
            $newMessage = $chatManager->createMessage($chat);

            return $this->render('view', [
                'chat' => $chat,
                'newMessage' => $newMessage,
            ]);
        }

        Yii::$app->session->setFlash('error', 'Chat undefined');

        return $this->render('index');
    }

    /**
     * @param int $param
     * @param int|null $vacancyId
     * @return mixed
     * @throws \Exception
     */
    public function actionCreate(int $param, int $vacancyId = null)
    {
        $chatManager = $this->createChatManager();
        $chat = $chatManager->create($param, $vacancyId);
        $newMessage = $chatManager->createMessage($chat);

        return $this->render('view', [
            'chat' => $chat,
            'newMessage' => $newMessage,
        ]);
    }


    /**
     * @return ChatManager
     */
    protected function createChatManager(): ChatManager
    {
        /** @var User $user */
        $user = Helper::getUserIdentity();

        return new ChatManager($user);
    }
}