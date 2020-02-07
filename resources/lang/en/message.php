<?php

return [
    'mail' => [
        'verify' => '【QURAS Dashboard】 Email Verify',
        'verify-failed' => 'Email verify failed. Please try again later.',
        'success' => 'Email verification successful.',

        'reset_password' => '【QURAS Dashboard】 Reset Password',

        'withdrawal_confirm' => '【QURAS Dashboard】 Withdrawal Confirm',

        'send_failed' => 'Confirmation email send failed.',
    ],

    'kyc' => [
        'upload_failed' => 'File upload failed.',

        'register_succeed' => 'KYC info registration successful. Please wait for us to verify your KYC info. The confirmation process can take up to 3 days.',
        'register_failed' => 'KYC info register failed. Please try again later.',

        'no_info' => 'Please register KYC info. You can get the XQC Token after KYC verification.',
        'checking' => 'Your application for KYC is being processed. You can get the XQC Token after KYC verification.',
        'rejected' => 'Your KYC info was rejected. Please register again. You can get the XQC Token after KYC verification.',

        'no_verified' => 'You can withdraw the XQC after KYC verification.',
    ],

    'profile' => [
        'success' => 'Profile update succeed.',
        'failed' => 'Profile update failed.',
        'verified' => 'You can\'t update your profile info after KYC verified',

        'no_current_password' => 'The current password is invalid.',
        'password_success' => 'Password update succeed.',
        'password_failed' => 'Password update failed.',
    ],

    'affiliate' => [
        'your_code' => 'The recommender\'s affiliate code must not be your affiliate code.',

        'failed' => 'The recommender\'s affiliate code register failed. Please try again later.',
        'crypto_failed' => 'The cryptocurrency bonus address register failed. Please try again later.',

        'success' => 'The bonus addresses and recommender\'s affiliate code were successfully registered.',
    ],

    'select-crypto' => [
        'select' => 'Please select the type of CryptoCurrency.'
    ],

    'withdrawal' => [
        'success' => 'Withdrawal request succeed.',
        'failed' => 'Withdrawal request failed.',
    ],

    'bonus_add_no_info' => 'Please register your BTC and ETH bonus address to get a bonus.',
    'invalid_btc_address' => 'BTC address is invalid. Please enter the valid BTC address.',
    'invalid_eth_address' => 'ETH address is invalid. Please enter the valid ETH address.',

    'maintenance_notice1' => 'Due to server maintenance, withdrawal/KYC functions will be temporarily stopped. Thank you for your understanding and cooperation.',
    'maintenance_notice2' => '[Maintenance Period] Dec 27 (Fri) 20:01~ Jan 6 (Mon) 9:59',
];