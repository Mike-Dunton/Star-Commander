<?PHP 
include_once('../../conn/db.php');


 $dbh = dbHandler::getConnection();

function makeSolarSystem($span_x, $span_y) {

        $insert = $dbh->_dbh->prepare("INSERT INTO solarSystem
                                       (galaxy_id, span_x, span_y)
                                       VALUES(:gID, :spanX, :spanY)");
        $insert->bindParam(':gID', 1 , PDO::PARAM_INT);
        $insert->bindParam(':spanX', $span_x , PDO::PARAM_INT);
        $insert->bindParam(':spanY', $span_y , PDO::PARAM_INT);
        $insert->execute();
        
        return $dbh->lastInsertId();
}

function insertStellarObject($solarID, $coorX, $coorY, $type) {
    $insert = $dbh->_dbh->prepare("INSERT INTO stellarObject(solar_id, type_id, name, coor_x, coor_y)
                                   VALUES (:sID, :tID, :name, :coorX, :coorY)");
        $insert->bindParam(':sID', $solarID , PDO::PARAM_INT);
        $insert->bindParam(':coorX', $coorX , PDO::PARAM_INT);
        $insert->bindParam(':coorY', $coorY , PDO::PARAM_INT);
        $insert->bindParam(':name', getRamdomName() , PDO::PARAM_STR);
        $insert->execute();
}


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


$nameList = "Aakashshah,Aakritijain,Aakshi,Aaltje,Aarhus,Aaronburrows,Aaronenten,Aarongolden,Aaronhakim,Aaronritter,Aaronrogers,Aaronrozon,Aaronson,Aarseth,Aaryn,Aase,Aavasaksa,Abai,Abalakin,Abanderada,Abante,Abashiri,Abastumani,Abbe,Abbott,Abdel,Samad,Abderhalden,Abdulla,Abdulrasool,Abedinabedin,Abehiroshi,Abejar,Abell,Abemasanao,Abeosamu,Aberdonia,Abetadashi,Abetti,Abhramu,Abifraeman,Abigailhines,Abigreene,Abilunon,Abkhazia,Ables,Abnoba,Abramcoley,Abramenko,Abramov,Abramson,Abshir,Abstracta,Abt,
Abu,Rmaileh,Abukumado,Abukumagawa,Abulghazi,Abundantia,Acacia,Acaciacoleman,Academia,Acadiau,Acamas,Acapulco,Acer,Acevedo,Achaemenides,Achaia,Achandran,Achates,Achilles,Achosyx,Achristou,Achucarro,Adalberta,Adalovelace,Adamblock,Adambowman,Adambradley,Adamcarolla,Adamchauvin,Adamcrandall,Adamcurry,Adamfields,Adamkrafft,Adammalin,Adamovich,Adamquade,Adamries,Adams,Adamsidman,Adamsmith,Adamsolomon,Adamspencer,Adamtazi,Adamwohl,Addibischoff,Addicott,Adedmondson,Adelaide,Adele,Adelgunde,Adelheid,Adelinacozma,Adelinda,Adelka,Adeona,Adiseshan,Aditi,Adkerson,Adler,Admete,Admetos,Adolfborn,Adolfine,Adolfneckar,Adolftrager,Adonis,Adorea,Adorno,Adrastea,Adria,Adriana,Adrianveres,Adry,Aduatiques,Advincula,Adzhimushkaj,Adzic,Aedouglass,Aegina,Aegle,Aehlita,Aemilia,Aenna,Aenona,Aeolia,Aepic,Aeria,Aeschylus,Aesculapia,Aesop,Aeternitas,Aethra,Aethusa,Aetolia,Aferrari,Aflorsch,Afra,Africa,Africano,Agafonikov,Agafonov,Agamemnon,Agapenor,Agassiz,Agasthenes,Agastrophus,Agasvar,Agata,Akosipov,Akplatonov,Akran,Akrishnan,Aksenov,Aksnes,Alauda,Alba,Regia,Albanese,Albee,Albellus,Albeniz,Albert,Albertacentenary,Albertcui,Albertine,Albertjansen,Albertjarvis,Albertoalonso,Albertoangela,Albertofilho,Albertosuci,Albertsao,Albertshieh,Albertus,Magnus,Albertwu,Albifrons,Albina,Albinadubois,Albinoni,Albis,Albisetti,Albitskij,Albrecht,Alcaeus,Alcathous,Alchata,Alcide,Alcinoos,Alcock,Aldalara,Aldana,Aldaz,Alden,Aldeobaldia,Aldering,Aldo,Aldrin,Alechinsky,Alefranz,Alekfursenko,Alekhin,Alekperov,Aleksandrov,Antimachos,Antink,Antinous,Antiope,Antiphanes,Antiphos,Antisthenes,Antoku,Antonella,Antongraff,Antonhajduk,Antonia,Antonini,Antonioleone,Antoniromanya,Antoniucci,Antonov,Antonschraut,Antonysutton,Antwerpia,Anubelshunu,Anubis,Anupamakotha,Anyuta,Anza,Aoba,Aokeda,Aoki,Aoluta,Aomori,Aoraki,Aoshima,Aotearoa,Aoyagi,Aoyama,Aoyunzhiyuanzhe,Apache,Point,Apaczai,Apadmanabha,Apan,Aparicio,Apatheia,Apeldoorn,Aphrodite,Apian,Apisaon,Apitzsch,Apollinaire,Apollo,Apollodoros,Apollonia,Apophis,Aposhanskij,Apostel,Appella,Appennino,Appenzella,Aprillee,Apta,Apuleius,Aquamarine,Aquifolium,Aquilegia,Aquincum,Aquitania,
Ara,Araas,Arabella,Arabia,Arabis,Arachne,Arago,Arai,Araimasaru,Araki,Arakihiroshi,Aralia,Aramis,Aransio,Aranyjanos,Ararat,Aratus,Arayhamilton,Arbesfeld,Arcadia,Arcadiopoveda,Arcetri,Archaeopteryx,Archenhold,Augustepiccard,Augustesen,Augusthermann,Augusthorch,Augustinus,Augustzatka,Aunus,Aura,Aurapenenta,Auravictrix,Aurelia,Aurelianora,Auricula,Aurochs,Aurora,Ausonia,Auster,Austinmccoy,Austinminor,Australia,Austrasia,Austria,Automedon,Autonoma,Autumn,Auwers,Avatcha,Aventini,Averroes,Avery,Baillauda,Baily,Baixuefei,Baize,Bajaja,Bajin,Baker,Bakerhansen,Bakharev,Bakhchisaraj,Bakhchivandji,Bakhrakh,Bakhtinov,Bakich,Bakonybel,Bakosgaspar,Bakulev,
Bal,Bal'mont,Balachandar,Balakirev,Balaklava,Balakrishnan,Balam,Balasingam,Balasridhar,Balasubramanian,Balaton,Balau,Barrera,Barrett,Barrettduff,Barringer,Barry,Barryarnold,Barryburke,Barrycarole,Barryhaase,Barrylasker,Barrysimon,Barshannon,Barsig,Bartasiute,Bartbenjamin,Bartels,Barth,Barthibbs,Bartini,Bartkevicius,Barto,Bartok,Bartolini,Bartolomeo,Bartolucci,Barucci,Baschek,Bascom,Basfifty,Basheehan,Bashkiria,Bashkirtseff,Basilashvili,Basilea,Basilevsky,Basilrowe,Baskaran,Basner,Basov,Bassano,Basso,Bastei,Bastian,Basu,Bata,Batalden,Batalov,Batavia,Batchelor,Bateman,Batens,Bateson,Bathilde,Bathompson,Bathseba,Batllo,Baton,Rouge,Batrakov,Battaglini,Batteas,Batten,Batth,Battiato,Battisti,Baucis,Baudelaire,Baudot,Bauerle,Bauersfelda,Bauhaus,Bauhinia,Baumanka,Baumann,Baume,Baumeia,Baumeler,Baumhauer,Baupeter,Baur,Bauschinger,Bautzen,Bavaria,Bayanmashat,Bayanova,Bayefsky,Anand,Bayle,Bayzoltan,Bazhenov,Belenus,Beletic,Beletskij,Belgica,Belgirate,Belgorod,Belgrano,Belinskij,Belisana,Beljawskya,Belkin,Belkovich,Bella,Bellagio,Bellelay,Bellerophon,Bellevanzuylen,Bellier,Bellingshausen,Bellini,Bellmore,Bellona,Belloves,Bellqvist,Belnika,Belo,Horizonte,Belopolskya,Belskaya,Belton,Bhagwat,Bharat,Bhasin,Bhat,Bhattacharyya,Bhuiyan,Bhupatiraju,Bialystock,Bianca,Bianchini,Bianciardi,Biandepei,Bianucci,Biarmia,Biarmicus,Bibee,Biblialexa,Biblioran,Bibracte,Bibring,Bicak,Bichat,Bickel,Bickerton,Bickley,Bidelman,Bidstrup,Biela,Bienor,Biermann,Boltzmann,Bolyai,Bolzano,Bomans,Bombelli,Bomben,Bombieri,Bombig,Bonata,Bonazzoli,Bonch,Bruevich,Boncompagni,Bondar,Bondia,Bonestell,Bonev,Bongiovanni,Bonham,Bonhoeffer,Bonifatius,Bonini,Bonk,Bonnie,Bonnielei,Bononia,Bonpland,Bonsdorffia,Bontekoe,Bonucci,Bonus,Boole,Booth,Bopp,Bora,Bora,Borasisi,Borbala,Borbona,Borchert,Borda,Borden,Bordovitsyna,Boreas,Borel,Borges,Borgman,Borisalexeev,Borishanin,Borisivanov,Borisov,Borispetrov,Boriszaitsev,Borlaug,Bormio,Born,Borngen,Bornholm,Bornim,Bornmann,Briede,Briegel,Briekugler,Briggs,Bright,Spring,Brighton,Brigidsavage,Brigitta,Brilawrence,Brisbane,Briseis,Brita,Britastra,Britbaker,Britta,Brittajones,Brittany,Brittanyanderson,Britten,Brittrusso,Britwenger,Brixia,Brlka,Brloh,Brno,
Bro,Brock,Brocken,Brockhaus,Brockman,Brodallan,Broder,Broderick,Brodersen,Brodskaya,Brody,Broederstroom,Broglio,Brokoff,Broksas,Broman,Bronislawa,Bronner,Bronnina,Bronshten,Brontosaurus,Brookebowers,Brooks,Brooktaylor,Brorfelde,Brorsen,Brosche,Broughton,Brouillac,Brouwer,Brown,Brownlee,Broz,Brozovic,Bunsen,Bunting,Bunun,Buonanno,Buraliforti,Buratti,Burbidge,Burbine,Burckhalter,Burdenko,Burdett,Burdigala,Bure,Burgel,Burgi,Burgoyne,Burgundia,Burian,Burkam,Burke,Burkert,Burkhardt,Burkhead,Burnaby,Burnashev,Burnett,Burney,Burnhamia,Burnim,Burns,Conae,Conandoyle,Conard,Concari,Concordia,Condillac,Condorcet,Condruses,Conedera,Confucius,Conlin,Connelly,Conniewalker,Connolly,Connorivens,Connormcarty,Connors,Conon,Conrada,Conradferdinand,Conradhirsh,Consadole,Conscience,Consolmagno,Constable,Constantia,Conwell,Cook,Coonabarabran,Cooney,Copiapo,Copito,Copland,Coppelia,Coppens,Coppernicus,Coquillette,Cora,Coradini,Coralina,Corax,Corbett,Corbin,Cordelia,Cordellorenz,Cordie,Corduba,Cordwell,Coreglia,Cori,Coriolis,Cornejo,Cornelia,Cornell,Corneville,Corning,Cornus,Corot,Corporon,Corradolamberti,Correggia,Cortesi,Cortina,Cortland,Cortusa,Corvan,Corvina,Cosette,Cosicosi,Cosima,Cosquer,Cossard,Costello,Coster,Costitx,Cotopaxi,Cottam,Cottrell,Cotur,Coubertin,Coudenberghe,Coudray,Coughlin,Coulomb,Coulter,Counselman,Couperin,Courant,Courbet,Courroux,Doggett,Dogo,Onsen,Dohmoto,
Doi,Doikazunori,Dolby,Dolecek,Doleonardi,Dolero,Dolezal,Dolgorukij,Dolios,Dollen,Dollfus,Dolmatovskij,Dolomiten,Dolon,Dolops,Dolores,Doloreshill,Dolphyn,Dolyniuk,Domatthews,Domegge,Domeyko,Dominguez,Dominikbrunner,Dominikhasek,Dominiona,Dunphy,Dunweathers,Dunyazade,Duongtuyenvu,Duponta,Dupouy,Durance,Duras,Durbin,Durda,Durech,Durer,Durham,Durisen,Durkheim,Durrell,Durrenmatt,Dusek,Dusser,Dustindeford,Dustinshea,Duyha,Duyingsewa,Dvorak,Dvorets,Pionerov,Dvorsky,Dweinberg,Dwingeloo,Dworetsky,Efremiana,Efremlevitan,Efremov,Egelsbach,Eger,Egeria,Egerszegi,Egisto,Egleston,Egorov,Ehdita,Ehime,Ehrdni,Ehrenberg,Ehrenfest,Ehrenfreund,Ehrlich,Ehrsson,Eichendorff,Eicher,Eichhorn,Eichorn,Eichsfeldia,Eijikato,Eijkman,Eileen,Eileenjang,Eileenreed,Einasto,Einer,Ellis,Ellison,Elly,Ellyett,Elmer,Elmerreese,Elnapoul,Elodie,Elois,Elowitz,Elpis,Elsa,Elsasser,Elsschot,Elst,Elst,Pizarro,Eltigen,Eluard,Elvira,Elvis,Elyna,Elysehope,Elysiasegal,Elyu,
Ene,Emaitchar,Emalanushenko,Emans,Emanuela,Entsuji,Entwisle,Enver,Enya,Enzomora,
Eos,Eotvos,Epeigeus,Epeios,Ependes,Epetersen,Epicles,Epikouros,Epimetheus,Epistrophos,Epoigny,Epona,Epops,Eppard,Epstein,Epyaxa,Eranyavneh,Erasmus,Erato,Eratosthenes,
Erb,Erben,Erbisbuhl,Ercilla,Ercolepoli,Ermak,Ermalmquist,Erman,Erminia,Ermolova,Erna,Erneschiller,Ernestina,Ernestmaes,Ernestocorte,Ernestoruiz,Ernsthelene,Ernsting,Ernstweber,Eros,Erosszsolt,Erwanmazarico,Erwingroten,Erwinschwab,Eryan,Erynia,Erzgebirge,Esaki,Esambaev,Esashi,Escalante,Eschenbach,Escher,Esclangona,Eshinjolly,Euphemia,Euphrates,Euphrosyne,Eupraksia,Eureka,Euripides,Europa,Europaeus,Euryalos,Euryanthe,Eurybates,Eurydamas,Eurydike,Eurykleia,Eurymachos,Eurymedon,Eurynome,Eurypylos,Eurysaces,Euterpe,
Eva,Evakrchova,Evamaria,Evamarkova,Evanchen,Evanfletcher,Evanfrank,Evanichols,Evanmarshall,Evanmirts,Evanmorikawa,Evanolin,Evans,Evapalisa,Evdokiya,Evelyn,Evenkia,Everett,Everhart,Evgalvasil'ev,Evgenifedorov,Evgenij,Evgenilebedev,Evgenyamosov,Evita,Evpatoria,Evtushenko,Ewen,Ewers,Excalibur,Excubitor,Eyer,Eyjafjallajokull,Eymann,Ezaki,Ezratty,FAIR,FRIPON,Fabbri,Fabienkuntz,Fast,Fatherwilliam,Fatme,Fatou,Fatyanov,Faulkes,Faure,Fauvaud,Fauvel,Favaloro,
Fay,Fayeta,Fazio,Feaga,Feast,Fechner,Fechtig,Fedaksari,Fedchenko,Feddersen,Federer,Federica,Federicotosi,Fedina,Fedorshpig,Fedoseev,Fedotov,Fedynskij,Feeny,Fehrenbach,Gallardo,Galle,Gallia,Gallinago,Galois,Galvani,Galvarino,Galya,Gamalski,Gammelmaja,Gamow,Gamzatov,Gandall,Ganesa,Gangda,Ganghofer,Gangkeda,Ganguly,Gansu,Gantrisch,Ganymed,Ganz,Gaolu,Gaoshiqi,Gaoyaojie,Garabedian,Garbarino,Garber,Garcia,Garcialorca,Gardel,Gardner,Gardon,Gardonyi,Garecynthia,Garibaldi,Garimella,Garlena,Garnavich,Garneau,Garossino,Garradd,Garretyazzie,Garretzuppiger,Garrison,Garrone,Garstang,Garuda,Garumna,Gary,Garyhuss,Garymyers,Garynadler,Garyross,Garywessen,Gasbarini,Gase,Gaskell,Gaskin,Gaspari,Guerriero,Guest,Guettard,Guetter,Gueymard,Guhagilford,Guido,Guidoni,Guidotti,Guillaume,Guillaumebude,Guillermina,Guinevere,Guiraudon,Guisan,Guisard,Guislain,Guizhou,Gulak,Gulati,Gulkis,Gullin,Gulyaev,Gumilyov,Gunasekaran,Gunderman,Guneus,Gunhild,Gunila,Gunlod,Gunma,Gunn,Gunnarsson,Gunnels,Gunnie,Gunter,Gunterseeber,Guntherkurtze,Gunvor,Guo,
Guo,Shou,Jing,Gurij,Gurnemanz,Gurnikovskaya,Gurtler,Gurzhij,Gurzuf,Gussalli,Gustaflarsson,Gustafsson,Gustavbrom,Gutbezahl,Gutemberga,Guth,Gutierrez,Gutman,Guyane,Guyhurst,
Hel,Hela,Helamuda,Helena,Helenejacq,Helenorman,Helenos,Helensailer,Helensteel,Helentressa,Helenyao,Helenzier,Helewalda,Helfenstein,Helffrich,Helga,Helgoland,Heliaca,Helibrochier,Helicaon,Helina,Helio,Helionape,Hella,Hellahaasse,Hellawillis,Helma,Helmholtz,Helmi,Helmutmoritz,Helsingborg,Helsinki,Helvetia,Helvetius,Helwerthia,Hemaeberhart,Hemalibatra,Hemera,Hemerijckx,Hemingway,Hemmerechts,Hemmick,Hempel,Hemse,Henan,Hencke,Henden,Henderson,Hendricks,Hendrickson,Hendrie,Hendrika,Henja,Hennessy,Hennigar,Henning,Henninghaack,Hennyadmoni,Henrard,Henrietta,Hirohatagaoka,Hirohatanaka,Hirohisasato,Hirokimatsuo,Hiroko,Hirokohamanowa,Hirokun,Hiromi,Hiromiyuki,Hironaka,Hirons,Hiroo,Hirose,Hirosetamotsu,Hirosetanso,Hiroshi,Hiroshiendou,Hiroshikanai,Hiroshima,Hiroshimanabe,Hirotamasao,Hirsch,Hirst,Hirundo,Hirzo,Hisakichi,Hisako,Hisaohori,Hisashi,Hisayo,Hispania,Hissao,Hitachiomiya,Hitchcock,Hitchens,Hitomi,Hitomiyamoto,Hitoshi,Hitsuzan,Hittmair,Hiuchigatake,Hiwasa,Hiwatashi,Hjorter,Hjorth,Hladiuk,Hlawka,Hluboka,Hnath,Hoag,Hobart,Hobbes,Hobby,Hobetsu,Hobson,Hoburgsgubben,Hochlehnert,Hocking,Hoder,Hodge,Hypsipyle,Hyunseop,
IAU,INAG,INAOE,IRAS,IRSOL,IRTF,ISO,
ITA,IYAMMIX,Iafe,Iainbanks,Ialmenus,Ianchan,Ianfleming,Ianmorison,Iannini,Ianrees,Iansohl,Ianthe,Ianwessen,Iapyx,Iasky,Iasus,Iatteri,Ibadinov,Ibaraki,Ibarruri,Ibramohammed,Ibsen,Ibuki,Icarion,Icarus,Ichikawa,Ichikawakazuo,Ichimura,Ichinohe,Ichinomiya,Ichiroshimizu,Ichunlin,Icke,Iclea,
Ida,Idaios,Idamiyoshi,Idefix,Idelsonia,Idomeneus,Iduberga,Iduna,Idzerda,Ieshimatoshiaki,
Iga,Igaueno,Iglika,Ignace,Ignaciorod,Ignatenko,Ignatianum,Ildo,Ilfpetrov,Ilias,Ilinsky,Ilioneus,Iliya,Ilizarov,Illapa,Illeserzsebet,Illyria,Ilmari,Ilmatar,Ilona,Ilos,Ilse,Ilsebill,Ilsewa,Imabari,Imada,Imago,Imai,Imainamahoe,Imakiire,Imatra,Imbrie,Moore,Imelda,Imhilde,Imhotep,Immanuelfuchs,Iwasaki,Iwate,Iwatesan,Iwayaji,Ixion,
Iye,Izabelyuria,Izanaki,Izanami,Izenberg,Izett,Izhdubar,Izsak,
Izu,Izumi,Izvekov,Izzard,JAXA,
JPL,Jabberwock,Jablunka,Jacchia,Jachowski,Jack,London,Jackalice,Jackgrundy,Jackierobinson,Jackiesue,Jackieterrel,Jackli,Jackschmitt,Jackson,Jacktakahashi,Jackuipers,Jackwilliamson,Jacliff,Jaclifford,Jacobhurwitz,Jacobi,Jacobjohnson,Jacoblemaire,Jacobperry,Jacobrucker,Jacobshapiro,Jacobson,Jacquelihung,Jacqueline,Jacquescassini,Jacquescousteau,Jacqueslaskar,Jacquespiccard,Jacquey,Jaffe,Jagandelman,Jagras,Jahn,Jahreiss,Jaimeflores,Jaimenomen,Jakoba,Jakobstaude,Jakobsteiner,Jakpor,Jakubisin,Jallynsmith,Jalopez,Jalyhome,Jamarkley,James,James,Bond,James,Bradley,Jamesblanc,Jamescox,Jamescronk,Jamesdaniel,Jamesdunlop,Jamesearly,Jamesfenska,Jamesfisher,Jameshesser,Jamesjones,Jamesmcdanell,Jamesmelka,Jamesoconnor,Jamespopper,Jamestaylor,Jameswatt,Jameswu,Jamierubin,
Jan,Otto,Jana,Janacek,Janapittichova,Janboda,Jancis,Jandeboer,Jandl,Jandlsmith,Janeausten,Janebell,Janecox,Janegann,Janeirabloom,Janejacobs,Janelcoulson,Janelle,Janemcdonald,Janemojo,Janequeo,Janesick,Janesmyth,Janestrohm,Janesuh,Janetfender,Janetsong,Janfischer,Jangong,Jangyeongsil,Janhoet,Janice,Janina,Janinedavis,Janjosefric,Jankollar,Jankonke,Jankovich,Jankral,Janmerlin,Jannuzi,Janpalous,Jansje,Jansky,Jansmit,Jansteen,Janulis,Janvanparadijs,Janwillempel,Janzajic,Jaotsungi,Japellegrino,Jaracimrman,Jarda,Jaredgoodman,Jargoldman,Jarmila,Jarnefelt,Jarnik,Jaroff,Jarosewich,Jaroslawa,Jarre,Jarrydlevine,Jarvis,
Jas,Jaschek,Jasinski,Jasmine,Jasniewicz,Jasnorzewska,Jason,Jasonclain,Jasonelloyd,Jasonmorrow,Jasonschuler,Jasonwheeler,Jasonye,Jaspers,Jaucourt,Javid,Jawilliamson,Jaworski,Jayallen,Jayanderson,Jayaprakash,Jayaranjan,Jayardee,Jayeff,Jayewinkler,Jayleno,Jaynethomp,Jaytate,Jaytee,Jean,Claude,Jean,Jacques,Jean,Loup,Jean,
Luc,Jeancoester,Jeangodin,Jeanhugues,Jeankobis,Jeanli,Jeanlucjosset,Jeanmarcmari,Jeanmariepelt,Jeanmichelreess,Jeanne,Jeanneacker,Jeanneherbert,Jeanpaul,Jeanperrin,Jeans,Jeansimon,Jedicke,Jeffbaughman,Jeffbell,Jeffers,Jefferson,Jeffgrossman,Jeffhall,Jeffhopkins,Jeffjenny,Jeffkanipe,Jefflarsen,Jeffreyklus,Jeffreykurtz,Jeffreyxing,Jeffrich,Jefftaylor,Jeffthompson,Jeffwidder,Jeffwynn,Jefholley,Jekabsons,Jekhovsky,Jurasek,Jureskvarc,Jurgen,Jurgens,Jurgenstock,Jurijvega,Jussieu,Justinbarber,Justinbecker,Justinehenin,Justiniano,Justinkoh,Justinkovac,Justinto,Justitia,Justsolomon,Justus,Juterkilian,Jutta,Juubichi,Juvenalis,Juvisia,Juza,Juzoitami,Jyoumon,Jyuro,Jyvaskyla,KIAM,KLENOT,
Ka,Klytaemnestra,Klythios,Klytia,Klyuchevskaya,Klyuchevskij,Knacke,Knapp,Kneipp,d'Orient,Lacadiera,Lacaille,Lachat,Lachesis,Lacrimosa,Lacroute,Lacrowder,Lada,Ladanyi,Ladegast,Ladislavschmied,Ladoga,Laennec,Laertes,Laetitia,Lafayette,Lafcadio,Lafer,Sousa,Laffan,Laffra,Lafiascaia,Marcopolo,Marcosbosso,Marcospontes,Marcpostman,Marcusaurelius,Marcustacitus,Marcyeager,Mareike,Marekbuchman,Maren,Marenka,Maresjev,Mareverett,Marg,Edmondson,Margalida,Margaretgarland,Margaretmiller,Margaretpenston,Margarita,Margarshain,Marggraff,Marghanna,Margnetti,Margo,Margolin,Margon,Margot,Margret,Marhalpern,Nancyruth,Nancyworden,Nancywright,Nandaxianlin,Nandinisarma,Nanette,Naniwa,Nanjingdaxue,Nankichi,Nanking,Nankivell,Nanna,Nannidiana,Nanon,Nansenia,Nansmith,Nansouty,Nantong,Nantou,Nantucket,Nanwoodward,Nanyang,Nanyotenmondai,Nanyou,
Nao,Naoko,Naomi,Naomimurdoch,Naomipasachoff,Naomishah,Naoshigetani,Naotosato,Naoya,Naoyaimae,Naoyayano,Naozane,Napier,Napolitania,Naprstek,Nara,Narahara,Naranen,Narbut,Narcissus,Nardi,Narendra,Narmanskij,Narodychi,Narrenschiff,Naruhirata,Naruke,Narukospa,Naruto,Nash,Nasi,Nassau,Nassovia,Nasu,Nata,Nataliavella,Nevaruth,Neverland,Nevezice,Nevskij,Newberg,Newberry,Newburn,Newcombia,Newell,Newhams,Newman,Newtonia,Neyachenko,Nezarka,Nezhdanova,Nezval,Ngqin,Nguyen,Nguyen,McCarty,Ngwaikin,
Nha,Nhannguyen,Niagara,Falls,Nibutani,Niccolo,Nichol,Nicholashuey,Nicholasrapp,Okamuraosamu,Okasaki,Okauchitakashige,Okavango,Okayama,Okegaya,Oken,Okhotsk,Okhotsymskij,Okiko,Okina,Ouna,Okinawa,Okitsumisaki,Oklahoma,Okuda,Okudaira,Okudzhava,Okugi,Okumiomote,Okunev,Okuni,Okunohosomichi,Okunokeno,Okushiri,Okutama,Okyrhoe,Okyudo,Ol'gusha,Olaheszter,Olakarlsson,Olathe,Olaus,Magnus,Olausgutho,Olbersia,Old,
Joe,Oldfield,
Ole,Romer,Olea,Olegbykov,Olegefremov,Olegiya,Olegkotov,Olegpopov,Olegyankov,Oleshko,Olevsk,Olexakorol',Olextokarev,Oleyuria,Olga,Olgagermani,Olgakopyl,Olieslagers,Olihainaut,Olinwilson,Oliver,Oranienstein,Oranje,Paoloruffini,Paolotesi,Papacosmas,Papadopoulos,Papagena,Papaloizou,Papanov,Paperetti,Papike,Pappalardo,Papplaci,Pappos,Papymarcel,Paquet,Paquifrutos,Paracelsus,Paradise,Paradzhanov,Parana,Paranal,Paraskevopoulos,Parchomenko,Pardina,Parenago,Pareschi,Parfenov,Pariana,Parihar,Parijskij,Paris,Pariser,Parker,Parkerowan,Parkinson,Parks,Parlakgul,Parler,Parmenides,Paronelli,Parsa,Parsec,Parsifal,Part,Parthasarathy,Parthenope,Partizanske,Partridge,Parvamenon,Parvati,Parvulesco,Parysatis,Pasacentennium,Pasachoff,Pasadena,Pasasymphonia,Pascal,Pascalepinner,Pascalscholl,Paschen,Pascoli,Rachelmarie,Rachelouise,Rachmaninoff,Rachnareddy,Racine,Racollier,Racquetball,Raczmiklos,Radaly,Radcliffe,Radebeul,Radegast,Radek,Radiocommunicata,Radishchev,Radmall,Radomyshl,Radonezhskij,Radzievskij,Raes,Rafaelnadal,Rafaelta,Rafes,Raffaellosanti,Raffinetti,Rafita,Ragazza,Ragazzileonardo,Raghavan,Raghrama,Raghvendra,Rahaelgupta,Raharto,Rahua,Raiatea,Raikin,Raimeux,Raimonda,Rainawessen,Rainbach,Raine,Rainer,Rainerkling,Rainerkracht,Rainerwieler,Raisanyo,Raissa,Rajagopalan,Rajdev,Rajendra,Rajivgupta,Rakhat,Rakos,Raksha,Raktanya,Rakuyou,Ralhan,Ralph,Ralpharvey,Ramachandran,Rickman,Rickschaffer,Rickwhite,Ricmccutchen,Ricoromita,Ricouxa,Ride,Ridley,Riehl,Rieko,Riema,Riemann,Riemenschneider,Ries,Simeisa,Simek,Simferopol,Simmons,Simoeisios,Simohiro,Simon,Garfunkel,Simona,Simoneflood,Simonek,Simonelli,Simonemarchi,Simonenko,Simonetta,Simongreen,Slavicek,Stefanovalentini,Stefanozavka,Stefanwul,Stefanzweig,Steffl,Stefuller,Stegosaurus,Steiermark,Steigmeyer,Steina,Steinbach,Steinberg,Steinerzsuzsanna,Steinhardt,Steinheil,Steinheim,Steinmetz,Steins,Stejneger,Stek,Stekarstrom,Stekramer,Stelck,Stelguerrero,Stellafane,Stellakwee,Stellaris,Steller,Stelzhamer,Stenflo,Stenhammar,Stenholm,Stenkumla,Stenkyrka,Stenmark,Stentor,Stepanian,Stepanmakarov,Stepanov,Stepciechan,Stephania,Stephaniehass,Stephbecca,Stephbillings,Stephencolbert,Stephengould,Stephenhonan,Stephenlevine,Stephenmaran,Stephenshulz,Stephensmith,Stephenstrauss,Stephicks,Stephoskins,Stephwerner,Stepling,Stereoskopia,Sterken,Stern,Sternberga,Sterner,Sterpin,Sumatijain,Sumaura,Sumava,Sumeria,Sumerkin,Sumiana,Sumida,Sumiko,Suminao,Suminov,Sumizihara,Summa,Summanus,Summerfield,Summerscience,Sumoto,Sunanda,Sunao,Suncar,Sundaigakuen,Sundaresh,Sundmania,Sundre,Sundsvall,Sunflower,Sungjanet,Sungjaoyiu,Sungkanit,Sungwoncho,Sunilpai,Sunjiadong,Sunkel,Sunsetastro,Sunshine,Sunyaev,Sunyisui,Suomi,Supasternak,Superbus,Supokaivanich,Surajmishra,Surgut,Surikov,Surkov,Suruga,Susa,Susanagordon,Susanbehel,Susanduncan,Susanjohnson,Susank,Susanlederer,Susanna,Susannemond,Susannesandra,Susanoo,Susanragan,Susanreed,Susanring,Susanrose,Susanruder,Susansmith,Susanstoker,Susanvictoria,Sushko,Susi,Susieclary,Susiestevens,Susil,Susilva,Susono,Sussenbach,Sussman,Susumu,Susumuimoto,Susumutakahasi,Suthers,Sutoku,Sutter,Sutton,Suvanto,Suvorov,Suwanasri,Suyihan,Suyumbika,Suzaku,Suzamur,Suzannedebarbat,Suzannehawley,Suzhou,Suzhousanzhong,Suzuki,Suzukiseiji,Suzukisuzuko,Suzuko,Suzyamamoto,Svanberg,Svanetia,Svarna,Svatopluk,Svea,Svecica,Svejcar,Svejk,Svenders,Sverige,Sveshnikov,Svestka,Sveta,Svetlanov,Svetlov,Svetochka,Sviderskiene,Svirelia,Sviridov,Svoboda,Svojsik,Svoren,Svyatorichter,Svyatylivka,Svyaztie,Swain,Swammerdam,Swann,Swanson,Swasey,Swedenborg,Sweelinck,Sweeney,Sweet,Sweitzer,Swetlana,Swift,Swiggum,Swindle,Swings,Swintosky,Swissair,Swope,
Sy,Syang,Sybil,Sychamberlin,Sydney,Sydneybarnes,Sykes,Sylrobertson,Sylvania,Sylvatica,Sylvester,Sylvia,Sylviecoyaud,Symmetria,Syoyou,Syringa,Syrinx,Syuji,Syukumeguri,Szabo,Szalay,Szatmary,Szechenyi,Szeged,Szeidl,Szentmartoni,Szigetkoz,Szilard,Szkody,Szmytowna,Szpilman,Szrogh,Szukalski,TARDIS,TRIUMF,Tabei,Tabeisshi,Table,Mountain,Tabora,Taborsko,Tacchini,Tachibana,Tachikawa,Tacitus,Taco,Tadamori,Tadjikistan,Taesch,Taeve,Tafelmusik,Taga,Tagaharue,Tagayuichan,Tagore,Taguacipa,Taguchi,Tahilramani,Tahin,Tahiti,Taichikato,Taichung,Taihaku,Taiki,Taiko,Tainai,Tainan,Tairov,Taiwan,Taiyonoto,Taiyuan,Taizaburo,Taize,Taizomuta,Tajimi,Takaaki,Takabatake,Takachiho,Takagi,Takagitakeo,Takahashi,Takahata,Takahisa,Takaishuji,Takaji,Takakura,Takamagahara,Takamatsuda,Takamizawa,Takane,Takanochoei,Takanotoshi,Takao,Takaoakihiro,Takaotengu,Takarajima,Takasago,Takase,Takashiito,Takashimizuno,Takatahiro,Takatsuguyoshida,Takatsuki,Takatumuzi,Takayamada,Takayanagi,Takayuki,Takayukiota,Takeda,Takehiro,Takei,Takeishi,Takeno,Takenouchi,Takeosaitou,Takeshihara,Takeshima,Takeshisato,Takeuchiyukou,Takeyama,Takeyamamoto,Takiguchi,Takihiroi,Takimoto,Takimotokoso,Takinemachi,Takoyaki,Taku,Takuboku,Takuma,Takumadan,Takumi,Takushi,Takuya,Takuyaonishi,Talbot,Talent,Taliagreene,Taliajacobi,Talich,Talima,Tallapragada,Tallinn,Talos,Talthybius,Tama,Tamaga,Tamagawa,Tamakasuga,Tamao,Tamara,Tamarakate,Tamariwa,Tamashima,Tamblyn,Tambov,Tamines,Tammann,Tammy,Tammydickinson,Tammytam,Tamotsu,Tampere,Tamriko,Tamsendrew,Tamsenprofit,Tamsin,Tamyeunleung,Tana,Tanabe,Tanais,Tanaka,Tanakadate,Tanakami,Tanakawataru,Tanaro,Tanchozuru,Tanchunghee,Tancredi,Tanegashima,Tanemahuta,Tanete,Tang,Quan,Tanga,Tangshan,Tangtisheng,Tanigawadake,Taniguchi,Taniguchijiro,Tanikawa,Tanina,Tanith,Tanjiazhen,Tankanran,Tanner,Tannokayo,Tanpitcha,Tantalus,Tante,Riek,Tantetruus,Tanuki,Tanya,Tanyapetach,Tanyuan,Tanzi,Taofanlin,Taormina,Taoyuan,Tape,Tapio,Tapolca,Tapping,Tara,Taracho,Taranis,Taratuta,Tarcisiozani,Tarendo,Tarka,Tarkovskij,Tarn,Taro,Taroubou,Tarrega,Tarroni,Tarry,Tarsia,Tarsila,Tarski,Tartaglia,Tartakahashi,Tarter,Tartois,Tartu,Tarumi,Tarxien,Tasaka,Taschner,Tashikuergan,Tashko,Tasman,Tassantal,Tasso,Tata,Tataria,Tatarinov,Tatebayashi,Tateshina,Tati,Tatianicheva,Tatianina,Tatishchev,Tatjana,Tator,Tatry,Tatsuaki,Tatsuo,Tatulian,Tatum,Taufiq,Tauntonia,Taunus,Taurinensis,Tauris,Tautenburg,Tautvaisiene,Tavannes,Tavastia,Tawaddud,Tawadros,Taylor,Taylorgaines,Taylorjones,Taylorkinyon,Taylorwilson,Tazieff,Tchaikovsky,Tchantches,
Tea,Teague,Tealeoni,Teamequinox,Tebbutt,Teckman,Tecleveland,Tedbunch,Teddunham,Tedesco,Tedflint,Tedkooser,Tegler,Teharonhiawako,Teika,Tejima,Tekaridake,Tekmessa,Telamon,Telc,Telegramia,Teleki,Telemachus,Telemann,Telephus,Telesio,Tell,Teller,Tellervo,Telramund,Temirkanov,Tempel,Templeanne,Templehe,Tenagra,Tenchi,Teneriffa,Teng,Tengstrom,Tengukogen,Tengzhou,Tenmu,Tennyo,Tenojoki,Tenpyou,Tensho,
kan,Tentaikojo,Tentlingen,Tenzing,Tenzinyama,Teodorescu,Teply,Terakado,Terakawa,Terao,Terasako,Terazono,Terbruggen,Terbunkley,Tercidina,Terebizh,Terentia,Teta,Tetrix,Tetruashvily,Tetsufuse,Tetsujiyamada,Tetsumasakamoto,Tetsuokojima,Tetsuro,Tetsuya,Tetuokudo,Teucer,Teutoburgerwald,Teutonia,Tevelde,Tewksbury,Texas,Texereau,Texstapa,Textorisova,Tezcatlipoca,Tezuka,Thagnesland,Thais,Thakur,Thales,Thalia,Thalpius,Thangada,The,
The,NORC,Thebault,Theberge,Thekla,Thelmaruby,Thelonious,Themis,Theobalda,Theodora,Theojones,Theoklymenos,Theotes,Therberens,Thereluzia,Theresafultz,Theresaoei,Theresia,Thereus,Thernoe,Thersander,Thersilochos,Thersites,Thessalia,Thessandrus,Thetis,Thewrewk,Thia,Thiagoolson,Thicksten,Thiele,Thielemann,Thierry,Thionville,Thirsk,Thisbe,Thoas,Tholen,Thoma,Thomana,Thomas,Thomas,Aquinas,Thomasandrews,Thomasaunins,Thomasburr,Thomasgoodin,Thomasjohnson,Thomaslynch,Thomasmuller,Thomasnesch,Thomasreiter,Thomassilver,Thomayer,Thomgregory,Thomjansen,Thomsen,Thomwilkason,Thooft,Thora,Thoreau,Thorenia,Thorvaldsen,Thosharriot,Thottumkara,Thouvay,Thraen,Thrasymedes,Thucydides,Thuillot,Thule,Thulin,Thumper,Thunberg,Thuringer,Wald,Thuringia,Thurmann,Thusnelda,Thyestes,Thygesen,Thymoitos,Thyra,Tiamorrison,Tianhuili,Tianjin,Tianyahaijiao,Tiburcio,Ticha,Ticino,Tickell,Tieck,Tienchanglin,Tiepolo,Tieproject,Tohru,Toinevermeylen,Tokai,Tokara,Tokeidai,Tokigawa,Tokikonaruko,Tokio,Tokitada,Tokiwagozen,Tokorozawa,Tokunaga,Tokunai,Tokushima,Tokyogiants,Tokyotech,Toland,Toldy,Tolerantia,Tolik,Tolkien,Tololo,Tolosa,Tolstikov,Tomahrens,Tomaiyowit,Tomasko,Tomatic,Tombaugh,Tombecka,Tombickler,Tomboles,Tomburns,Tomcarr,Tomcave,Tomcowling,Tomeileen,Tomeko,Tomhamilton,Tomhanks,Tomhenning,Tominari,Tomioka,Tomita,Tomizo,Tomjohnson,Tomjones,Tomkaye,Tomlindstom,Tomlinson,Tommaso,Tommei,Tommorgan,Tommygrav,Tomnash,Tomoegozen,Tomohiro,Tomohiroohno,Tomohisa,Tomoki,Tomokofujiwara,Tomonaga,Tomoyamaguchi,Tomroman,Tomsk,Tomswift,Tomvandijk,Tomyris,Tomzega,Tone,Tonegawa,Tongariyama,Tongil,Tongjili,Tongkexue,Tongling,Tongzhan,Toni,Tonimoore,Tonivanov,Toniwest,Tonucci,Tonyho,Tonyhoffman,Tonyjudt,Tonypensa,Tonysharon,Tonyspear,Tooting,Toots,Topeka,Torahiko,Torasan,Toravere,Trebon,Trebur,Treenajoi,Trefftz,Treiso,Trelleborg,Tremaine,Tremolizzo,Trenker,Trentman,Treshnikov,Tresini,Tret'yakov,Trettel,Trettenero,Trevanvoorth,Trevino,Trevires,Trevorcorbin,Trevorpowers,Triathlon,Triberga,Triceratops,Tricomi,Triconia,Triglav,Trigo,Turing,Turkmenia,Turku,Turnbull,Turnera,Uedashoji,Uedayukika,Ueferji,Uemura,Uemuraikuo,Uenohara,Ueta,
Ufa,Uganda,Uggarde,Uglia,Uhland,Uhlenbeck,Uhlherr,Ujibe,Ujifusa,Ukai,Ukalegon,Ukawa,Ukichiro,Ukko,Ukraina,Ukyounodaibu,
Ul,Ul'yanin,Ulanova,Ulfbirgitta,Ulferika,Ulissedini,Ulla,Ullacharles,Ullery,Ullischwarz,Ullithiele,
Ulm,Ulmerspatz,Ulrike,Ultrajectum,Veeder,Vehrenberg,Veillet,Veisberg,Vejvoda,Velasco,Velasquez,Velehrad,Velenia,Velez,Velichko,Velikhov,Velikij,Ustyug,Velimir,Vellamo,Vinata,Vinay,Vincentina,Vinceteri,Vinciguerra,Vindobona,Vinhoward,Vinifera,Vinissac,Vinjamoori,Vinko,Vivaldi,Vivekbucse,Whiteknight,Whiteley,Whiterabbit,Whitfield,Whitford,Whithagins,Whither,Whitley,Whitney,Whitson,Whittemora,Whittle,Wiberg,Wichmann,Wichterle,Wickramasekara,Wickwar,Widemann,Widmanstatten,Widorn,Wieck,Wiegert,Wieland,Wielen,Wiener,Wienphilo,Wiesendangen,Wiesenthal,Wiesinger,Wiesloch,Wigeon,Wiggins,Wightman,Wikberg,Wikipedia,Wikrent,
Wil,Wilber,Wilburwright,Wild,Wildberg,Williamlopes,Williammonts,Williamon,Williamprem,Williams,Williwaw,Willnelson,Willpatrick,Wilmacherup,Wilson,Wilson,Harrington,Wimberly,Wimfroger,Wimhermans,Winchester,Winckelmann,Winer,Wingip,Wingolfia,Winifred,Winigleason,Winkler,Winmesser,Winnecke,Winnewisser,Winokur,Winslow,Winters,Winterthur,Winton,Wirt,Wischnewski,Wisdom,Wisibada,Wislicenus,Wisniewski,Wisniowiecki,Wisse,Wissnergross,Witsen,Witt,Wujunjun,Wumengchao,Wuminchun,Wunderlich,Wundt,Wuqijin,Wurm,Wurttemberg,Wutayou,Wuwenjun,Wuyeesun,Wuzhengyi,Wyeth,Wygoda,Wykrota,Wylie,Wysner,Xandertielens,Xanthe,Xanthippe,Xanthoma,Yenuanchen,Yeomans,Yepeiyu,Yerkes,
Yes,Yesenin,Yeshuhua,Yeti,Yeungchuchiu,Yeuseyenka,Yezo,
Yi,Xing,Yichenzhang,Yicheon,Yidaeam,Yifanli,Yihedong,Yihuali,Yiliuchen,
Yim,Yingfan,Yingling,Yingqiuqilei,Yingxiong,Yinhai,Yinyinwu,
Yip,Yiqunchen,Yisun,Yisunji,Yiwu,Yixinli,Yiyideng,Ylppo,Yocum,Yoder,Yogeshwar,Yogisullivan,Yoichi,Yojikondo,Yokaboshi,Yoko,Yokohasuo,Yokokurayama,Yokonomura,Yokootakeo,Yokosugano,Yokota,Yokotatakao,Yonematsu,Yoneta,Yonezawa,Yonosuke,Yorii,Yorimasa,Yoritomo,York,Yorktown,Yoron,Yosakoi,Yoshiaki,Yoshiakifuse,Yoshida,Yoshidamichi,Yoshidatadahiko,Yoshidayama,Yoshigeru,Yoshihara,Yoshihide,Yoshihiro,Yoshii,Yoshikaneda,Yoshikawa,Yoshikazu,Yoshiken,Ysaye,Yualexandrov,Yuan,Yuanfengfang,Yuanlongping,Yuanzhang,Yubangtaek,Yuliya,Yulong,Yumeginga,Yumi,Yunxiangchu,Yuribo,Yurigulyaev,Yurijgromov,Yuriko,Yurilvovia,Yuriosipov,Yurishevchuk,Yurka,Yurkanin,Yurlov,Yusaku,Yushan,Yushiwang,Yutonagatomo,Yuudurunosato,Yuuko,Yuuzou,Yuvalcalev,Yuyakekoyake,Yuyinchen,Yuzuruyoshii,Yvette,Yvetteleung,Yvonne,Yvonnealex,Yvonneroe,Ywain,ZZ,
Top,Zabadak,Zabinski,Zabori,Zachariassen,Zacharyrice,Zachia,Zachlynn,Zachopkins,Zachotin,Zachozer,Zachpenn,Zachulett,Zadornov,Zadunaisky,Zafar,Zagar,Zagreb,Zahller,Zahnle,Zahradnik,Zahramaarouf,Zahringia,Zajic,Zajonc,Zajtsev,Zakamska,Zakharchenko,Zakharchenya,Zalgiris,Zambesia,Zambujal,Zamenhof,Zanda,Zane,Zanin,Zanonato,Zanotta,Zanstra,Zanzanini,
Zao,Zapesotskij,Zaphod,Zappa,Zappafrank,Zappala,Zarabeth,Zaragoza,Zarnecki,Zarrin,Zashikiwarashi,Zatopek,Zauberflote,Zavist,Zavolokin,Zbarsky,Zdanavicius,Zdasiuk,Zdenekhorsky,Zdenekmatyas,Zdenekmiler,Zdenka,Zdenkaplavcova,Zdiksima,Zdislava,Zdvyzhensk,Zech,Zeelandia,Zeeman,Zeeshansayed,Zeglin,Zehavi,Zeilinger,Zeissia,Zeitlin,Trinkle,Zeldovich,Zeletava,Zelezny,Zelia,Zelima,Zelinda,Zelinsky,Zelkowitz,Zellner,Zellyfry,Zelter,Zembsch,Schreve,Zemka,Zemtsov,Zenbei,Zengguoshou,Zenisek,Zenkert,Zenobia,Zielenbach,Ziffer,Zigamiyama,Zilkha,Zille,Zimin,Ziminski,Zimmer,Zimmerman,Zimmerwald,Zimolzak,Zinner,Zinzendorf,Zipfel,Zirankexuejijin,Zissell,Zita,Ziziyu,Zizza,Zlata,Koruna,Znannya,Znojil,Znokai,Zoccoli,Zolensky,Zollitsch,Zolotov,Zoltowski,Zomba,Zook,Zoser,Zoshchenko,Zoya,Zykina,Zyskin";

$nameArray = explode(",", $nameList);

function getRandomName() {
    return array_rand($nameArray);
}
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
$sID = makeSolarSystem($ROWS, $COLS);
for($x=0; $x<$ROWS; $x++) {
    for($y=0; $y<$COLS; $y++) {
        if($galaxyArray[$x][$y] == 0 || $galaxyArray[$x][$y] == 'b'){
            echo "<span style='color:black; display:block; float:left'>" . $galaxyArray[$x][$y] ."</span>";
        }elseif($galaxyArray[$x][$y] == 1){
            insertStellarObject($sID, $x, $y, 1);
            echo "<span style='color:yellow; display:block; float:left'>" . $galaxyArray[$x][$y] ."</span>";
        }elseif($galaxyArray[$x][$y] == 2){
            insertStellarObject($sID, $x, $y, 2);
            echo "<span style='color:green; display:block; float:left'>" . $galaxyArray[$x][$y] ."</span>";
        }elseif($galaxyArray[$x][$y] == 3){
            insertStellarObject($sID, $x, $y, 3);
            echo "<span style='color:aqua; display:block; float:left'>" . $galaxyArray[$x][$y] ."</span>";
        }elseif($galaxyArray[$x][$y] == 4){
            insertStellarObject($sID, $x, $y, 4);
            echo "<span style='color:azure; display:block; float:left'>" . $galaxyArray[$x][$y] ."</span>";
        }elseif($galaxyArray[$x][$y] == 5){
            insertStellarObject($sID, $x, $y, 5);
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
