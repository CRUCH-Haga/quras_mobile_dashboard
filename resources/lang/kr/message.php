<?php

return [
    'mail' => [
        'verify' => '【QURAS 대시보드】 이메일 인증',
        'verify-failed' => '이메일 인증이 실패하였습니다. 다시 시도하여 주기 바랍니다.',
        'success' => '이메일 인증이 성공하였습니다.',

        'reset_password' => '【QURAS 대시보드】비밀번호 재설정',

        'withdrawal_confirm' => '【QURAS 대시보드】출금 인증',

        'send_failed' => '인증메일 발송이 실패하였습니다.',
    ],

    'kyc' => [
        'upload_failed' => '파일 업로드가 실패하였습니다.',

        'register_succeed' => 'KYC정보가 등록되었습니다. 정보 확인은 늦어서 3일정도의 시간이 걸리므로 기다려주기 바랍니다.',
        'register_failed' => 'KYC정보 등록이 실패하였습니다. 다시 시도하여 주기 바랍니다.',

        'no_info' => 'KYC정보를 등록하여주기 바랍니다. KYC인증이 완료된 후에 XQC토큰을 출금할수 있습니다.',
        'checking' => 'KYC정보를 확인중입니다. KYC인증이 완료된 후에 XQC토큰을 출금할수 있습니다.',
        'rejected' => '등록한 KYC정보가 거부되였습니다. KYC정보를 다시 등록하여주기 바랍니다. KYC인증이 완료된 후에 XQC토큰을 출금할수 있습니다.',

        'no_verified' => 'KYC검증후에 XQC를 출금할수 있습니다.',
    ],

    'profile' => [
        'success' => '프로필 정보 갱신이 성공하였습니다.',
        'failed' => '프로필 정보 갱신이 실패하였습니다.',
        'verified' => 'KYC검증후에는 프로필 정보를 갱신하실수 없습니다.',

        'no_current_password' => '현재의 비밀번호가 정확하지 않습니다.',
        'password_success' => '비밀번호 갱신이 성공하였습니다.',
        'password_failed' => '비밀번호 갱신이 실패하였습니다.',
    ],

    'affiliate' => [
        'your_code' => '고객님의 제휴코드는 추천자의 제휴코드로 등록할수 없습니다.',

        'failed' => '추천자의 제휴코드 등록이 실패하였습니다. 다시 시도하여 주기 바랍니다.',
        'crypto_failed' => '가상화페 보너스 주소 등록이 실패하였습니다. 다시 시도하여 주기 바랍니다.',

        'success' => '보너스 주소와 추천자 제휴코드가 등록되였습니다.',
    ],

    'select-crypto' => [
        'select' => '가상화페 종류를 선택해주십시오.'
    ],

    'withdrawal' => [
        'success' => '출금신청이 성공하였습니다.',
        'failed' => '출금신청이 실패하였습니다.',
    ],

    'bonus_add_no_info' => '보너스를 받을 BTC주소와 ETH주소를 등록하여주기 바랍니다.',
    'invalid_btc_address' => 'BTC주소가 정확하지 않습니다. 정확한 BTC주소를 등록해주기 바랍니다.',
    'invalid_eth_address' => 'ETH주소가 정확하지 않습니다. 정확한 ETH주소를 등록해주기 바랍니다.',

    'maintenance_notice1' => '서버 유지보수를 위해 출금 신청·KYC의 기능이 일시 정지됩니다. 이해와 협력 부탁드립니다.',
    'maintenance_notice2' => '[정지 기간] 연말연시(12월27일(금) 20:01 ~ 1월6일(월) 9:59)',
];