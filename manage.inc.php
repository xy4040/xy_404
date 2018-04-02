<?php
defined('IN_YuLin') || exit('NO PERMIT!');

switch ($a) {
	case 'send':
		$o = intval($_GET['o']);
		if(!$o){
			$tpl->display($m.'/'.$a);			
		}
		if(IS_POST){
			$table = Table('hd');
			$data['title'] = $_POST['title'];
			$data['scoure'] = $_POST['scoure'];
			$data['contents'] = $_POST['contents'];
			$data['inputtime'] = time();
	        $res = $db->exec('INSERT INTO '.$table.CreateInsertSql($data));
	        // echo json_encode($res);
	        ShowMsg('操作成功',U($m.'/manage'));
		}
		break;
	
	default:
		$tpl->display($m.'/'.$c);
		break;
}


