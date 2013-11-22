<?PHP 
include_once('../../conn/db.php');

// 0 - empty space
// 1 - Sun
// 2 - Planet
// 3 - Station
// 4 - Astroid
// 5 - Mystery_Object
// b - blocking
$galaxyArray = array();
$ROWS = 26;
$COLS = 50;
    // [-1,-1][-1, 0][-1, +1]
    // [ 0,-1][ x, y][ 0, +1]
    // [+1,-1][+1, 0][+1, +1]

    function checkSurroundings($x, $y, &$galaxyArray) {
        if($galaxyArray[$x][$y] === 'b')
            return false;
        elseif(isset($galaxyArray[$x-1][$y-1]) && $galaxyArray[$x-1][$y-1] === 'b')
            return false;
        elseif(isset($galaxyArray[$x-1][$y]) && $galaxyArray[$x-1][$y] === 'b')
            return false;
        elseif(isset($galaxyArray[$x-1][$y+1]) && $galaxyArray[$x-1][$y+1] === 'b')
            return false;
        elseif(isset($galaxyArray[$x][$y-1]) && $galaxyArray[$x][$y-1] === 'b')
            return false;
        elseif(isset($galaxyArray[$x][$y+1]) && $galaxyArray[$x][$y+1] === 'b')
            return false;
        elseif(isset($galaxyArray[$x+1][$y-1]) && $galaxyArray[$x+1][$y-1] === 'b')
            return false;
        elseif(isset($galaxyArray[$x+1][$y]) && $galaxyArray[$x+1][$y] === 'b')
            return false;
        elseif(isset($galaxyArray[$x+1][$y+1]) && $galaxyArray[$x+1][$y+1] === 'b')
            return false;
        else
            return true;
    }
    function fillSlot($x, $y, &$galaxyArray) {
        if($x == 0 && $y == 0){
            $galaxyArray[$x][$y] = getItem();
            $galaxyArray[$x][$y+1] = 'b';
            $galaxyArray[$x+1][$y] = 'b';
            $galaxyArray[$x+1][$y+1] = 'b';
        }

        elseif($x == 0){
            $galaxyArray[$x][$y] = getItem();
            $galaxyArray[$x][$y-1] = 'b';
            $galaxyArray[$x+1][$y-1] = 'b';
            $galaxyArray[$x+1][$y] = 'b';
            $galaxyArray[$x+1][$y+1] = 'b';
            $galaxyArray[$x][$y+1] = 'b';   
        }
        elseif($y == 0){
            $galaxyArray[$x][$y] = getItem();
            $galaxyArray[$x-1][$y] = 'b';
            $galaxyArray[$x-1][$y+1] = 'b';
            $galaxyArray[$x][$y+1] = 'b';
            $galaxyArray[$x+1][$y+1] = 'b';
            $galaxyArray[$x+1][$y] = 'b';   
        }else{
            $galaxyArray[$x-1][$y-1] ='b';
            $galaxyArray[$x-1][$y] ='b';
            $galaxyArray[$x-1][$y+1] ='b';
            $galaxyArray[$x][$y-1] ='b';
            $galaxyArray[$x][$y] = getItem();
            $galaxyArray[$x][$y+1] ='b';
            $galaxyArray[$x+1][$y-1] ='b';
            $galaxyArray[$x+1][$y] ='b';
            $galaxyArray[$x+1][$y+1] ='b';
        }
    }
    // [-1,-1][-1, 0][-1, +1]
    // [ 0,-1][ x, y][ 0, +1]
    // [+1,-1][+1, 0][+1, +1]


    function getItem() {
        $rN = mt_rand(1, 1000); //random number between 1 and 100
        if($rN >= 1 && $rN <= 800){
            return 0; //empty space 77%
        } elseif($rN >= 801 && $rN <= 860){
            return 2; // planet 3%
        } elseif($rN >= 861 && $rN <= 920) {
            return 4; // Astroid 8%
        } elseif($rN >= 921 && $rN <= 935) {
            return 5; //Mystery 1%
        } elseif ($rN >= 936 && $rN <= 1000) {
            return 3; // Station 5%
        }else {
            return 0;
        }
    }


for($x=0; $x<$ROWS; $x++) {
    for($y=0; $y<$COLS; $y++) {
        $galaxyArray[$x][$y] = 0;
    }
}


    for($y=0; $y<200; $y++) {
        $rand_x = mt_rand(0, $ROWS-1);
        $rand_y = mt_rand(0, $COLS-1);
        if(checkSurroundings($rand_x, $rand_y, $galaxyArray)){
            fillSlot($rand_x,$rand_y, $galaxyArray);
        }
    }

$galaxyArray[$ROWS/2][$COLS/2] = 1;
?>
<html>
<body bgcolor="#000">
<div style="width:1000px">
<span style='color:white; display:block; float:left'>
// 0 - empty space
// 1 - Sun
// 2 - Planet
// 3 - Station
// 4 - Astroid
// 5 - Mystery_Object
</span>
<br>
<br>
<?
for($x=0; $x<$ROWS; $x++) {
    for($y=0; $y<$COLS; $y++) {
        if($galaxyArray[$x][$y] == 0 || $galaxyArray[$x][$y] == 'b'){
            echo "<span style='color:black; display:block; float:left'>" . $galaxyArray[$x][$y] ."</span>";
        }elseif($galaxyArray[$x][$y] == 1){
            echo "<span style='color:yellow; display:block; float:left'>" . $galaxyArray[$x][$y] ."</span>";
        }elseif($galaxyArray[$x][$y] == 2){
            echo "<span style='color:green; display:block; float:left'>" . $galaxyArray[$x][$y] ."</span>";
        }elseif($galaxyArray[$x][$y] == 3){
            echo "<span style='color:aqua; display:block; float:left'>" . $galaxyArray[$x][$y] ."</span>";
        }elseif($galaxyArray[$x][$y] == 4){
            echo "<span style='color:azure; display:block; float:left'>" . $galaxyArray[$x][$y] ."</span>";
        }elseif($galaxyArray[$x][$y] == 5){
            echo "<span style='color:fuchsia; display:block; float:left'>" . $galaxyArray[$x][$y] ."</span>";        
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
