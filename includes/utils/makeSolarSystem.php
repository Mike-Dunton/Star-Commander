<?PHP 
include_once('../../conn/db.php');

// 0 - empty space
// 1 - Sun
// 2 - Planet
// 3 - Station
// 4 - Astroid
// 5 - Mystery_Object

$galaxyArray = array();

    function getItem() {
        $rN = mt_rand(1, 100); //random number between 1 and 100
        if($rN >= 1 && $rN <= 77){
            return 0; //empty space 77%
        } elseif($rN >= 78 && $rN <= 81){
            return 2; // planet 3%
        } elseif($rN >= 82 && $rN <= 90) {
            return 4; // Astroid 8%
        } elseif($rN >= 91 && $rN <= 92) {
            return 5; //Mystery 1%
        } elseif ($rN >= 92 && $rN <= 97) {
            return 3; // Station 5%
        }else {
            return 0;
        }
    }


for($x=0; $x<60; $x++) {
    for($y=0; $y<100; $y++) {
        $galaxyArray[$x][$y] = 0;
    }
}

for($x=0; $x<60; $x++) {
    for($y=0; $y<100; $y++) {
        usleep (300);
        $galaxyArray[$x][$y] = getItem();
    }
}

?>
<html>
<body bgcolor="#000">
<div style="width:1800px">
<?
for($x=0; $x<60; $x++) {
    for($y=0; $y<100; $y++) {
        if($galaxyArray[$x][$y] == 0){
            echo "<span style='color:black; display:block; float:left'>" . $galaxyArray[$x][$y] ."</span>";
        }else {
            echo "<span style='color:white; display:block; float:left'>" . $galaxyArray[$x][$y]. "</span>";
        }
    
    }
    print "<br style='clear:both>'";
}
?>
</div>
</body>
</html>
