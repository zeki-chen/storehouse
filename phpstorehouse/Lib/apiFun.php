<?php
/**
 * 生成参数列表,以数组形式返回
 */
function yc_param_lable($tag=''){
    $param = array();
    $array = explode(';',$tag);
    foreach ($array as $v){
        $v=trim($v);
        if(!empty($v)){
            list($key,$val) = explode(':',$v);
            $param[trim($key)] = trim($val);
        }
    }
    return $param;
}

/**
 * 返回符合条件的所有分类
 * @param $tag
 * field:返回字段，默认为返回全部字段
 * limit:返回数据数量，默认为返回所有数据
 * order:排序，默认为排序升序，添加时间降序
 * where:条件，默认为空
 * model_id:模型id，默认为0，返回空
 * cid:分类id，默认为空
 * pid:父类id，默认为空
 * @return $mixed
 */
function yc_get_terms($tag){
    $tag=yc_param_lable($tag);
    $field = !empty($tag['field']) ? $tag['field'] : '*';
    $limit = !empty($tag['limit']) ? $tag['limit'] : '';
    $order = !empty($tag['order']) ? $tag['order'] : 'sort asc,addtime desc';
    if(!empty($tag['where'])){
        $where[]=$tag['where'];
    }
    $model_id = !empty($tag['model_id']) ? $tag['model_id'] : 0;
    if(!empty($tag['cid'])){
        $where['cid']=$tag['cid'];
    }
    if(!empty($tag['pid'])){
        $where['pid']=$tag['pid'];
    }
    $where['model_id']=$model_id;
    $where['valid'] = array('eq',1);
    $list=M('art_class')
        ->field($field)
        ->where($where)
        ->limit($limit)
        ->order($order)
        ->select();
    $list['count']=count($list);
    // dump($list);
    return $list;
}


/**
 * 返回文章内容
 * @param $model_id 模型id
 * @param $aid 文章id
 * @return mixed
 */
function yc_get_art($model_id, $aid){
    $where['model_id']=$model_id;
    $where['aid']=$aid;
    $where['is_show']=1;
    $model=M('art')->where($where)->find();
    if(!empty($model['media'])){
        $model['media']=unserialize($model['media']);
    }
    if(!empty($model['pic'])){
        $model['pic']=unserialize($model['pic']);
    }
    // dump($model);
    return $model;
}

/**
 * 返回符合条件的数据集
 * @param $tag
 * @param $type
 * field:返回字段，默认为返回全部字段
 * order:排序，默认为排序升序，发布时间降序
 * where:条件，默认为空
 * pageSize:分页大小
 * model_id:模型id，默认为0，返回空
 * @return mixed
 */
function yc_get_artList($tag){
    $tag=yc_param_lable($tag);
    $field = !empty($tag['field']) ? $tag['field'] : '*';
    $pageSize = !empty($tag['pageSize']) ? $tag['pageSize'] : C('PAGE_SIZE');
    $order = !empty($tag['order']) ? $tag['order'] : 'is_top desc,sort asc,pubdate desc,addtime desc';
    $model_id = !empty($tag['model_id']) ? $tag['model_id'] : 0;
    if(!empty($tag['cid'])){
        //获取当前分类下的所有子分类
        $whereM['model_id'] = $model_id;
        $whereM['valid'] = 1;
        $modelClass = M('art_class')->where($whereM)->order("pid asc")->field("cid,pid")->select();
        $childList='';
        foreach($modelClass as $k=>$v){
            if($v['cid']==$tag['cid']){//分类有效，查找子分类
                $childList = array_merge(array($tag['cid']),getCidList($modelClass, $tag['cid']));
                break;
            }
        }
        $where['cid']=array('in',$childList);
    }
    $where['model_id']=$model_id;
    $class_valid=M('model')->where('model_id='.$model_id)->getField('art_class');
    if($class_valid){
        $where['class_valid']=1;
    }
    $where['status'] = array('eq',1);
    // print_r($order);

    $list=D('ArtView')
        ->field($field)
        ->where($where)
        ->order($order)
        ->limit ($pageSize)
        ->select();
    foreach ($list as $k=>$v){
        $list[$k]['media']=unserialize($v['media']);
        $list[$k]['pic']=unserialize($v['pic']);
        if($v['video_type']==1){
            $list[$k]['video']=unserialize($v['video']);
        }
    }
    // print_r($list);
    return $list;
}

/**
 * 返回符合条件的列表页
 * @param $tag
 * @param $type
 * field:返回字段，默认为返回全部字段
 * order:排序，默认为排序升序，发布时间降序
 * where:条件，默认为空
 * pageSize:分页大小
 * model_id:模型id，默认为0，返回空
 * @return mixed
 */
function yc_get_list($tag,$type='pc'){
    $tag=yc_param_lable($tag);
    $field = !empty($tag['field']) ? $tag['field'] : '*';
    $pageSize = !empty($tag['pageSize']) ? $tag['pageSize'] : C('PAGE_SIZE');
    $order = !empty($tag['order']) ? $tag['order'] : 'sort asc,pubdate desc,addtime desc';
    $model_id = !empty($tag['model_id']) ? $tag['model_id'] : 0;
    if(!empty($tag['cid'])){
        //获取当前分类下的所有子分类
        $whereM['model_id'] = $model_id;
        $whereM['valid'] = 1;
        $modelClass = M('art_class')->where($whereM)->order("pid asc")->field("cid,pid")->select();
        $childList='';
        foreach($modelClass as $k=>$v){
            if($v['cid']==$tag['cid']){//分类有效，查找子分类
                $childList = array_merge(array($tag['cid']),getCidList($modelClass, $tag['cid']));
                break;
            }
        }
        $where['cid']=array('in',$childList);
    }
    $where['model_id']=$model_id;
    $where['status'] = array('eq',1);
    $where['class_valid']=1;
//	print_r($where);
    $count=D('ArtView')->where($where)->count();
    if($type=='m'){
        $Page=new \Think\PageM($count,$pageSize);
    }else{
        $Page=new \Think\PageNew($count,$pageSize);
    }
    $show=$Page->shows();
    $list['list']=D('ArtView')
        ->field($field)
        ->where($where)
        ->order($order)
        ->limit ($Page->firstRow.','.$Page->listRows)
        ->select();
    $list['page']=$show;
    $list['count']=$count;
    foreach ($list['list'] as $k=>$v){
        $list['list'][$k]['media']=unserialize($v['media']);
        $list['list'][$k]['pic']=unserialize($v['pic']);
        if($v['video_type']==1){
            $list['list'][$k]['video']=unserialize($v['video']);
        }
    }
//	 dump($list);
    return $list;
}

/**
 * 获取友情链接
 * @param $tag
 * field:返回字段，默认为返回全部字段
 * order:排序，默认为排序升序，添加时间降序
 * where:条件
 * cid:分类id
 * @return bool
 */
function yc_get_links($tag){
    $tag=yc_param_lable($tag);
    $field=!empty($tag['field'])?$tag['field']:'*';
    $order=!empty($tag['order'])?$tag['order']:'sort asc,addtime desc';
    $limit=!empty($tag['limit'])?$tag['limit']:'8';
//	$cid=!empty($tag['cid'])?$tag['cid']:0;
//	$className=M('member_class')->where("cid=$cid and valid=1")->find();
//	if(!$className){
//		return false;
//	}
    if(!empty($tag['cid'])) {
        $where['cid'] = $tag['cid'];
    }
    $where['is_show'] = array('eq',1);
    $list=M('member')
        ->field($field)
        ->where($where)
        ->order($order)
        ->limit($limit)
        ->select();
    $list['count']=count($list);
//	$list['class_name']=$className['class_name'];
//	 dump($list);
    return $list;
}

/**
 * 获取留言列表
 * @param $tag
 * @param $type
 * field:返回字段，默认为返回全部字段
 * order:排序，默认为添加时间降序
 * pageSize:分页大小
 * status:留言状态
 * @return mixed
 */
function yc_get_feedback($tag,$type='pc'){
    $tag=yc_param_lable($tag);
    $field=!empty($tag['field'])?$tag['field']:'*';
    $pageSize=!empty($tag['pageSize'])?$tag['pageSize']:C('PAGE_SIZE');
    $order=!empty($tag['order'])?$tag['order']:'addtime desc';
//	$status=!empty($tag['status'])?$tag['status']:'1';
//	$where['status']=array('eq',1);
    if(!empty($tag['where'])){
        $where[]=$tag['where'];
    }
    $where['is_show']=array('eq',0);
    $count=M('feedback')->where($where)->count();
    if($type=='m'){
        $Page=new \Think\PageM($count,$pageSize);
    }else{
        $Page=new \Think\PageNew($count,$pageSize);
    }
    $show=$Page->shows();
    $list['list']=M('feedback')
        ->field($field)
        ->where($where)
        ->order($order)
        ->limit ($Page->firstRow.','.$Page->listRows)
        ->select();
    $list['page']=$show;
    $list['count']=$count;
    // dump($list);
    return $list;
}

/**
 * 添加留言
 * @return bool
 */
function yc_add_feedback(){
    $data=requestPost();
    $data['status']=0;
    $data['addtime']=time();
    $res=M('feedback')->data($data)->add();
    return $res?true:false;
}

/**
 * 获取指定的调查及其选项
 * @param $sid
 * @return bool
 */
function yc_get_survey($sid){
    $survey=M('survey')->where("sid=$sid and is_show=1")->find();
    if(!$survey){
        return false;
    }
    $where['sid']=$sid;
    $order="sort asc";
    $list=M('survey_option')
        ->where($where)
        ->order($order)
        ->select();
    $survey['options']=$list;
    // dump($survey);
    return $list;
}

/**
 *获取导航
 */
function yc_get_nav(){
    $M=M('nav');
    $where['pid']=0;
    $where['is_show']=1;
    $orderby="sort asc,addtime desc";
    $navList=$M->where($where)->order($orderby)->select();
    foreach($navList as $k=>$v){
        $whereS['pid']=$v['nid'];
        $whereS['is_show']=1;
        $navList[$k]['sub']=$M->where($whereS)->order($orderby)->select();
    }
    // print_r($navList);
    return $navList;
}

/**
 *获取导航
 */
function yc_get_nav_new(){
    $where['code']='nav';
    $navList=M('config')->where($where)->find();
    $navList=unserialize($navList['content']);
//    print_r($navList);
    return $navList;
}

/**
 * 处理导航链接
 * @param $url
 * @return str
 */
function dealNavLink($url){
    $root=__ROOT__;
    return str_replace('Root',$root,$url);
}

/*
 * 获取快速通道
 */
function get_fast_track(){
    $M=M('model');
    $where['valid']=1;
    $where['is_fast']=1;
    $orderby="sort asc,addtime desc";
    $fastList=$M->where($where)->order($orderby)->select();
    return $fastList;
}


/**
 * 获取面包屑
 */
function yc_get_bread(){
    $nid=I('get.nid',0);
    if($nid<=0){
        return null;
    }
    $where['nid']=$nid;
    $M=M('nav');
    $model=$M->where($where)->find();
    $whereP['nid']=array('in',$model['pids']);
    $orderby="nid asc";
    $bread=$M->where($whereP)->order($orderby)->select();
    return $bread;
}

/**
 * 获取分类的所有子分类
 * @param $data
 * @param int $pid
 * @param string $id
 * @param string $pidkey
 * @return array
 */
function getCidList(&$data,$pid=0,$id='cid',$pidkey='pid'){
    $arr=array();
    foreach($data as $k=>$v){
        if($v[$pidkey]==$pid){
            $arr[]=$v[$id];
            $arr=array_merge($arr,getCidList($data,$v[$id],$id,$pidkey));
        }
    }
    return $arr;
}

/**
 * 获取当前文章的上一篇和下一篇文章
 * @param $table 表名
 * @param int $id 文章id
 * @param string $where 条件
 * @param string $orderby 排序
 * @return array
 */
function getPreAndNext($table,$id,$where,$orderby){
    $sql='select * from  (
			SELECT @rownum:=@rownum+1 AS rownum, art.* 
				FROM (SELECT @rownum:=0) r, '.$table.' as art
			where '.$where.'
			ORDER BY '.$orderby.'
		) as t
		where t.aid  ='.$id;
    $model=M()->query($sql);

    $rownum=intval(current($model)['rownum']);//当前文章在列表页的序号

    //上一篇
    $sql='select * from  (
			SELECT @rownum:=@rownum+1 AS rownum, art.* 
				FROM (SELECT @rownum:=0) r, '.$table.' as art
			where '.$where.'
			ORDER BY '.$orderby.'
		) as t
		where t.rownum ='.($rownum-1);
    $prev=M()->query($sql);

    //下一篇
    $sql='select * from  (
			SELECT @rownum:=@rownum+1 AS rownum, art.* 
				FROM (SELECT @rownum:=0) r, '.$table.' as art
			where '.$where.'
			ORDER BY '.$orderby.'
		) as t
		where t.rownum ='.($rownum+1);
    $next=M()->query($sql);
    return array('prev'=>current($prev),'next'=>current($next));
}

?>