var upload_ctl ={
    initImg :function(){
        document.domain='vsochina.com';
        var btnImg = $('#edit_company_banner');
        try{
            btnImg.uploadify('destroy');
        }
        catch(e){
            //console.info(e);
        }
        btnImg.uploadify({
            swf           : '/plugins/uploadify/uploadify.swf',
            uploader      : '/plugins/uploadify/uploadify.php',
            auto:true,
            multi:false,
            width:130,
            height:130,
            fileObjName : 'filedata',
            fileSizeLimit:'200MB',
            buttonText:'',
            formData:{
                upload_path:"/company_banner"
            },
            fileType     : 'image/*',
            uploadScript: "/plugins/uploadify/uploadify.php",
            removeCompleted:true,
            onUploadSuccess  : function(file, data, response) {
                json = jQuery.parseJSON(data);
                if(json.state == 200){
                    alert(1);
                    //
                }
                else{
                    BUI.Message.Alert('上传失败', 'error');
                }
            },
            onFallback:function(){
                BUI.Message.Alert('上传失败', 'error');
            },
            overrideEvents: ['onError'],
            onError:function(errorType){
                //QUEUE_LIMIT_EXCEEDED, UPLOAD_LIMIT_EXCEEDED, FILE_SIZE_LIMIT_EXCEEDED, FORBIDDEN_FILE_TYPE, and 404_FILE_NOT_FOUND
                switch (errorType) {
                    case 'UPLOAD_LIMIT_EXCEEDED':
                        //alert("上传的文件数量已经超出系统限制的" + $('#file_upload').uploadify('settings', 'queueSizeLimit') + "个文件！");
                        break;
                    case 'FILE_SIZE_LIMIT_EXCEEDED':
                        BUI.Message.Alert('文件太大了', 'error');
                        break;
                    case 'FORBIDDEN_FILE_TYPE':
                        BUI.Message.Alert('文件类型不匹配', 'error');
                        break;
                }
                return false;
            },
            onSelect : function(file) {
            }
        });
    }
};