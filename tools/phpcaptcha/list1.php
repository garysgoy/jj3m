<!DOCTYPE html>
<body>
    <html>
        <meta charset="utf-8" />
    </html>
    <body>
        <h1>Captchas gallery</h1>
<?
echo "<table>";
for ($x=0; $x<8; $x++) {
    echo "<tr>";
    for ($y=0; $y<5; $y++) {
        $txtColor = ggColor();
        $bgColor = ggColor();
        echo "<td><img src='captcha1.php?txtColor=".$txtColor."&bgColor=".$bgColor."&rand=".(5*$x+$y)."'/> $txtColor $bgColor</<td>";
    }
    echo "</tr>";
}
echo "<tr><td colspan=5><br><br>Use the link below to select colors</td></tr>";
echo "<tr><td colspan=5><a href='list1.php?txt=d50391&bg1=e3c451&bg2=44e9d1&bg3=fe5cae&bg4=989678&bg5=f72efb'>CLICK HERE</a></td></tr>";
if (isset($_GET['txt'])) {
    $txt = $_GET['txt'];
    $bg1 = $_GET['bg1'];
    $bg2 = $_GET['bg2'];
    $bg3 = $_GET['bg3'];
    $bg4 = $_GET['bg4'];
    $bg5 = $_GET['bg5'];
    echo "<tr>";
        echo "<td><img src='captcha1.php?txtColor=".$txt."&bgColor=".$bg1."&rand=".(5*$x+$y)."'/> $txt $bg1</<td>";
        echo "<td><img src='captcha1.php?txtColor=".$txt."&bgColor=".$bg2."&rand=".(5*$x+$y)."'/> $txt $bg2</<td>";
        echo "<td><img src='captcha1.php?txtColor=".$txt."&bgColor=".$bg3."&rand=".(5*$x+$y)."'/> $txt $bg3</<td>";
        echo "<td><img src='captcha1.php?txtColor=".$txt."&bgColor=".$bg4."&rand=".(5*$x+$y)."'/> $txt $bg4</<td>";
        echo "<td><img src='captcha1.php?txtColor=".$txt."&bgColor=".$bg5."&rand=".(5*$x+$y)."'/> $txt $bg5</<td>";
    echo "</tr>";

}
echo "<table>";


function ggColor() {
    $ret = "";
    $c1 = dechex(rand(0,255));
    $c2 = dechex(rand(0,255));
    $c3 = dechex(rand(0,255));
    $c1 = (strlen($c1)==2)? $c1:"0".$c1;
    $c2 = (strlen($c2)==2)? $c2:"0".$c2;
    $c3 = (strlen($c3)==2)? $c3:"0".$c3;
    return $c1.$c2.$c3;
}

function ggColor1() {
    $ret = "";
    while (strlen($ret)<6) {
        $c1 = dechex(rand(0,255));
        $c2 = dechex(rand(0,255));
        $c3 = dechex(rand(0,255));
        $ret = $c1.$c2.$c3;
    }
    return $ret;
}
?>
    </body>
</body>
