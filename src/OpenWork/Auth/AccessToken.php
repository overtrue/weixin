<?php
/*
 * This file is part of the keacefull/wechat.
 *
 * (c) xiaomin <keacefull@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace EasyWeChat\OpenWork\Auth;

use  EasyWeChat\Kernel\AccessToken as BaseAccessToken;


class AccessToken extends BaseAccessToken
{

    /**
     * @var string
     */
    protected $endpointToGetToken = 'cgi-bin/service/get_provider_token';

    /**
     * @var string
     */
    protected $tokenKey = 'provider_access_token';

    /**
     * @var string
     */
    protected $cachePrefix = 'easywechat.kernel.provider_access_token.';

    /**
     * Credential for get token.
     *
     * @return array
     */
    protected function getCredentials(): array
    {
        return [
            'corpid'          => $this->app['config']['corp_id'], //服务商的corpid
            'provider_secret' => $this->app['config']['secret'],
        ];
    }
}