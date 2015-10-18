<?php
return [

    /*
     * ------------------------
     * 默认
     * ------------------------
	// The default gateway to use
	'default' => 'paypal',

	// Add in each gateway here
	'gateways' => [
		'paypal' => [
			'driver'  => 'PayPal_Express',
			'options' => [
				'solutionType'   => '',
				'landingPage'    => '',
				'headerImageUrl' => ''
			]
		]
	]
    */

    'default' => 'Alipay_Express',

    'gateways' => [
        'Alipay_Secured' => [
            'driver'  => 'Alipay_Secured', //支付宝担保交易接口
            'options' => [
                'partner' => '2088002529453464',
                'key' => 'osfvviymykc4pc6i1dvn4cf68rc5j2qj',
                'sellerEmail' => '1526469221@qq.com',
                'notifyUrl' => 'http://jiu.znyes.com/pay/respond_post/Alipay_Secured', //post
                'returnUrl' => 'http://jiu.znyes.com/pay/respond_get/Alipay_Secured', //get
                //logisticsInfo
                'logisticsFee' => '0.00', //运费
                'logisticsType' => 'EXPRESS',
                'logisticsPayment' => 'BUYER_PAY',
                //receiveInfo
                'receiveName' => 'konghs',
                'receiveAddress' => 'hangzhou',
                'receiveZip' => '201507',
                'receivePhone' => '15558175937',
                'receiveMobile' => '15558175937'
            ],
            'purchaseParamKeys' => [
                'out_trade_no' => 'out_trade_no',
                'price' => 'total_fee',
                'subject' => 'subject',
                'quantity' => 'quantity'
            ]
        ],

        'Alipay_Express' => [
            'driver'  => 'Alipay_Express', //支付宝担保交易接口
            'options' => [
                'partner' => '2088021297824829',
                'key' => 'pcicfo8o6l2v8xb2hrnoch5qvp42xxay',
                'sellerEmail' => '437630959@qq.com',
                'notifyUrl' => 'http://jiu.znyes.com/pay/respond_post/Alipay_Express', //post
                'returnUrl' => 'http://jiu.znyes.com/pay/respond_get/Alipay_Express', //get
                //receiveInfo
                'receiveName' => 'konghs',
                'receiveAddress' => 'hangzhou',
                'receiveZip' => '201507',
                'receivePhone' => '15558175937',
                'receiveMobile' => '15558175937'
            ],
            'purchaseParamKeys' => [
                'out_trade_no' => 'out_trade_no',
                'total_fee' => 'total_fee',
                'subject' => 'subject',
            ]
        ],

        'Alipay_Bank' => [
            'driver'  => 'Alipay_Bank', //支付宝担保交易接口
            'options' => [
                'partner' => '2088021297824829',
                'key' => 'y7ltjfmpkfosn5vbi69a5080kcb96nz7',
                'sellerEmail' => '437630959@qq.com',
                'notifyUrl' => 'http://jiu.znyes.com/dome/respond/Alipay_Bank', //post
                'returnUrl' => 'http://jiu.znyes.com/dome/respond/Alipay_Bank', //get
                //receiveInfo
                'receiveName' => 'konghs',
                'receiveAddress' => 'hangzhou',
                'receiveZip' => '201507',
                'receivePhone' => '15558175937',
                'receiveMobile' => '15558175937',
                'defaultBank' => 'ICBCBTB' //网关
            ],
            'purchaseParamKeys' => [
                'out_trade_no' => 'out_trade_no',
                'total_fee' => 'total_fee',
                'subject' => 'subject',
                'defaultBank' => 'defaultBank'
            ]

        ],

        'paypal' => [
            'driver'  => 'PayPal_Express',
            'options' => [
                'solutionType'   => '',
                'landingPage'    => '',
                'headerImageUrl' => ''
            ],
            'purchaseParamKeys' => [
                'out_trade_no' => 'out_trade_no',
                'total_fee' => 'total_fee',
                'subject' => 'subject',
            ]
        ]
    ]
];

