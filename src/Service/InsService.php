<?php

namespace WGCYunPay\Service;

use WGCYunPay\AbstractInterfaceTrait\BaseService;
use WGCYunPay\AbstractInterfaceTrait\MethodTypeTrait;
use WGCYunPay\Data\Router;

class InsService extends BaseService
{
    /**
     * 查询投保信息
     */
    const  POLICY_GET = 'policy_get';

    /**
     * 创建保单
     */
    const  POLICY_CREATE   = 'policy_create';

    /**
     * 删除测试保单
     */
    const  POLICY_DELETE = 'policy_delete';

    /**
     * 请求类型
     */
    const  METHOD_ARR = [self::POLICY_GET, self::POLICY_CREATE, self::POLICY_DELETE];

    /**
     * 平台企业保单 ID
     * @var string
     */
    protected $policyId = '';

    /**
     * 保险方案号(云账户提供，平台企业按需选择)
     * @var
     */
    protected $planCode;

    /**
     * 证件号
     * @var string
     */
    protected $idCard = '';

    /**
     * 证件姓名
     * @var string
     */
    protected $realName = '';

    /**
     * 证件截止日期,时间格式：yyyy-MM-dd
     */
    protected $cardEndDate = '';

    /**
     * 投保开始时间,时间格式：yyyy-MM-dd HH:mm:ss
     */
    protected $policyStartAt = '';

    /**
     * 手机号
     */
    protected $phoneNo = '';

    /**
     * 创建保单结果通知地址
     */
    protected $callbackUrl = '';

    /**
     * 云账户保单 ID
     */
    protected $policyRef = '';



    /**
     * 如果为encryption，则对返回的data进⾏ 加密(选填)
     * @var string
     */
    //protected $dataType   = 'encryption';
    protected $dataType   = '';

    use MethodTypeTrait;

    public function setPolicyId($policyId)
    {
        $this->policyId = $policyId;
        return $this;
    }


    public function setPlanCode($planCode)
    {
        $this->planCode = $planCode;
        return $this;
    }


    public function setIdCard($idCard)
    {
        $this->idCard = $idCard;
        return $this;
    }

    public function setRealName($realName)
    {
        $this->realName = $realName;
        return $this;
    }

    public function setCardEndDate($cardEndDate)
    {
        $this->cardEndDate = $cardEndDate;
        return $this;
    }


    public function setPolicyStartAt($policyStartAt)
    {
        $this->policyStartAt = $policyStartAt;
        return $this;
    }


    public function setPhoneNo($phoneNo)
    {
        $this->phoneNo = $phoneNo;
        return $this;
    }

    public function setCallbackUrl($callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
        return $this;
    }

    public function setPolicyRef($policyRef)
    {
        $this->policyRef = $policyRef;
        return $this;
    }

    /**
     * 根据类型返回数据
     * Date : 2019/7/31 15:58
     * @return array|mixed
     * @throws \Exception
     */
    protected function getDes3Data(): array
    {
        // TODO: Implement getDes3Data() method.
        switch ($this->methodType ?? self::POLICY_GET) {
            case self::POLICY_GET:
            case self::POLICY_DELETE:
                $data      = ['broker_id' => $this->config->broker_id, 'dealer_id' => $this->config->dealer_id, 'policy_id' => $this->policyId];
                if ($this->policyRef) {
                    $data['policy_ref'] = $this->policyRef;
                }
                break;
            case self::POLICY_CREATE:
                $data      = ['broker_id' => $this->config->broker_id, 'dealer_id' => $this->config->dealer_id, 'policy_id' => $this->policyId,
                    'plan_code' => $this->planCode, 'country_code'=>'CHN','card_type'=>'idcard', 'id_card'=>$this->idCard,
                    'real_name'=>$this->realName,'card_end_date'=>$this->cardEndDate,'policy_start_at'=>$this->policyStartAt,
                    'area_code'=>'+86','phone_no'=>$this->phoneNo,'callback_url'=>$this->callbackUrl];
                break;
            default:
                throw new \Exception('not des3Data');
        }
        return $data;
    }

    protected function getRequestInfo()
    {
        $methodType = $this->methodType ?? self::POLICY_GET;

        $method = 'post';
        if (in_array($methodType, [self::POLICY_GET])) {
            $method = 'get';
        }

        $route = Router::INS_POLICY;
        switch ($methodType) {
            case self::POLICY_CREATE:
            case self::POLICY_GET:
                $route = Router::INS_POLICY;
                break;
            case self::POLICY_DELETE:
                $route = Router::INS_POLICY_DELETE;
                break;
        }

        return [$route, $method];
    }

    protected function callback($res){
        if(isset($res['data']) && is_string($res['data'])){
            $res['data'] = Des3Service::decode($res['data'], $this->config->des3_key);
        }
        return $res;
    }
}
