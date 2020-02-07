<?php

return [
    'mail' => [
        'verify' => '【QURASダッシュボード】メール認証',
        'verify-failed' => 'メール認証が失敗しました。',
        'success' => 'メール認証が成功しました。',

        'reset_password' => '【QURASダッシュボード】パスワードリセット',

        'withdrawal_confirm' => '【QURASダッシュボード】出金認証',

        'send_failed' => '認証メールの送信が失敗しました。',
    ],

    'kyc' => [
        'upload_failed' => 'ファイルアップロードが失敗しました。',

        'register_succeed' => 'KYC情報が登録されました。情報の確認には最大3日を要しますので、しばらくお待ちください。',
        'register_failed' => 'KYC情報の登録が失敗しました。再び試してみてください。',

        'no_info' => 'KYC情報を登録してください。　KYC認証後にXQCトークンを出金することが可能です。',
        'checking' => 'KYC情報を確認中です。　KYC認証後にXQCトークンを出金することが可能です。',
        'rejected' => '登録したKYC情報が拒否されました。　KYC情報をもう一度登録してください。　KYC認証後にXQCトークンを出金することが可能です。',

        'no_verified' => 'KYC認証後にXQC出金ができます。',
    ],

    'profile' => [
        'success' => 'プロフィール情報が更新されました。',
        'failed' => 'プロフィール更新が失敗しました。',
        'verified' => 'KYCの認証後は、プロフィール情報を更新できません。',

        'no_current_password' => '現在のパスワードが正しくありません。',
        'password_success' => 'パスワードが更新されました。',
        'password_failed' => 'パスワード更新が失敗しました。',
    ],

    'affiliate' => [
        'your_code' => 'お客様のアフィリエイトコードは推薦者のアフィリエイトコードとして登録することができません。',

        'failed' => '推薦者のアフィリエイトコード登録が失敗しました。',
        'crypto_failed' => '暗号通貨ボーナスアドレス登録が失敗しました。',

        'success' => 'ボーナスアドレスと推薦者のアフィリエイトコードが登録されました。',
    ],

    'select-crypto' => [
        'select' => '暗号通貨のタイプをご選択してください。'
    ],

    'withdrawal' => [
        'success' => '出金申請が成功しました。',
        'failed' => '出金申請が失敗しました。',
    ],

    'bonus_add_no_info' => 'ボーナスを得るには,BTCとETHボーナスアドレスを登録してください。',
    'invalid_btc_address' => 'BTCアドレスが正しくありません。正確なBTCアドレスをご入力してください。',
    'invalid_eth_address' => 'ETHアドレスが正しくありません。正確なETHアドレスをご入力してください。',

    'maintenance_notice1' => 'サーバーメンテナンスのため、出金申請・KYCの機能が一時停止します。ご理解とご協力の程、よろしくお願い申し上げます。',
    'maintenance_notice2' => '「停止期間」　年末年始（12月27日（金）20:01 ~ 1月6日（月）9：59まで）',
];