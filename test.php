<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<pre>
<?php
$config = array(
    'dbhost'   => 'localhost',
    'dbuser'   => 'root11',
    'dbpwd'    => 'root',
    'dbcharset'=> 'utf8',
    'dbname'   => 'test',
    'debug'    => true,
);
$con = new mysql();
$con1 = $con->connect($config);
var_dump($con1);
if ($con1) {
    echo 1;
} else {
    echo 2;
}
?>


</pre>
</body>
</html>

