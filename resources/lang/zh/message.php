<?php

return [
    'mail' => [
        'verify' => '[QURAS Dashboard] 认证邮件',
        'verify-failed' => '邮箱验证失败。 请再试一次。',
        'success' => '邮箱验证成功。',

        'reset_password' => '【QURAS Dashboard】密码重置',

        'withdrawal_confirm' => '【QURAS Dashboard】取出认证',

        'send_failed' => '认证邮箱发送失败。',
    ],

    'kyc' => [
        'upload_failed' => '文件上传失败。',

        'register_succeed' => 'KYC信息已登记。 信息确认需要3天左右的时间,请耐心等待。',
        'register_failed' => 'KYC信息登记失败。 请再试一次。',

        'no_info' => '请登记KYC信息。 XQC Token在KYC认证结束后会发送。',
        'checking' => '正在确认KYC信息。 XQC Token在KYC认证结束后会发送。',
        'rejected' => '注册的KYC信息被拒绝。 请重新登记KYC信息。XQC Token在KYC认证结束后会发送。',

        'no_verified' => 'KYC验证后,你可以取出XQC。',
    ],

    'profile' => [
        'success' => '个人资料更新成功。',
        'failed' => '个人资料更新失败。',
        'verified' => 'KYC验证后，您将无法更新个人资料。',

        'no_current_password' => '现在的密码不正确。',
        'password_success' => '密码更新成功。',
        'password_failed' => '密码更新失败。',
    ],

    'affiliate' => [
        'your_code' => '您的推广代码不能登记为推荐者的推广代码。',

        'failed' => '推荐者的推广代码登记失败。 请再试一次。',
        'crypto_failed' => '虚拟货币奖励地址登记失败。 请再试一次。',

        'success' => '奖励地址和推荐者推广代码已登记。',
    ],

    'select-crypto' => [
        'select' => '请选择虚拟货币种类。'
    ],

    'withdrawal' => [
        'success' => '申请取出成功',
        'failed' => '申请取出失败',
    ],

    'bonus_add_no_info' => '请登记获取奖励的BTC和ETH地址。',
    'invalid_btc_address' => 'BTC地址不正确。 请登记正确的BTC地址。',
    'invalid_eth_address' => 'ETH地址不正确。 请登记正确的ETH地址。',

    'maintenance_notice1' => '用于服务器的维护，提款申请和KYC功能暂时停止，感谢您的理解与合作。',
    'maintenance_notice2' => '[暂停时间]（12月27日（星期五）20:01〜1月6日（星期一）9:59）',
];