<?PHP 
include_once('../../conn/db.php');

// 0 - empty space
// 1 - Sun
// 2 - Planet
// 3 - Station
// 4 - Astroid
// 5 - Mystery_Object

$galaxyArray = new array();

    function getItem() {
        $rN = mt_rand(1, 100); //random number between 1 and 100
        if($rN >= 1 && $rN <= 40){
            return 0 //empty space 40%
        } elseif($rN >= 41 && $rN <= 55){
            return 2 // planet 14%
        } elseif($rN >= 56 && $rN <= 75) {
            return 4 // Astroid 19%
        } elseif($rN >= 76 && $rN <= 81) {
            return 5 //Mystery 5%
        } elseif ($rN >= 82 && $rN <= 100) {
            return 3 // Station 18%
        }
    }
}

for(int x = 0; x<100; x++) {
    for(int y = 0; y<100; y++) {
        $galaxyArray[x][y] = 0;
    }
}

for(int x = 0; x<100; x++) {
    for(int y = 0; y<100; y++) {
        $galaxyArray[x][y] = getItem();
    }
}

print "| ";
for(int x = 0; x<100; x++) {
    for(int y = 0; y<100; y++) {
        print " " . $galaxyArray[x][y] . " | ";
    }
    print "\n";
}
?>