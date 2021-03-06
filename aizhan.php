<?php
                                 
ini_set("memory_limit", "1024M");

require dirname(__FILE__).'/core/init.php';
require dirname(__FILE__).'/functions.php';

$configs = array(
	'name' => 'aizhan',
	
	//同时工作的爬虫任务数, 需要配合redis保存采集任务数据，供进程间共享使用
	//tasknum默认值为1，即单进程任务爬取
	'tasknum' => 1,
	
	//爬虫爬取每个网页的时间间隔 单位：毫秒
	'interval' => 10000,
	
	//爬虫爬取每个网页的超时时间 单位：秒 timeout默认值为5秒
	
	//代理设置
	//'proxy' => 'http://lba8610:9rg4cjuf@112.74.198.237:16816',
	
	//爬虫爬取网页所使用的伪IP，用于破解防采集
	//'client_ip' => '192.168.0.2', //单个ip
	
	//爬虫爬取网页所使用的随机伪IP，用于破解防采集
	'client_ips' => dirname(__FILE__).'/config/client_ips.php',
	
	//爬虫爬取数据导出 
	//type：导出类型 csv、sql、db
	//file：导出 csv、sql 文件地址
	//table：导出db、sql数据表名
	'export' => array(
		'type' => 'db', 
		'table' => 'pre_domain_info',
    ),
	
	//true时显示调试信息 false时显示爬取面板
	'log_show' => false, 
	
	//日志文件路径 默认 ./data/phpspider.log
	//'log_file' => '/home/libaoan/aizhan_spider_'.date('Y-m-d').'.log', 
	
	//显示和记录的日志类型 info:普通 warn:警告 debug:调试 error:错误
	'log_type' => 'error,info', 
	
	//定义爬虫爬取哪些域名下的网页, 非域名下的url会被忽略以提高爬取速度
	'domains' => array(
		'www.aizhan.com',
	),
	
	//定义爬虫的入口链接, 爬虫从这些链接开始爬取,同时这些链接也是监控爬虫所要监控的链接
	'scan_urls' => array(
		'http://www.aizhan.com/cha/www.baiyunpiaopiao.com/',
	),
	
	//定义列表页url的规则
	/*
	'list_url_regexes' => array(
		//'http://www.panduoduo.net/u/bd/\d+',
		'http://www.panduoduo.net/u/bd/1',
	),
	*/
	
	//定义内容页url的规则
	'content_url_regexes' => array(
        "http://www.aizhan.com/cha/.*/$",
    ),
	
	//定义内容页的抽取规则
	'fields' => array(
		//网站标题
		array(
			'name' => 'title',
			'selector' => '//*[@id="title"]',
			//'required' => true,
		),

        //注册人或公司
		array(
			'name' => 'reg_name',
			'selector' => '//*[@id="icp_company"]/',
			//'required' => true,
		),
		//注册邮箱
		array(
			'name' => 'reg_email',
			'selector' => '//*[@id="whois_email"]/img',
			//'required' => true,
		),
		//公司性质
		array(
			'name' => 'domain_proper',
			'selector' => '//*[@id="icp_type"]/',
			//'required' => true,
		),
		//备案信息
		array(
			'name' => 'domain_icp',
			'selector' => '//*[@id="icp_icp"]/',
			//'required' => true,
		),
		//域名年龄
		array(
			'name' => 'domain_age',
			'selector' => '//*[@id="whois_created"]/',
			//'required' => true,
		),
		//审核时间
		array(
			'name' => 'audit_date',
			'selector' => '//*[@id="icp_passtime"]/',
			//'required' => true,
		),
		//服务器ip
		array(
			'name' => 'servers_ip',
			'selector' => '//*[@id="dns_info"]/',
			//'required' => true,
		),


		//百度pc访问ip
		array(
			'name' => 'baidu_pc_ip',
			'selector' => '//*[@id="baidurank_ip"]/img',
		),
		
		//百度移动访问量
		array(
			'name' => 'baidu_m_ip',
			'selector' => '//*[@id="baidurank_m_ip"]/img',
		),

		//百度pc权重
		array(
			'name' => 'baidu_pc_weight',
			'selector' => '//*[@id="baidurank_br"]/img',
		),
		
		//百度移动权重
		array(
			'name' => 'baidu_m_weight',
			'selector' => '//*[@id="baidurank_mbr"]/img',
		),
		//搜狗权重
		array(
			'name' => 'sougou_weight',
			'selector' => '//*[@id="sogou_pr"]/img',
		),
		//谷歌权重
		array(
			'name' => 'goole_weight',
			'selector' => '//*[@id="google_pr"]/img',
		),
		
		
		//出站链接数
		array(
			'name' => 'out_link',
			'selector' => '//*[@id="webpage_link_o"]',
		),
		
		//首页链接数
		array(
			'name' => 'home_link',
			'selector' => '//*[@id="webpage_link_i"]',
		),
		
		//世界排名
		array(
			'name' => 'alexa_num',
			'selector' => '//*[@id="alexa_rank"]/a',
		),
		//世界预估日均ip
		array(
			'name' => 'est_day_ip',
			'selector' => '//*[@id="alexa_ip"]/a',
		),
		
		//世界预估日均pv
		array(
			'name' => 'est_day_pv',
			'selector' => '//*[@id="alexa_pv"]/a',
		),
		
	),
);

$spider = new phpspider($configs);

$spider->on_scan_page = function($page, $content, $phpspider)
{
    $phpspider->add_url('http://www.aizhan.com/cha/jupeixun.cn/');    
    
};


/**
* 判断http状态码 判断当前网页是否被反爬虫
* @param $status_code 当前网页的请求返回的HTTP状态码
* @param $url 当前网页URL
* @param $content 当前网页内容
* @param $phpspider 爬虫对象
* @return $content 返回处理后的网页内容，不处理当前页面请返回false
*/
$spider->on_status_code = function($status_code, $url, $content, $phpspider)
{
	if($status_code != '200') {
		//将url插入待爬的队列中,等待再次爬取
		$phpspider->add_url($url);
		
		//当前页先不处理了
		return false;
	}
	
	//不拦截的状态码这里记得要返回，否则后面内容就都空了
	return $content;
};

/**
* 判断当前网页是否被反爬虫
* @param $url 当前网页的url
* @param $content 当前网页内容
* @param $phpspider 爬虫对象
* @return 如果被反爬虫了, 返回true, 否则返回false
*/
$spider->is_anti_spider = function($url, $content, $phpspider)
{
	$halt = checkRequestFail($content);
	if($halt) {
		//将url插入待爬的队列中,等待再次爬取
		$phpspider->add_url($url);
		
		//告诉框架网页被反爬虫了，不要继续处理它
		return true;
	}
	
	return false;
};

/**
* 在一个网页的所有field抽取完成之后, 可能需要对field进一步处理
* @param $page 当前下载的网页页面的对象
	@param $page['url'] 当前网页的URL
	@param $page['raw'] 当前网页的内容
	@param $page['request'] 当前网页的请求对象
	
* @param $data 当前网页抽取出来的所有field的数据
* @return 返回处理后的数据, 注意数据类型需要跟传进来的$data类型匹配
*/
$spider->on_extract_page = function($page, $data)
{
	$data = array_map('trim', $data);
	
	$urlArr = explode('cha/', $page['url']);


	//var_dump($data);exit;

	if($urlArr) {
		$url = end($urlArr);
		$data['domain'] = str_replace(array('https://', 'http://'), '', $url);
	}
	$data['adddate'] = date('Y-m-d H:i:s');
	$data['editdate'] = date('Y-m-d H:i:s');
	
	//alexa预估流量
	$data['alexa_ippv'] = str_replace('相关数据不充分，无法统计。', '', $data['alexa_ippv']);
	if(!empty($data['alexa_ippv'])) {
		$alexa_ippv = trim(str_replace(array('IP≈','PV≈'), '', $data['alexa_ippv']));
		$alexa_ippv = explode(' ', $alexa_ippv);
		$data['alexa_ip'] = $alexa_ippv[0]? getPvInt($alexa_ippv[0]): 0;
		$data['alexa_pv'] = $alexa_ippv[1]? getPvInt($alexa_ippv[1]): 0;
	}
	
	//预计来路
	$data['baidu_ipv'] = str_replace('较少', '', $data['baidu_ipv']);
	if(!empty($data['baidu_ipv']) && strpos($data['baidu_ipv'], '~') !== false) {
		$baidu_ipv = explode('~', $data['baidu_ipv']);
		$baidu_ipv = array_map('trim', $baidu_ipv);
		$data['baidu_ipv_min'] = $baidu_ipv[0]? intval($baidu_ipv[0]): 0;
		$data['baidu_ipv_max'] = $baidu_ipv[1]? intval($baidu_ipv[1]): 0;
	}
	
	//域名年龄
	$json = contentSubstr('<script type="text/javascript">set_whois(', ');</script>', $page['raw']);
	if(!empty($json)) {
		$json = json_decode($json, true);
		$data['createdate'] = $json['created']? $json['created']: '0000-00-00';
	}
	
	return $data;
};


/**
* 当一个field的内容被抽取到后进行的回调, 在此回调中可以对网页中抽取的内容作进一步处理
* @param $fieldname 当前field的name. 注意: 子field的name会带着父field的name, 通过.连接.
* @param $data 当前field抽取到的数据. 如果该field是repeated, data为数组类型, 否则是String
* @param $page 当前下载的网页页面的对象
	@param $page['url'] 当前网页的URL
	@param $page['raw'] 当前网页的内容
	@param $page['request'] 当前网页的请求对象
	
* @return 返回处理后的数据, 注意数据类型需要跟传进来的$data类型匹配
*/
$spider->on_extract_field = function($fieldname, $data, $page)
{
	if(in_array($fieldname, array('alexa_pr','baidu_pc_pr','baidu_m_pr'))) {
		$data = getRankPr($data);
	}elseif(in_array($fieldname, array(
		'baidu_index',
		'baidu_record',
		'baidu_out_link',
		'google_record',
		'google_out_link',
		'so360_record',
		'so360_out_link',
		'sogou_record',
		'sogou_out_link',
		))) {
			
		$data = getPvInt($data);
	}
	
	return $data;
};

/**
* 入库操作 
*/
$spider->on_insert_db = function($data, $page, $phpspider)
{
    $data['domain'] = trim($data['domain']);
    $data['title'] = trim($data['title']);
    $data['baidu_ipv'] = trim($data['baidu_ipv']);
    $data['alexa_ippv'] = trim($data['alexa_ippv']);
    if(!empty($data['domain']) && !empty($data['title']) && (!empty($data['alexa_ippv']) || !empty($data['baidu_ipv']))) {
        if(!db::get_one("select id from ".phpspider::$export_table." where domain_md5='".md5($data['domain'])."'")) {
            db::insert(phpspider::$export_table, $data);    
        }        
    }
};


$spider->start();




