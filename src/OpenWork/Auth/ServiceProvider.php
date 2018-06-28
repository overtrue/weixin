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

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        isset($app['provider_access_token']) || $app['provider_access_token'] = function ($app) {
            return new AccessToken($app);
        };
    }
}