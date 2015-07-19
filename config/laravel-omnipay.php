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

    'default' => 'alipay',

    'gateways' => [
        'alipay' => [
            'driver'  => 'Alipay_Secured', //支付宝担保交易接口
            'options' => [
                'partner' => '20880127040',
                'key' => 'sc1n78r0faswga7jjrpf6o',
                'sellerEmail' => 'max_fine@qq.com',
                'notifyUrl' => 'https://www.example.com/notify',
                'returnUrl' => 'https://www.example.com/return',
                //logisticsInfo
                'logisticsFee' => 8,
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

