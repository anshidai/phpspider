<?php 

/**
* 获取pr值
*/
function getRankPr($data)
{
	$pr = 0;
	if(preg_match('/pr\/pr(\d+)\.gif/', $data, $match)) {
		$pr = intval($match[1]);
	}
	
	return $pr;
}

function getPvInt($data)
{
	return intval(str_replace(',', '', $data));
}

function checkRequestFail($content)
{
	if(
		strpos($content, '查询太频繁了，休息一下吧') !== false ||
		strpos($content, '<h1>400 Bad Request</h1>') !== false || 
		strpos($content, '<title>404 Not Found</title>') !== false || 
		strpos($content, '500 Internal Server Error') !== false || 
		strpos($content, '301 Moved Permanently') !== false 
	) {
		return true;
	}
	
	return false;
}

/**
* 字符串截取方式获取指定区域内容 
* @param string $startTag 开始区域
* @param string $endTag 结束区域
* @param string $content 在该字符串中进行查找
*/
function contentSubstr($startTag, $endTag, $content)
{
	$startlen = strpos($content, $startTag);
	if($startlen === false) {
		return '';
	}
	$startlen = $startlen + strlen($startTag);
	$endLen = strpos($content, $endTag, $startlen);
	if($endLen === false) {
		return '';
	}
	return trim(substr($content, $startlen, $endLen - $startlen));    
}

/**
* 正则截取内容 
* @param string $pattern 正则表达式
* @param string $content 在该字符串中进行查找
* @param int $pos 对应正则获取位置
*/
function contentPreg($pattern, $content, $pos = 1)
{
	$data = '';
	if(preg_match($pattern, $content, $match)) {
		$data = trim($match[$pos]);
	}
	return $data;
}

