<?php

namespace Admin\Controller;

use Think\Controller;

class SysDataController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->addBread("安全管理");
    }

    public function index()
    {
        $this->checkPower("DataBakView");
        $this->addBread("数据备份");
        $this->assign('title', '数据备份');
        $this->assign("bread", $this->bread);
        cookie("backurl", get_url());
        $dir = dirname($_SERVER['SCRIPT_FILENAME']) . "/databak/";
        $fileArr = scandir($dir);
        $filesArr = array();
        $keyword = I('get.keyword');
        $sort = array();
        foreach ($fileArr as $k => $v) {
            $file = iconv('GB2312', 'UTF-8', $v);
            $data['ext'] = end(explode('.', $file));
            if (empty($data['ext'])) {
                continue;
            }
            if (!($keyword == "" || $keyword == null)) {
                if (!strstr($file, $keyword)) {
                    continue;
                }
            }
            $data['name'] = $file;
            $data['path'] = $dir . $file;
            $data['url_path'] = urlencode(base64_encode($dir . $file));
            $data['doRecovery'] = U('SysData/doRecovery', array('path' => $data['url_path']));
            $data['doDel'] = U('SysData/doDel', array('ids' => $data['url_path']));
            //获取文件修改时间
            $data['addtime'] = filectime($data['path']);
            $data['addtime'] = date('Y-m-d H:i:s', $data['addtime']);
            $sort[] = filectime($data['path']);
            $data['size'] = filesize($data['path']);
            $data['size'] = format_bytes($data['size']);
            $data['ext'] = end(explode('.', $file));
            $filesArr[] = $data;
        }
        array_multisort($sort, SORT_DESC, $filesArr);
        $count = count($filesArr);
        $pageSize = C('PAGE_SIZE');
        $list['page'] = ceil($count / $pageSize);
        $list['pageSize'] = $pageSize;
        $list['data'] = $filesArr;
        $list['count'] = count($filesArr);
        $filesArr = json_encode($list);
//        dump($filesArr);
        $this->assign('keyword', $keyword);
        $this->assign("list", $filesArr);
        $this->saveLog("查看数据备份", "view");
        $this->display();
    }

    //备份
    public function doBak()
    {
        $this->checkPower("DataBakAdd");
        vendor('DBExport');
        $str = \DBExport::ExportAllData();
        $fileName = "databak_" . date("Ymd_his") . ".sql";
        $filedir = C('DB_PATH') . $fileName;
        //echo $filedir;
        $filedir = iconv('GB2312', 'UTF-8', $filedir);
        $dir = dirname($filedir);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $file = fopen($filedir, 'a+');
        $fileval = $str;
        fwrite($file, $fileval);
        fclose($filedir);
        $this->saveLog("备份数据库：" . $fileName, "info");
        $this->success("备份成功", cookie("backurl"));
    }

    /**
     * 还原
     */
    public function doRecovery()
    {
        $this->checkPower("DataBakRec");
        $path = request('path');
        if (empty($path)) {
            $this->saveLog("还原数据库：参数错误，缺少path", "error");
            $this->error("参数错误！");
        }
        $file = base64_decode(urldecode($path));
        // dump($file);
        $file = iconv('utf-8', 'gbk', $file);
        $M = M();
        $sql = file_get_contents($file);
        $res = $M->execute($sql);
        $this->success("还原成功", cookie("backurl"));
    }

    /**
     * 删除
     */
    public function doDel()
    {
        $this->checkPower("DataBakDel");
        $ids = request('ids');
        if (empty($ids)) {
            $this->error("请先选择要删除的记录！");
        }
        $files = explode(',', $ids);
        foreach ($files as $k => $v) {
            $file = base64_decode(urldecode($v));
            $file = iconv('utf-8', 'gbk', $file);
            $result = @unlink($file);
            if ($result == false) {
                $this->saveLog("删除文件失败：" . $file, "error");
            } else {
                $this->saveLog("删除文件成功：" . $file, "info");
            }
            //echo "$file|<br/>";
        }
        //print_r($files);
        $this->success("操作成功！", cookie("backurl"));
    }


}