<?php
//require_once("alipay.config.php");
class AlipayController extends Controller
{
    public $alipay_config=array();
    public function init(){
        $this->alipay_config['partner']= '2088811584894868';
        //收款支付宝账号
        $this->alipay_config['seller_email']	= 'hr@wymenu.com';
        //安全检验码，以数字和字母组成的32位字符
        $this->alipay_config['key']= 'jg1i916xu88bjmfpv02mx96afz63ormg';
        //签名方式 不需修改
        $this->alipay_config['sign_type']    = strtoupper('MD5');
        //字符编码格式 目前支持 gbk 或 utf-8
        $this->alipay_config['input_charset']= strtolower('utf-8');
        //ca证书路径地址，用于curl中ssl校验
        //请保证cacert.pem文件在当前文件夹目录中
        //$this->alipay_config['cacert']    = getcwd().'\\cacert.pem';
        $this->alipay_config['cacert']    = "admin\cacert.pem";
        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $this->alipay_config['transport']    = 'http';
    }
    /*
     * 一个支付宝支付按钮，
     * 其他参数都作为隐藏参数放在form里面，
     * 点击后提交到pay
     */
	public function actionIndex()
	{
		$this->render('index');
	}
        
        public function actionPay()
	{
//            $alipayconf=new AlipayConfig();
//            var_dump($alipayconf);exit;
//            $alipay_config=$alipayconf->getAlipayConfig();
            //var_dump($this->alipay_config); exit;
            $payment_type = "1";
            //必填，不能修改
            //服务器异步通知页面路径
            $notify_url = "http://menu.wymenu.com/wymenuv2/alipay/notify";
            //需http://格式的完整路径，不能加?id=123这类自定义参数
            //页面跳转同步通知页面路径
            $return_url = "http://menu.wymenu.com/wymenuv2/alipay/return";
            //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
            //商户订单号
            $out_trade_no = $_POST['WIDout_trade_no']; //商户网站订单系统中唯一订单号，必填
            //订单名称
            $subject = $_POST['WIDsubject']; //必填
            //付款金额
            $total_fee = $_POST['WIDtotal_fee']; //必填
            //订单描述
            $body = $_POST['WIDbody'];
            //商品展示地址
            $show_url = $_POST['WIDshow_url']; //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
            //防钓鱼时间戳
            $anti_phishing_key = "";   //若要使用请调用类文件submit中的query_timestamp函数
            //客户端的IP地址
            $exter_invoke_ip = ""; //非局域网的外网IP地址，如：221.0.0.1
            //构造要请求的参数数组，无需改动
            $parameter = array(
                            "service" => "create_direct_pay_by_user",
                            "partner" => trim($this->alipay_config['partner']),
                            "seller_email" => trim($this->alipay_config['seller_email']),
                            "payment_type"	=> $payment_type,
                            "notify_url"	=> $notify_url,
                            "return_url"	=> $return_url,
                            "out_trade_no"	=> $out_trade_no,
                            "subject"	=> $subject,
                            "total_fee"	=> $total_fee,
                            "body"	=> $body,
                            "show_url"	=> $show_url,
                            "anti_phishing_key"	=> $anti_phishing_key,
                            "exter_invoke_ip"	=> $exter_invoke_ip,
                            "_input_charset"	=> trim(strtolower($this->alipay_config['input_charset']))
                    );

            //建立请求
            $alipaySubmit = new AlipaySubmit($this->alipay_config);
            $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "正在跳转到支付宝，请稍等...");
		$this->render('pay',array(
                    'html_text'=>$html_text               
                ));
	}
        
        public function actionReturn()
	{
//            $alipayconf=new AlipayConfig();
//            $alipay_config=$alipayconf->getAlipayConfig();
                //计算得出通知验证结果
                $alipayNotify = new AlipayNotify($this->alipay_config);
                $verify_result = $alipayNotify->verifyReturn();
                $ret_status="";
                $trade_status="";
                if($verify_result) {//验证成功
                        //商户订单号
                        $out_trade_no = $_GET['out_trade_no'];
                        //支付宝交易号
                        $trade_no = $_GET['trade_no'];
                        //交易状态
                        $trade_status = $_GET['trade_status'];
                        //交易目前所处的状态。成功状态的值只有两个：
                        //TRADE_FINISHED（普通即时到账的交易成功状态）
                        //TRADE_SUCCESS（开通了高级即时到账或机票分销产品后的交易成功状态）
                    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                        //判断该笔订单是否在商户网站中已经做过处理
                        //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                        //如果有做过处理，不执行商户的业务程序
                        //下单，返回页面，单元清单。。。
                        $this->endTrade($out_trade_no,$trade_no,$trade_no);
                        $ret_status="正常返回，下单成功";//下单成功
                    } else {
                        //echo "trade_status=".$_GET['trade_status'];
                        $ret_status= "非正常返回，验证成功。";
                    }

                } else {
                    //验证失败
                    //如要调试，请看alipay_notify.php页面的verifyReturn函数
                    $ret_status="验证失败";
                }
                //var_dump($trade_status);exit;
		$this->render('return',array(
			'trade_status'=>$trade_status,
                        'ret_status'=>$ret_status
		));
	}
        
        public function actionNotify()
	{
            $alipayconf=new AlipayConfig();
            $this->alipay_config=$alipayconf->getAlipayConfig();
            $alipayNotify = new AlipayNotify($this->alipay_config);
            $verify_result = $alipayNotify->verifyNotify();
            if($verify_result) {//验证成功
                    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    //请在这里加上商户的业务逻辑程序代
                    //订单厨打、收银和结单
                    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
                    //商户订单号
                    $out_trade_no = $_POST['out_trade_no'];
                    //支付宝交易号
                    $trade_no = $_POST['trade_no'];
                    //交易状态
                    $trade_status = $_POST['trade_status'];
                    //WAIT_BUYER_PAY交易创建，等待买家付款。
                    //TRADE_CLOSED 在指定时间段内未支付时关闭的交易；在交易完成全额退款成功时关闭的交易。
                    //TRADE_SUCCESS 交易成功，且可对该交易做操作，如：多级分润、退款等。
                    //TRADE_PENDING 等待卖家收款（买家付款后，如果卖家账号被冻结）。
                    //TRADE_FINISHED 交易成功且结束，即不可再做任何操作
                if($_POST['trade_status'] == 'TRADE_FINISHED') {
                    //判断该笔订单是否在商户网站中已经做过处理
                            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                            //如果有做过处理，不执行商户的业务程序
                    //注意：
                    //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
                    //调试用，写文本函数记录程序运行情况是否正常
                    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
                    //厨打、收款/退款、结单
                    $this->notifyTrade($out_trade_no,$trade_no,$trade_no);
                }
                else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                    //判断该笔订单是否在商户网站中已经做过处理
                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    //如果有做过处理，不执行商户的业务程序
                   //注意：
                   //付款完成后，支付宝系统发送该交易状态通知
                    //调试用，写文本函数记录程序运行情况是否正常
                    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
                    //厨打、收款/退款、结单
                    $this->notifyTrade($out_trade_no,$trade_no,$trade_no);
                }
                //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
                echo "success";		//请不要修改或删除
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            }
            else {
                //验证失败
                echo "fail";
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
	}
        /*
         * 支付成功后，订单边支付成功，商品清单就变成下单成功，下单数量加一
         * 打印清单，同时厨房打印，厨房打印成功，都打印成功了就结单、
         * 任何一个打印失败都通知到order_feedback
         */
        private function endTrade($out_trade_no,$trade_no,$trade_no){
		
	} 
        
        /*
         * 做个存储记录，建一个notify表 支付宝和微信共用
         */
        private function notifyTrade($out_trade_no,$trade_no,$trade_no){
		
	}
}