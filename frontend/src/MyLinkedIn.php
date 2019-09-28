<?php

namespace frontend\src;

use yii\authclient\OAuth2;

class MyLinkedIn extends OAuth2
{
    public const DEFAULT_NAME = 'mylinkedin';

    /**
     * {@inheritdoc}
     */
    public $authUrl = 'https://www.linkedin.com/oauth/v2/authorization';
    /**
     * {@inheritdoc}
     */
    public $tokenUrl = 'https://www.linkedin.com/oauth/v2/accessToken';
    /**
     * {@inheritdoc}
     */
    public $apiBaseUrl = 'https://api.linkedin.com/v2';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if ($this->scope === null) {
            $this->scope = implode(' ', [
                'r_liteprofile',
                'r_emailaddress',
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function defaultNormalizeUserAttributeMap()
    {
        return [
            'firstName' => 'localizedFirstName',
            'lastName' => 'localizedLastName',
            'email' => static function ($attributes) {
                return $attributes['elements'][0]['handle~']['emailAddress'];
            },
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function initUserAttributes()
    {
        return array_merge($this->getProfile(), $this->getEmail());
    }

    protected function getProfile()
    {
        return $this->api('me');
    }

    protected function getEmail()
    {
        return $this->api('emailAddress?q=members&projection=(elements*(handle~))');
    }

    /**
     * {@inheritdoc}
     */
    public function applyAccessTokenToRequest($request, $accessToken)
    {
        $data = $request->getData();
        $data['oauth2_access_token'] = $accessToken->getToken();
        $request->setData($data);
    }

    /**
     * {@inheritdoc}
     */
    protected function defaultName()
    {
        return self::DEFAULT_NAME;
    }

    /**
     * {@inheritdoc}
     */
    protected function defaultTitle()
    {
        return 'MyLinkedIn';
    }
}