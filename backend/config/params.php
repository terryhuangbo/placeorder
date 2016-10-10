<?php
/**
 * 后台专用配置文件
 */
return [
    'adminEmail' => 'admin@vsochina.com',
    //后台权限模块专用的公司列表
    'lhtxcompany' => [1 => '超级管理员', 2 => '管理员', 3 => '运营管理员'],
    // redis缓存时间，一年，单位秒
    'redis_expire_time_year' => 86400 * 365,
    // redis缓存时间，一个月，单位秒
    'redis_expire_time_month' => 86400 * 30,
    // redis缓存时间，一周，单位秒
    'redis_expire_time_week' => 86400 * 7,
    // redis缓存时间，一天，单位秒
    'redis_expire_time_day' => 86400,
    // redis缓存时间，一小时，单位秒
    'redis_expire_time_hour' => 3600,
    // 任务模块赠送积分的时间周期，秒
    'point_task_cycle' => 360,
    // 信用配置中redis的缓存时间，秒
    'trust_config_expire_time' => 60,
    //行业分类redis缓存消失时间
    'catExpireTime' => 7 * 24 * 3600,
    //获取用户信息接口
    'userinfoapi' => 'http://api.vsochina.com/user/info/view',
    //用户搜索接口
    'usersearchapi' => 'http://api.vsochina.com/user/user/search-users',
    //获得新老分类对应数据接口
    'categoryapi' => 'https://api.vsochina.com/category/category/map',

    //审核不通过的原因字数限制
    'checkdeny_reason_limit' => 500,
    //后端上传图片方法
    'uploader_url' => '/common/upload/upload',
    //后端上传图片路径
    'img_save_dir' => '/upload',



];