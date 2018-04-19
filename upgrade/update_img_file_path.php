<?php
include_once '../include.php';

$id = intval($_GET['i']);
$list = $db->get_results('select * from ls_imgs WHERE id>' . $id, ARRAY_A);
if (empty($list)) {
    echo '请求地址不存在!';
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>更新图片地址</title>
    <!-- add styles -->
    <link href="<?php echo $config['sys']['siteurl'] ?>/css/main.css" rel="stylesheet" type="text/css"/>
    <!-- add scripts -->
    <script src="<?php echo $config['sys']['siteurl'] ?>/js/jquery.min.js"></script>

</head>
<body>
<?php
$i = 1;
//1511866282
foreach ($list as $value) {
    $i_str = str_pad($i, 6, '0', STR_PAD_LEFT);
    echo "=================={$i_str}==================<br />";

    $left_4_char = substr($value['imgname'], 0, 4);
    if ($left_4_char=='2017' OR $left_4_char == '2018'){
        echo "[PASS]<br />";
        continue;
    }
    $img_sp = substr($value['imgname'], 0, 10);
    $img_sp2 = substr($value['imgname'], 10);
    $img = gmdate("Ymd_His", 28800 + $img_sp) . '_' . $img_sp2;

    //原图
    $orig_oldname = $orig_newname = '';

    $orig_oldname = ROOT_DIR . 'cache/' . $value['imgname'] . '.jpg';
    $orig_newname = ROOT_DIR . 'cache/' . $img . '.jpg';
    if (@rename($orig_oldname, $orig_newname)) {
        echo "[OK]";
    } else {
        echo "[ER]";
    }
    echo "{$orig_oldname}==>{$orig_newname}<br />";


    //展示图
    $show_oldname = $show_newname = '';

    $show_oldname = ROOT_DIR . 'cache/' . $value['imgname'] . '_show.jpg';
    $show_newname = ROOT_DIR . 'cache/' . $img . '_show.jpg';
    if (@rename($show_oldname, $show_newname)) {
        echo "[OK]";
    } else {
        echo "[ER]";
    }
    echo "{$show_oldname}==>{$show_newname}<br />";
    //echo "{$i_str}.[{$img}]-{$value['imgname']}=[{$img_sp}**{$img_sp2}]=-{$value['img']}<br />";
    //缩略图
    $min_oldname = $min_newname = '';

    $min_oldname = ROOT_DIR . 'cache/' . $value['imgname'] . '_min.jpg';
    $min_newname = ROOT_DIR . 'cache/' . $img . '_min.jpg';
    if (@rename($min_oldname, $min_newname)) {
        echo "[OK]";
    } else {
        echo "[ER]";
    }
    echo "{$min_oldname}==>{$min_newname}<br />";
    //旋转1图
    $lay_oldname = $lay_newname = '';

    $lay_oldname = ROOT_DIR . 'cache/' . $value['imgname'] . '.jpg_lay.jpg';
    $lay_newname = ROOT_DIR . 'cache/' . $img . '.jpg_lay.jpg';
    if (@rename($lay_oldname, $lay_newname)) {
        echo "[OK]";
    } else {
        echo "[ER]";
    }
    echo "{$lay_oldname}==>{$lay_newname}<br />";
    //旋转2图
    $lay2_oldname = $lay2_newname = '';

    $lay2_oldname = ROOT_DIR . 'cache/' . $value['imgname'] . '.jpg_lay.jpg.jpg';
    $lay2_newname = ROOT_DIR . 'cache/' . $img . '.jpg_lay.jpg.jpg';
    if (@rename($lay2_oldname, $lay2_newname)) {
        echo "[OK]";
    } else {
        echo "[ER]";
    }
    echo "{$lay2_oldname}==>{$lay2_newname}<br />";
    $db->query("UPDATE ls_imgs SET `img`='cache/{$img}_show.jpg',`imgname`='{$img}' WHERE `id`={$value['id']}");
    $i++;
}
?>
<ul>
    <li><a href="index.php">升级页面</a></li>
</ul>
</body>
</html>


