<?php

namespace frontend\controllers;

use common\models\Chat;
use common\models\User;
use common\src\helpers\Helper;
use common\src\helpers\UserImageHelper;
use Exception;
use frontend\src\ChatManager;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

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

        return $this->renderPartial('index', [
            'chats' => $chats,
            'user' => $user,
        ]);
    }

    /**
     * @param int $chatId
     * @param bool $isHtml
     * @return mixed
     */
    public function actionView(int $chatId, bool $isHtml = true)
    {
        $user = Helper::getUserIdentity();

        if ($user && $chat = Chat::findOne($chatId)) {
            if ($isHtml) {
                $chatManager = $this->createChatManager();
                $chatManager->setReadStatusNewMessages($chat);
                $newMessage = $chatManager->createMessage($chat);

                return $this->render('view', [
                    'chat' => $chat,
                    'newMessage' => $newMessage,
                    'ajaxForm' => false,
                ]);
            }

            return $this->prepareResponse($chat, $user);
        }

        return $isHtml ? '' : [];
    }

    /**
     * @return array
     */
    public function actionViewAjax(): array
    {
        $response = [
            'success' => false,
            'body' => null,
        ];

        if (Yii::$app->request->isAjax && $user = Helper::getUserIdentity()) {
            $post = Yii::$app->request->post();
            if ($post['chatId'] && $chat = Chat::findOne($post['chatId'])) {
                $response = $this->prepareResponse($chat, $user);
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $response;
    }

    /**
     * @param int $param
     * @return mixed
     * @throws Exception
     */
    public function actionCreate(int $param)
    {
        $chatManager = $this->createChatManager();
        $chat = $chatManager->create($param);
        $newMessage = $chatManager->createMessage($chat);

        return $this->render('view', [
            'chat' => $chat,
            'newMessage' => $newMessage,
            'ajaxForm' => false,
        ]);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function actionCreateAjax()
    {
        $response = [
            'success' => false,
            'body' => null,
        ];

        if (Yii::$app->request->isAjax && $user = Helper::getUserIdentity()) {
            $post = Yii::$app->request->post();

            if ($post['userId']) {
                $chatManager = $this->createChatManager();
                $chat = $chatManager->create($post['userId']);

                $response = [
                    'success' => true,
                    'body' => [
                        'chatId' => $chat->id,
                    ],
                ];
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $response;
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

    /**
     * @param Chat $chat
     * @param User $user
     * @return array
     */
    protected function prepareResponse(Chat $chat, User $user): array
    {
        $chatManager = $this->createChatManager();
        $chatManager->setReadStatusNewMessages($chat);
        $newMessage = $chatManager->createMessage($chat);
        $opponent = $chat->getOpponentUser($user);

        return [
            'success' => true,
            'body' => [
                'html' => $this->renderPartial('view', [
                    'chat' => $chat,
                    'newMessage' => $newMessage,
                    'ajaxForm' => true,
                ]),
                'opponent' => [
                    'name' => $opponent->getUsername(),
                    'img' => UserImageHelper::getUrl($opponent),
                ]
            ]
        ];
    }
}