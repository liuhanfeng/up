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
                <form id="upload_form" enctype="multipart/form-data" method="post" action="uploadtwo.php">
                    <input type="hidden" id="imgid" name="imgid" value="<?php echo $imgid ?>" />
                    <input type="hidden" id="ret" name="ret" value="<?php echo $_GET['ret'] ?>" />

                    <h2>第一步:请选择图像文件</h2>
                    
                    <div><input type="file" name="image_file" id="image_file" style='width:50%;' /></div>
                    <div class="error"></div>
                    <h2>第二步:确认图像,然后按上传</h2>
                    <div><input type="submit" value="上传" /></div>
                </form>
            </div>
        </div>
</body>
</html>