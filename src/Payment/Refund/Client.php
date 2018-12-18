<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyWeChat\Payment\Refund;

use EasyWeChat\Payment\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * Refund by out trade number.
     *
     * @param string $number
     * @param string $refundNumber
     * @param int    $totalFee
     * @param int    $refundFee
     * @param array  $optional
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function byOutTradeNumber(string $number, string $refundNumber, int $totalFee, int $refundFee, array $optional = [])
    {
        return $this->refund($refundNumber, $totalFee, $refundFee, array_merge($optional, ['out_trade_no' => $number]));
    }

    /**
     * Refund by transaction id.
     *
     * @param string $transactionId
     * @param string $refundNumber
     * @param int    $totalFee
     * @param int    $refundFee
     * @param array  $optional
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function byTransactionId(string $transactionId, string $refundNumber, int $totalFee, int $refundFee, array $optional = [])
    {
        return $this->refund($refundNumber, $totalFee, $refundFee, array_merge($optional, ['transaction_id' => $transactionId]));
    }

    /**
     * Query refund by transaction id.
     *
     * @param string $transactionId
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function queryByTransactionId(string $transactionId)
    {
        return $this->query($transactionId, 'transaction_id');
    }

    /**
     * Query refund by out trade number.
     *
     * @param string $outTradeNumber
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function queryByOutTradeNumber(string $outTradeNumber)
    {
        return $this->query($outTradeNumber, 'out_trade_no');
    }

    /**
     * Query refund by out refund number.
     *
     * @param string $outRefundNumber
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function queryByOutRefundNumber(string $outRefundNumber)
    {
        return $this->query($outRefundNumber, 'out_refund_no');
    }

    /**
     * Query refund by refund id.
     *
     * @param string $refundId
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function queryByRefundId(string $refundId)
    {
        return $this->query($refundId, 'refund_id');
    }

    /**
     * Refund.
     *
     * @param string $refundNumber
     * @param int    $totalFee
     * @param int    $refundFee
     * @param array  $optional
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    protected function refund(string $refundNumber, int $totalFee, int $refundFee, $optional = [])
    {
        $params = array_merge([
            'out_refund_no' => $refundNumber,
            'total_fee' => $totalFee,
            'refund_fee' => $refundFee,
            'appid' => $this->app['config']->app_id,
        ], $optional);

        $api = 'secapi/pay/refund';
        if ($this->app->inSandbox()) {
            // 根据文档说明,沙盒中必须调用 pay/refund 接口,否则不通过
            // https://pay.weixin.qq.com/wiki/doc/api/download/mczyscsyl.pdf
            // 1002-可选用例-刷卡支付退款
            $api = 'pay/refund';
        }

        return $this->safeRequest($this->wrap($api), $params);
    }

    /**
     * Query refund.
     *
     * @param string $number
     * @param string $type
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    protected function query(string $number, string $type)
    {
        $params = [
            'appid' => $this->app['config']->app_id,
            $type => $number,
        ];

        return $this->request($this->wrap('pay/refundquery'), $params);
    }
}
