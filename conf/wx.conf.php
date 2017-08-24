<?php
return $wx=[
     // 是否输出 SDK 日志
    "EnableOutputLog" => FALSE,
    // SDK 日志输出目录
    "LogPath" =>'',
    // SDK 日志输出级别
    "LogThreshold" => 0,
    // SDK 日志输出级别（数组）
    "LogThresholdArray" => array(),
    // 当前使用 SDK 服务器的主机，该主机需要外网可访问
    "ServerHost" => 'http://192.168.1.101:8000',
    // 鉴权服务器服务地址
    "AuthServerUrl" => '',
    // 信道服务器服务地址
    "TunnelServerUrl" => '',
    // 和信道服务器通信的签名密钥，该密钥需要保密
    "TunnelSignatureKey" => '',
    // 信道服务通信是否需要校验签名
    "TunnelCheckSignature" => TRUE,
    // 网络请求超时时长（单位：毫秒）
    "NetworkTimeout" => 30000
];

