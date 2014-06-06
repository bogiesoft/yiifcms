<?php
/**
 * 
 * 后端控制基础类  
 * @author zhaojinhan <326196998@qq.com>
 * @copyright Copyright (c) 2014-2015 Personal. All rights reserved.
 * @version v1.0.0
 * 
 */
class BackendBase extends Controller
{
	/**
	 * 后端布局
	 * @var $layout
	 */
	public $layout=''; //default 'main'
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	*/
	public $breadcrumbs=array();	
		
	protected  $_static_admin = ''; //后端样式目录
	public function init(){
		parent::init();
		$this->_static_admin = Yii::app()->params['static']['admin'];
	}
	
	/**
	 * 登录验证
	 *
	 */
	public function auth(){
		if (isset($_POST['sessionId'])) {
			$session = Yii::app()->getSession();
			$session->close();
			$session->sessionID = $_POST['sessionId'];
			$session->open();
		}
		if(Yii::app()->user->getIsGuest()){
			$loginUrl = $this->createUrl('/admin/default/login');	
			$this->rediretParentUrl($loginUrl);
		}
	}	
	
	
	/**
	 * 引用字符串
	 * @param  $string
	 * @param  $force
	 * @return string
	 */
	static function addslashes($string, $force = 1) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = self::addslashes($val, $force);
			}
		} else {
			$string = addslashes($string);
		}
		return $string;
	}
	
	/**
	 * 获得来源类型 post get
	 *
	 * @return unknown
	 */
	static public function method() {
		return strtoupper( isset( $_SERVER['REQUEST_METHOD'] ) ? $_SERVER['REQUEST_METHOD'] : 'GET' );
	}
	
	/**
	 * 格式化单位
	 */
	static public function byteFormat( $size, $dec = 2 ) {
		$a = array ( "B" , "KB" , "MB" , "GB" , "TB" , "PB" );
		$pos = 0;
		while ( $size >= 1024 ) {
			$size /= 1024;
			$pos ++;
		}
		return round( $size, $dec ) . " " . $a[$pos];
	}
	
	/**
	 * 下拉框，单选按钮 自动选择
	 *
	 * @param $string 输入字符
	 * @param $param  条件
	 * @param $type   类型
	 * selected checked
	 * @return string
	 */
	static public function selected( $string, $param = 1, $type = 'select' ) {
	
		if ( is_array( $param ) ) {
			$true = in_array( $string, $param );
		}elseif ( $string == $param ) {
			$true = true;
		}
		if ( $true )
			$return = $type == 'select' ? 'selected="selected"' : 'checked="checked"';
	
		echo $return;
	}
	
}