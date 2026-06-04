<?php
$x = 80;
echo "<br>";
echo $x;
echo "<br>";
echo "hasil: $x";
echo "<br>";
echo "hasil: " . $x;
echo "<br>";


if ($x > 50) {
    echo "lebih dari 50";
} else {
    echo "kurang dari 50";
}


?>

<h1>hello</h1>
<?php
for($i=0;$i<10;$i++) {
    echo $i;
    echo "<br>";
}

$j = 0;
while ($j < 10) {
    echo $j;
    
    $j++;
}

function tambah($x,$y) {
    $z = $x + $y;
    echo $z;
}
echo "<br>";
tambah(50,20);

function kurang($x,$y) {
    $z = $x - $y;
    return $z;
}
echo "<br>";
echo kurang(50,20);
echo "<br>";

$xr = array("java", "C++", "php");
echo $xr[0];
echo "<br>";
echo $xr[1];
echo "<br>";
echo $xr[2];
echo "<br>";
foreach($xr as $y) {
    echo $y;
    echo "<br>";
}

$xrr= [["A", "B", "C"], ["D", "E", "F"]];
echo $xrr[0][0];
?>