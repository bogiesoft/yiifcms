<?php
/**
 * 文件上传
 * 
 * @author        Sim Zhao <326196998@qq.com>
 * @copyright     Copyright (c) 2015. All rights reserved.
 */

class UploadAction extends CAction
{	
	public function run(){
        $uploader = new Uploader();
        if(Yii::app()->request->isPostRequest) {
            //断点上传
            $uploader->initResumable('post')->uploadResumable('file');
            $error = $uploader->getError();
            if (!$error) {
                $data = array(
                    'file_name' => $uploader->file_name,
                    'file_path' => $uploader->file_path,
                    'file_ext'  => $uploader->file_ext
                );
                //保存到附件表里
                $upload = new Upload();
                App::response(200, 'success', $data);
            } else {                
                App::response(101 , $error);
            }
        } else {
            //校验已上传的片段
            $uploader->checkExistChunks();
        }
	}
}