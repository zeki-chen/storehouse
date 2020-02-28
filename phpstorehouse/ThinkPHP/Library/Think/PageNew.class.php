<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Think;

class PageNew {

    // 分页栏每页显示的页数
    public $rollPage = 5;
    // 页数跳转时要带的参数
    public $parameter  ;
    // 分页URL地址
    public $url   =   '';
    // 默认列表每页显示行数
    public $listRows = 20;
    // 起始行数
    public $firstRow    ;
    // 分页总页面数
    protected $totalPages  ;
    // 总行数
    protected $totalRows  ;
    // 当前页数
    protected $nowPage    ;
    // 分页的栏的总页数
    protected $coolPages   ;
    // 分页显示定制
    protected $config  =    array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'第一页','last'=>'最后一页','theme'=>'%FIRST%%LINK_PAGE%%END%%DOWN_PAGE%%UP_PAGE%');
    // 默认分页变量名
    protected $varPage;


    /**
     * 架构函数
     * @access public
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     */
    public function __construct($totalRows,$listRows='',$parameter='',$url='') {
        $this->totalRows    =   $totalRows;
        $this->parameter    =   $parameter;
        $this->varPage      =   C('VAR_PAGE') ? C('VAR_PAGE') : 'p' ;
        if(!empty($listRows)) {
            $this->listRows =   intval($listRows);
        }
        $this->totalPages   =   ceil($this->totalRows/$this->listRows);     //总页数
        $this->coolPages    =   ceil($this->totalPages/$this->rollPage);
        $this->nowPage      =   !empty($_GET[$this->varPage])?intval($_GET[$this->varPage]):1;
        if($this->nowPage<1){
            $this->nowPage  =   1;
        }elseif(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage  =   $this->totalPages;
        }
        $this->firstRow     =   $this->listRows*($this->nowPage-1);
    }

    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }

    public function shows()
    {
        $adjacents=2;
        if(0 == $this->totalRows) return '';
        $p              =   $this->varPage;
        $nowCoolPage    =   ceil($this->nowPage/$this->rollPage);

        // 分析分页参数
        if($this->url){
            $depr       =   C('URL_PATHINFO_DEPR');
            $url        =   rtrim(U('/'.$this->url,'',false),$depr).$depr.'__PAGE__';
        }else{
            if($this->parameter && is_string($this->parameter)) {
                parse_str($this->parameter,$parameter);
            }elseif(is_array($this->parameter)){
                $parameter      =   $this->parameter;
            }elseif(empty($this->parameter)){
                unset($_GET[C('VAR_URL_PARAMS')]);
                $var =  !empty($_POST)?$_POST:$_GET;
                if(empty($var)) {
                    $parameter  =   array();
                }else{
                    $parameter  =   $var;
                }
            }
            $parameter[$p]  =   '__PAGE__';
            $url            =   U('',$parameter);
        }

        //上下翻页字符串
        $upRow          =   $this->nowPage-1;
        $downRow        =   $this->nowPage+1;

        $pages = '';
        //第一页
        if($this->nowPage>=($adjacents+2)) {
            $pages.= "<a class='first_page' href='".str_replace('__PAGE__',1,$url)."'>首页</a>";
        }

        //上一页
        if ($upRow>0){
            $pages.=   "<a href='".str_replace('__PAGE__',$upRow,$url)."' class='prev_page'>".$this->config['prev']."</a>";
        }else{
            // $pages.=   "<a class='prev-page'>".$this->config['prev']."</a>";
        }

        // 添加省略号
        if($this->nowPage>($adjacents+1)) {
            $pages.= "<a>...</a>";
        }

        //12345
        $pmin = ($this->nowPage>$adjacents) ? ($this->nowPage-$adjacents) : 1;
        $pmax = ($this->nowPage<($this->totalPages-$adjacents)) ? ($this->nowPage+$adjacents) : $this->totalPages;
        for($i=$pmin; $i<=$pmax; $i++) {
            if($i==$this->nowPage) {
                $pages.= "<a class='num current'>".$i."</a>";
            }else{
                $pages.= "<a class='num' href='".str_replace('__PAGE__',$i,$url)."'>".$i."</a>";
            }
        }

        //添加省略号
        if($this->nowPage < ($this->totalPages-$adjacents)) {
            $pages.= "<a>...</a>";
        }


        //下一页
        if ($downRow <= $this->totalPages){
            $pages.=   "<a href='".str_replace('__PAGE__',$downRow,$url)."' class='next_page'>".$this->config['next']."</a>";
        }else{
            // $pages.=   "<a  class='next-page'>".$this->config['next']."</a>";
        }

        //最后一页
        if($this->nowPage < ($this->totalPages-$adjacents)) {
            $pages.= "<a class='last_page' href='".str_replace('__PAGE__',$this->totalPages,$url)."'>末页</a>";
        }

        //总页数
        // if($this->nowPage<($this->totalPages+1)) {
        //     $pages.= "&nbsp;第".$this->nowPage."/".$this->totalPages."页";
        // }

        if ($this->totalPages > 1){
            return $pages;
        }
    }

}
