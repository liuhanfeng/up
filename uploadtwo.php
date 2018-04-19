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
$upimg = uploadImageFile($fname);
if ($upimg['success'] === true){
    $sImage = $upimg['filename'];
}else{
    echo '文件上传失败!!';
    echo $upimg['msg'];
    exit();
}
$log->info("图像上传结束.");
if (empty($sImage)) {
    $errMsg = '文件上传失败!!';
    echo 'upload error!';
    exit();
}

// 原图
$src = dirname(__FILE__) . '/cache/' . $fname . '.jpg';
// 展示图
$dst = dirname(__FILE__) . '/cache/' . $fname . '_show.jpg';
// 缩略图
$dst_min = dirname(__FILE__) . '/cache/' . $fname . '_min.jpg';

//缩放
$srcinfo = getimagesize($src);
$src_w = $srcinfo[0];
$src_h = $srcinfo[1];

/**
 * 1.缩放并且截取中间80%(最终宽度为720px)
 * 2.缩放并且截取中间80%(最终宽度为100px)
 */

img2thumb($src,$dst,$dst_min);




if (empty($item)) {
    $item = array(
        'title' => time(),
        'img' => 'cache/' . $fname . '_show.jpg',
        'imgname' => $fname,
        'addtime' => time(),
        'expire_time' => time() + 7 * 24 * 60 * 60,
        'adminid' => $current_user['userid']
    );
    $in_sql = "INSERT INTO `ls_imgs` ( `t`,  `title`, `img`, `imgname`, `expire_time`, `adminid`, `addtime`) " . "VALUES (1,'{$item['title']}', '{$item['img']}', '{$item['imgname']}', '{$item['expire_time']}', '{$item['adminid']}', '{$item['addtime']}');";
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
function img2thumb($src_img, $dst_img,$dst_img_min)
{
    $ret = array(
        'success'=>false,
        'showname'=>'',
        'minname'=>'',
        'msg'=>''
    );
    
    if (! is_file($src_img)) {
        $ret['msg'] ='文件不存在!';
        return $ret;
    }
    $ot = fileext($dst_img);
    $otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
    $srcinfo = getimagesize($src_img);
    $src_w = $srcinfo[0];
    $src_h = $srcinfo[1];
    
    if ($src_w>$src_h) {
        $ret['msg'] ='相片比例不正确!';
        return $ret;
    }
    
    $type = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
    $createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);
    
    $dst_h =  $dst_w = 0;
    $x = $y = 0;
    
    /**
     * 1.缩放并且截取中间80%(最终宽度为720px)
     * 2.缩放并且截取中间80%(最终宽度为100px)
     */
    $dst_w = 720;
    $propor =$dst_w / $src_w;
    $dst_h = (int) round($src_h * $propor*1.1);
    $x = 0- ($dst_w*0.05);
    
    $dst_h_min =  $dst_w_min = 0;
    $x_min = $y_min = 0;
    $dst_w_min = 100;
    $propor_min =$dst_w_min / $src_w;
    $dst_h_min = (int) round($src_h * $propor_min*1.1);
    $x_min = 0- ($dst_w_min*0.05);
    
    //读取源图对象
    $src = $createfun($src_img);
    
    //--大图--
    //创建目标图对象(新建一个真彩色图像,代表了一幅大小为 x_size 和 y_size 的黑色图像)
    $dst = imagecreatetruecolor($dst_w, $dst_h);
    
    //为一幅图像分配颜色,返回一个标识符，代表了由给定的 RGB 成分组成的颜色
    //$white = imagecolorallocate($dst, 255, 255, 255);
    //在 image 图像的坐标 x，y（图像左上角为 0, 0）处用 color 颜色执行区域填充（即与 x, y 点颜色相同且相邻的点都会被填充）
    //imagefill($dst, 0, 0, $white);
    
    if (function_exists('imagecopyresampled')) {
        //将一幅图像中的一块正方形区域拷贝到另一个图像中，平滑地插入像素值
        /**
         * bool imagecopyresampled ( resource $dst_image , resource $src_image , 
         *      int $dst_x , int $dst_y , int $src_x , int $src_y , 
         *      int $dst_w , int $dst_h , int $src_w , int $src_h )
         */
        imagecopyresampled($dst, $src, $x, $y, 0, 0, $dst_w-$x*2, $dst_h, $src_w, $src_h);
    } else {
        //将一幅图像中的一块矩形区域拷贝到另一个图像中
        /**
         * bool imagecopyresized ( resource $dst_image , resource $src_image , 
         *      int $dst_x , int $dst_y , int $src_x , int $src_y , 
         *      int $dst_w , int $dst_h , int $src_w , int $src_h )
         */
        imagecopyresized($dst, $src, $x, $y, 0, 0, $dst_w-$x*2, $dst_h, $src_w, $src_h);
    }
    
    // 从 image 图像以 filename 为文件名创建一个 JPEG 图像。
    /**
     * bool imagejpeg ( resource $image [, string $filename [, int $quality ]] )
     */
    $otfunc($dst, $dst_img);
    //销毁目标图对象
    imagedestroy($dst);
    //--小图--
    //创建目标图对象(新建一个真彩色图像,代表了一幅大小为 x_size 和 y_size 的黑色图像)
    $dst_min = imagecreatetruecolor($dst_w_min, $dst_h_min);
    
    //为一幅图像分配颜色,返回一个标识符，代表了由给定的 RGB 成分组成的颜色
    //$white = imagecolorallocate($dst, 255, 255, 255);
    //在 image 图像的坐标 x，y（图像左上角为 0, 0）处用 color 颜色执行区域填充（即与 x, y 点颜色相同且相邻的点都会被填充）
    //imagefill($dst, 0, 0, $white);
    
    if (function_exists('imagecopyresampled')) {
        //将一幅图像中的一块正方形区域拷贝到另一个图像中，平滑地插入像素值
        /**
         * bool imagecopyresampled ( resource $dst_image , resource $src_image ,
         *      int $dst_x , int $dst_y , int $src_x , int $src_y ,
         *      int $dst_w , int $dst_h , int $src_w , int $src_h )
         */
        imagecopyresampled($dst_min, $src, $x_min, $y_min, 0, 0, $dst_w_min-$x_min*2, $dst_h_min, $src_w, $src_h);
    } else {
        //将一幅图像中的一块矩形区域拷贝到另一个图像中
        /**
         * bool imagecopyresized ( resource $dst_image , resource $src_image ,
         *      int $dst_x , int $dst_y , int $src_x , int $src_y ,
         *      int $dst_w , int $dst_h , int $src_w , int $src_h )
         */
        imagecopyresized($dst_min, $src, $x_min, $y_min, 0, 0, $dst_w_min-$x_min*2, $dst_h_min, $src_w, $src_h);
    }
    
    // 从 image 图像以 filename 为文件名创建一个 JPEG 图像。
    /**
     * bool imagejpeg ( resource $image [, string $filename [, int $quality ]] )
     */
    $otfunc($dst_min, $dst_img_min);
    //销毁目标图对象
    imagedestroy($dst_min);
    
    //销毁源图对象
    imagedestroy($src);
    
    
    return true;
}


function fileext($file)
{
    return pathinfo($file, PATHINFO_EXTENSION);
}

function uploadImageFile($fname) // Note: GD library is required for this function
{
    $ret = array(
        'success' => false,
        'filename' => false,
        'msg'=>''
    );
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
                        $ret['success'] = true;
                        $ret['filename'] = $fname;
                        
                    }else {
                        $ret['msg'] = 'file_exists error';
                    }
                }else {
                    $ret['msg'] = 'is_uploaded_file false!';
                }
            }else {
                $ret['msg'] = '文件损坏或文件大小超出![['.$_FILES['image_file']['error'].']]';
                var_dump($_FILES);
            }
        }else {
            $ret['msg'] = '$_FILES is null!';
        }
    }
    return $ret;
}

?>