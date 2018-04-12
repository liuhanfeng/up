<?php
include_once 'include.php';
checklogin();
$imgid = isset($_GET['id'])?intval($_GET['id']):0;
?>
<!DOCTYPE html>
<html >
    <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>图片管理</title>
        <!-- add styles -->
        <link href="css/main.css?t=<?php echo time() ?>" rel="stylesheet" type="text/css" />
        <!-- <link href="css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />-->

        <!-- add scripts -->
        <script src="js/jquery.min.js"></script>
        <!--<script src="js/jquery.Jcrop.min.js"></script>-->
        <script src="js/script.js?t=<?php echo time() ?>"></script>
       <style type="text/css">
        .img-preview {padding:10px 0; } 
        img { 
            height: auto; 
            width: auto\9; 
            width:98%;
        	border: 1px solid #CCCCCC; 
        } 
        </style>
    </head>
    <body>
<?php include 'nav.php';?>
        <div class="demo" style=" margin-top:60px;">
            <div class="bheader"><h2>&nbsp;</h2></div>
            <div class="bbody">

                <!-- upload form -->
                <form id="upload_form" enctype="multipart/form-data" method="post" action="upload.php" onsubmit="return checkForm()">
                    <input type="hidden" id="imgid" name="imgid" value="<?php echo $imgid ?>" />
                    <input type="hidden" id="ret" name="ret" value="<?php echo $_GET['ret'] ?>" />
                    <!-- hidden crop params -->
                    <input type="hidden" id="x1" name="x1" />
                    <input type="hidden" id="y1" name="y1" />
                    <input type="hidden" id="x2" name="x2" />
                    <input type="hidden" id="y2" name="y2" />

                    <h2>第一步:请选择图像文件</h2>
                    
                    <div><input type="file" name="image_file" id="image_file" style='width:50%;' /></div>

                    <div class="error"></div>

                    <div class="step2">
                        <h2 style="display:none;">请鼠标圈选需要截图的部位,然后按上传</h2>
                        <h2>第二步:确认图像,然后按上传</h2>
                        <div class="img-preview"><img id="preview" width="100%" height="100%" /></div>

                        <div class="info" style="display:none;">
                            <label>文件大小</label> <input type="text" id="filesize" name="filesize" />
                            <label>类型</label> <input type="text" id="filetype" name="filetype" />
                            <label>图像尺寸</label> <input type="text" id="filedim" name="filedim" />
                            <label>宽度</label> <input type="text" id="w" name="w" />
                            <label>高度</label> <input type="text" id="h" name="h" />
                        </div>

                        <div><input type="submit" value="上传" /></div>
                    </div>
                </form>
            </div>
        </div>
</body>
</html>
<script>
$('.step2').fadeIn(500);
</script>