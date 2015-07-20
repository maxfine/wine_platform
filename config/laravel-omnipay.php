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
                'notifyUrl' => 'https://www.example.com/notify',
                'returnUrl' => 'https://www.example.com/return',
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
            ]
        ],

        'Alipay_Express' => [
            'driver'  => 'Alipay_Express', //支付宝担保交易接口
            'options' => [
                'partner' => '2088002529453464',
                'key' => 'osfvviymykc4pc6i1dvn4cf68rc5j2qj',
                'sellerEmail' => '1526469221@qq.com',
                'notifyUrl' => 'https://www.example.com/notify',
                'returnUrl' => 'https://www.example.com/return',
                //receiveInfo
                'receiveName' => 'konghs',
                'receiveAddress' => 'hangzhou',
                'receiveZip' => '201507',
                'receivePhone' => '15558175937',
                'receiveMobile' => '15558175937'
            ]
        ],

        'Alipay_Bank' => [
            'driver'  => 'Alipay_Bank', //支付宝担保交易接口
            'options' => [
                'partner' => '2088002529453464',
                'key' => 'osfvviymykc4pc6i1dvn4cf68rc5j2qj',
                'sellerEmail' => '1526469221@qq.com',
                'notifyUrl' => 'https://www.example.com/notify',
                'returnUrl' => 'https://www.example.com/return',
                //receiveInfo
                'receiveName' => 'konghs',
                'receiveAddress' => 'hangzhou',
                'receiveZip' => '201507',
                'receivePhone' => '15558175937',
                'receiveMobile' => '15558175937',
                'defaultBank' => 'ICBCBTB' //网关
            ]
        ],

        'paypal' => [
            'driver'  => 'PayPal_Express',
            'options' => [
                'solutionType'   => '',
                'landingPage'    => '',
                'headerImageUrl' => ''
            ]
        ]
    ]
];

