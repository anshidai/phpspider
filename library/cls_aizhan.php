<?php 

class cls_aizhan
{
	/**
	* 解析采集的数据
	*/
	public static function parseSpider($data, $domain)
	{
		$data = array_map('trim', $data);

		$domainArr = explode('cha/', $domain['url']);
		if($domainArr) {
			$url = end($domainArr);
			$res['domain'] = str_replace(array('https://', 'http://'), '', $url);
		}

		$res['adddate'] = date('Y-m-d H:i:s');
		$res['editdate'] = date('Y-m-d H:i:s');
	
		//网站标题
		if($data['title']) {

		}

		//注册人或公司
		if($data['reg_name']) {

		}

		//注册邮箱
		if($data['reg_email']) {

		}

		//公司性质
		if($data['domain_proper']) {

		}

		//备案信息
		if($data['domain_icp']) {

		}

		//域名年龄
		if($data['domain_age']) {

		}

		//审核时间
		if($data['audit_date']) {

		}

		//服务器ip
		if($data['servers_ip']) {

		}

		//百度pc访问ip
		if($data['baidu_pc_ip']) {

		}

		//百度移动访问量
		if($data['baidu_m_ip']) {

		}

		//百度pc权重
		if($data['baidu_pc_weight']) {

		}

		//百度移动权重
		if($data['baidu_m_weight']) {

		}

		//搜狗权重
		if($data['sougou_weight']) {

		}

		//谷歌权重
		if($data['goole_weight']) {

		}

		//出站链接数
		if($data['out_link']) {

		}

		//首页链接数
		if($data['home_link']) {

		}

		//世界排名
		if($data['alexa_num']) {

		}

		//世界预估日均ip
		if($data['est_day_ip']) {

		}

		//世界预估日均pv
		if($data['est_day_pv']) {

		}


	}

}