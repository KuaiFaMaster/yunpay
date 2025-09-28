<?php

namespace WGCYunPay\Data\Pay;

use WGCYunPay\Data\Base;

class BaseData extends Base
{
    /**
     * 商户订单号，由商户保持唯⼀性(必填)，64个 英⽂字符以内
     * @var
     */
    public $order_id;

    /**
     * 姓名(必填)
     * @var
     */
    public $real_name;

    /**
     * 身份证(必填)
     * @var
     */
    public $id_card;

    /**
     * 打款⾦额(单位为元, 必填)
     * @var
     */
    public $pay;

    /**
     * 备注信息(选填)
     * @var
     */
    public $notes;

    /**
     * 打款备注(选填，最⼤20个字符，⼀个汉字占2个 字符，不允许特殊字符：' " & | @ % * ( ) - : # ￥)
     * @var
     */
    public $pay_remark;

    /**
     * 回调地址(选填，最⼤⻓度为200)
     * @var string
     */
    public $notify_url = '';


    /**
     * 用户手机号
     * @var
     */
    public $phone_no = '';

    /**
     * 互联网平台名称,填写收入来源的互联网平台名称
     * @var
     */
    public $dealer_platform_name = '';

    /**
     * 用户名称/昵称,填写从业人员在收入来源的互联网平台内展示的“名称”或“昵称”全称
     * @var
     */
    public $dealer_user_nickname = '';

    /**
     * 用户唯一标识码,填写从业人员在本平台内登记的具有唯一性、长期性、可追溯性的身份标识证明
     * @var
     */
    public $dealer_user_id = '';

    protected $method = 'post';
}
