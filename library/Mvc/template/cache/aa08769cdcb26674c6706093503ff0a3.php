<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <?php print_r($this->file); ?>
    <?php echo $data; ?><br />
    <?php foreach ((array) $array as $k=>$v){ ?>
        <?php echo $v['name']; ?> <br />
    <?php } ?>
    <?php if ( $name['name'] == $test) { ?>
        haha
    <?php } else { ?>
        hehehe
    <?php } ?>
</body>
</html>