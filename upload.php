<?php
include_once 'include.php';
// Insert the path where you unpacked log4php
include 'log4php/Logger.php';

// Tell log4php to use our configuration file.
Logger::configure('config.xml');

// Fetch a logger, it will inherit settings from the root logger
$log = Logger::getLogger('uploader');
$log->info("页面开始.");
checklogin();
$id = intval($_POST['imgid']);
$id && $log->info("处理图像编号:".$id);
$item = array();
$fname = md5(time() . rand());
$fname =gmdate("Ymd_His", 28800 +  time()) .'_'. rand();

if ($id > 0) {
    $item = $db->get_row('select * from ls_imgs WHERE id=' . $id, ARRAY_A);
    $fname = $item['imgname'];
}
$log->info("图像上传开始.");
$sImage = uploadImageFile($fname);
$log->info("图像上传结束.");
if (empty($sImage)) {
    $errMsg = '文件上传失败!!';
    echo 'upload error!';
}

// 原图
$src = dirname(__FILE__) . '/cache/' . $fname . '.jpg';
// 展示图
$dst = dirname(__FILE__) . '/cache/' . $fname . '_show.jpg';
// 缩略图
$dst_min = dirname(__FILE__) . '/cache/' . $fname . '_min.jpg';
$log->info("图像旋转开始.");
// 旋转为上下
imgturn($src);
$log->info("图像旋转结束.");

//缩放
$srcinfo = getimagesize($src);
$src_w = $srcinfo[0];
$src_h = $srcinfo[1];
//h/w
$tar = array(
    'h'=>1280,
    'w'=>720
);

$lay = 1.77;
$lay_new = 1;

if ($src_h/$src_w>$lay){
    //过高取宽的比例
    $lay_new = $src_w/$tar['w'];
}else {
    //过宽取高的比例
    $lay_new = $src_h/$tar['h'];
}
$log->info("图像缩放开始.");
img2thumb($src, $src.'_lay.jpg', 0, 0, 0,$lay_new);
$log->info("图像缩放结束.");
$src = $src.'_lay.jpg';

$srcinfo = getimagesize($src);
$src_w = $srcinfo[0];
$src_h = $srcinfo[1];
//img2thumb($src_img, $dst_img, $width = 75, $height = 75, $cut = 0, $proportion = 0)
//h/w
$lay = 1.77;

if ($src_h/$src_w>$lay){
    //过高
    $new_w = $src_w;
    $new_h = $new_w*$lay;
}else {
    //过宽
    $new_h = $src_h;
    $new_w = $new_h/$lay;
}

$log->info("图像裁剪开始.");
img2thumb($src, $src.'.jpg', $new_w, $new_h, 1);
$log->info("图像裁剪结束.");
$src = $src.'.jpg';
$log->info("图像生成展示开始.");
// 生成展示图
img2thumb($src, $dst, 720, 0);
$log->info("图像生成展示结束.");
$log->info("图像生成缩略开始.");
// 生成缩略图
//img2thumb($src, $dst_min, 150, 150,1);
img2thumb($src, $dst_min, 150, 0);
$log->info("图像生成缩略结束.");
if (empty($item)) {
    $item = array(
        'title' => time(),
        'img' => 'cache/' . $fname . '_show.jpg',
        'imgname' => $fname,
        'addtime' => time(),
        'expire_time' => time() + 365 * 24 * 60 * 60,
        'adminid' => $current_user['userid']
    );
    $in_sql = "INSERT INTO `ls_imgs` ( `title`, `img`, `imgname`, `expire_time`, `adminid`, `addtime`) " . "VALUES ('{$item['title']}', '{$item['img']}', '{$item['imgname']}', '{$item['expire_time']}', '{$item['adminid']}', '{$item['addtime']}');";
    $log->info("图像写库开始.");
    $db->query($in_sql);
    $in_id = $db->insert_id;
    $log->info("图像写库结束.");
    $id = $in_id; // ['id'];
    $item['id'] = $id;
}

$redri = '';
if ($_POST['ret'] == 'edit') {
    $redri = '/edit.php?id=' . $id;
} else {
    $redri = '/list.php?id=' . $id;
}
$log->info("页面完成.");
header('Location: ' . $redri);
// header('Location: /s.php?i=' . $id);

/**
 * 生成缩略图
 * 
 * @author yangzhiguo0903@163.com
 * @param
 *            string 源图绝对完整地址{带文件名及后缀名}
 * @param
 *            string 目标图绝对完整地址{带文件名及后缀名}
 * @param
 *            int 缩略图宽{0:此时目标高度不能为0，目标宽度为源图宽*(目标高度/源图高)}
 * @param
 *            int 缩略图高{0:此时目标宽度不能为0，目标高度为源图高*(目标宽度/源图宽)}
 * @param
 *            int 是否裁切{宽,高必须非0}
 * @param
 *            int/float 缩放{0:不缩放, 0<this<1:缩放到相应比例(此时宽高限制和裁切均失效)}
 * @return boolean
 */
function img2thumb($src_img, $dst_img, $width = 75, $height = 75, $cut = 0, $proportion = 0)
{
    if (! is_file($src_img)) {
        echo 'nofile!';
        return false;
    }
    $ot = fileext($dst_img);
    $otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
    $srcinfo = getimagesize($src_img);
    $src_w = $srcinfo[0];
    $src_h = $srcinfo[1];
    $type = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
    $createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);
    
    $dst_h = $height;
    $dst_w = $width;
    $x = $y = 0;
    
    /**
     * 缩略图不超过源图尺寸（前提是宽或高只有一个）
     */
    if (($width > $src_w && $height > $src_h) || ($height > $src_h && $width == 0) || ($width > $src_w && $height == 0)) {
        $proportion = 1;
    }
    if ($width > $src_w) {
        $dst_w = $width = $src_w;
    }
    if ($height > $src_h) {
        $dst_h = $height = $src_h;
    }
    
    if (! $width && ! $height && ! $proportion) {
        return false;
    }
    if (! $proportion) {
        if ($cut == 0) {
            if ($dst_w && $dst_h) {
                if ($dst_w / $src_w > $dst_h / $src_h) {
                    $dst_w = $src_w * ($dst_h / $src_h);
                    $x = 0 - ($dst_w - $width) / 2;
                } else {
                    $dst_h = $src_h * ($dst_w / $src_w);
                    $y = 0 - ($dst_h - $height) / 2;
                }
            } else 
                if ($dst_w xor $dst_h) {
                    if ($dst_w && ! $dst_h) { // 有宽无高
                        $propor = $dst_w / $src_w;
                        $height = $dst_h = $src_h * $propor;
                    } else 
                        if (! $dst_w && $dst_h) { // 有高无宽
                            $propor = $dst_h / $src_h;
                            $width = $dst_w = $src_w * $propor;
                        }
                }
        } else {
            if (! $dst_h) { // 裁剪时无高
                $height = $dst_h = $dst_w;
            }
            if (! $dst_w) { // 裁剪时无宽
                $width = $dst_w = $dst_h;
            }
            $propor = min(max($dst_w / $src_w, $dst_h / $src_h), 1);
            $dst_w = (int) round($src_w * $propor);
            $dst_h = (int) round($src_h * $propor);
            $x = ($width - $dst_w) / 2;
            $y = ($height - $dst_h) / 2;
        }
    } else {
        $proportion = min($proportion, 1);
        $height = $dst_h = $src_h * $proportion;
        $width = $dst_w = $src_w * $proportion;
    }
    
    $src = $createfun($src_img);
    $dst = imagecreatetruecolor($width ? $width : $dst_w, $height ? $height : $dst_h);
    $white = imagecolorallocate($dst, 255, 255, 255);
    imagefill($dst, 0, 0, $white);
    
    if (function_exists('imagecopyresampled')) {
        imagecopyresampled($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    } else {
        imagecopyresized($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    }
    $otfunc($dst, $dst_img);
    imagedestroy($dst);
    imagedestroy($src);
    return true;
}

function imgturn($src_img)
{
    $dst_img = $src_img;
    if (! is_file($src_img)) {
        echo 'nofile!';
        return false;
    }
    $ot = fileext($dst_img);
    $otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
    $srcinfo = getimagesize($src_img);
    $src_w = $srcinfo[0];
    $src_h = $srcinfo[1];
    
    if ($src_w < $src_h) {
        return false;
    }
    
    $type = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
    $createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);
    
    $src = $createfun($src_img);
    
    if ($src == "")
        return false;
    $rotate = @imagerotate($src, 90, 0);
    if (! $otfunc($rotate, $src_img, 100))
        return false;
    @imagedestroy($rotate);
    @imagedestroy($src);
    
    return true;
}

function fileext($file)
{
    return pathinfo($file, PATHINFO_EXTENSION);
}

function uploadImageFile($fname) // Note: GD library is required for this function
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $iWidth = $iHeight = 200; // desired image result dimensions
        $iJpgQuality = 90;
        
        if ($_FILES) {
            
            // if no errors and size less than 250kb
            if (! $_FILES['image_file']['error'] && $_FILES['image_file']['size'] < 25000 * 1024) {
                if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {
                    
                    if (empty($fname))
                        $fname = md5(time() . rand());
                        // new unique filename
                    $sTempFileName = 'cache/' . $fname . '.jpg';
                    
                    // move uploaded file into cache folder
                    move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);
                    
                    // change file permission to 644
                    @chmod($sTempFileName, 0644);
                    
                    if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
                        // return $sTempFileName;
                        return $fname;
                        // $aSize = getimagesize($sTempFileName); // try to obtain image info
                        // if (!$aSize) {
                        // @unlink($sTempFileName);
                        // return;
                        // }
                        
                        // // check for image type
                        // switch ($aSize[2]) {
                        // case IMAGETYPE_JPEG:
                        // $sExt = '.jpg';
                        
                        // // create a new image from file
                        // $vImg = @imagecreatefromjpeg($sTempFileName);
                        // break;
                        // case IMAGETYPE_PNG:
                        // $sExt = '.png';
                        
                        // // create a new image from file
                        // $vImg = @imagecreatefrompng($sTempFileName);
                        // break;
                        // default:
                        // @unlink($sTempFileName);
                        // return;
                        // }
                        
                        // // create a new true color image
                        // $vDstImg = @imagecreatetruecolor($iWidth, $iHeight);
                        
                        // // copy and resize part of an image with resampling
                        // imagecopyresampled($vDstImg, $vImg, 0, 0, (int) $_POST['x1'], (int) $_POST['y1'], $iWidth, $iHeight, (int) $_POST['w'], (int) $_POST['h']);
                        
                        // // define a result image filename
                        // $sResultFileName = $sTempFileName . $sExt;
                        
                        // // output image to file
                        // imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
                        // @unlink($sTempFileName);
                        
                        // return $sResultFileName;
                    }else {
                        echo 'file_exists error';
                    }
                }else {
                    echo 'is_uploaded_file false!';
                }
            }else {
                echo 'image_file error OR size over![['.$_FILES['image_file']['error'].']]';
                var_dump($_FILES);
            }
        }else {
            echo '$_FILES is null!';
        }
    }
}

?>