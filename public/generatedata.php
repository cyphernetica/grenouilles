<?php

$datas = [];
$numberToGenerate = 30;

$animalTypes= ['grenouille', 'coleoptera'];

$owners =["Airiam","Hannah Cheesman","Jonathan Archer","Soji Asha","Ayala","Azan","Reginald Barclay","Bareil Antos","Julian Bashir","B'Etor","Brad Boimler","Boothby","The Borg Queen","Alice Krige","Phillip Boyce","Brunt","R.A. Bryce","Gabrielle Burnham","Michael Burnham","Joseph Carey","Chakotay","Christine Chapel","Pavel Chekov","Anton Yelchin","Chell","J. M. Colt","Katrina Cornwell","Kimara Cretak","Megan Cole","Beverly Crusher","Wesley Crusher","Hugh Culber","Jal Culluh","Elizabeth Cutler","Leonardo da Vinci","Damar","Daniels","Data","Ezri Dax","Jadzia Dax","Degra","Keyla Detmer","The Doctor","Dolim","Dukat","Michael Eddington","Elnor","Evek","Female Changeling","Vic Fontaine","Maxwell Forrest","Elim Garak","Garrison","Philippa Georgiou","Sonya Gomez","Gowron","Amanda Grayson","Winona Ryder","Mia Kirshner","Guinan","J. Hayes","Erika Hernandez","Hogan","Mr. Homn","Hugh","Icheb","Casey King","Ishka","Andrea Martin","Kathryn Janeway","Jannar","Michael Jonas","Agnes Jurati","K'Ehleyr","Kes","Khan Noonien Singh","Benedict Cumberbatch","Harry Kim","Kira Nerys","James T. Kirk","Chris Pine","Kol","Kor","Kurn","Geordi La Forge","Laris","Leeta","Robin Lefler","Leland","Li Nalas","Linus","Gabriel Lorca","Lore","L'Rell","Lursa","Maihar'du","Mallora","Carol Marcus","Alice Eve","Beckett Mariner","Martok","Travis Mayweather","Leonard McCoy","Karl Urban","Mezoti","Mila","Mora Pol","Morn","Mot","Harry Mudd","Rainn Wilson","Raffi Musiker","Narek","Alynna Nechayev","Neelix","Nhan","Susan Nicoletti","Nilsson","Nog","Kashimuro Nozawa","Keiko O'Brien","Miles O'Brien","Molly O'Brien","Odo","Alyssa Ogawa","Oh","Opaka Sulan","Joann Owosekun","Owen Paris","Tom Paris","Phlox","Jean-Luc Picard","Christopher Pike","Bruce Greenwood","Anson Mount","Tracy Pollard","Katherine Pulaski","Q","Quark","Janice Rand","Rebi","Malcolm Reed","Jet Reno","Gen Rhys","William Riker","Cristobal  Rios","Narissa Rizzo","Ro Laren","Rom","William Ross","Michael Rostov","Alexander Rozhenko","Brian Bonsall","Saavik","Robin Curtis","Sarek","Ben Cross","James Frain","Saru","Hoshi Sato","Sela","Seska","Seven of Nine","Montgomery Scott","Simon Pegg","Shakaar Edon","Thy'lek Shran","Silik","Benjamin Sisko","Jake Sisko","Jennifer Sisko","Joseph Sisko","Sarah Sisko","Luther Sloan","Soval","Spock","Zachary Quinto","Ethan Peck","Paul Stamets","Lon Suder","Hikaru Sulu","John Cho","Enabran Tain","Tal Celes","Sylvia Tilly","Tomalak","Tora Ziyal","Cyia Batten","B'Elanna Torres","T'Pol","The Traveler","Deanna Troi","Lwaxana Troi","Charles Tucker","Tuvok","Ash Tyler / Voq","José Tyler","Nyota Uhura","Zoe Saldana","Una ('Number One')","Rebecca Romijn","Vash","Vorik","Weyoun","Naomi Wildman","Samantha Wildman","Winn Adami","Worf","Tasha Yar","Kasidy Yates","Zek","Zhaban"];
$playGroundWidth= (2220 / 60) ;
$playGroundHeight= (840 / 60 );
$points = [];
for($i=0; $i< $numberToGenerate; $i++) {
    $animal= new stdClass();
    $animal->type = $animalTypes[rand(0, count( $animalTypes) - 1 ) ];
    $animal->size = "60";
    $animal->mood = rand(0, 4);
    $animal->adapted = rand(0, 1);
    $animal->owner = '';
    if( $animal->adapted === 1 ){
        $animal->adapted = true;
        $animal->owner = $owners[rand(0, count($owners) - 1 )];
    }
    else{
        $animal->adapted = false;
    }
    $position = new stdClass();
    $havePos = false;

    while(!$havePos){
        $x = floor( rand(0, $playGroundWidth) );
        $y = floor (rand(0, $playGroundHeight)  );
        
        $position->x = $x * 60;
        $position->y = $y * 60;
        $found = isAlreadyOccuped($position, $points);
        if( !$found ){
            $animal->position = $position;
            $points[] = $position;
            $havePos = true;
        }
    }


    $datas[] = $animal;


}

echo '<h1>Generation de données</h1>';
echo '<pre>';
print_r($datas);
echo '</pre>';

$fp = fopen('./data/animals.json', 'wb');
fwrite($fp, json_encode($datas, JSON_PRETTY_PRINT) );
fclose($fp);



function isAlreadyOccuped($position, $list) {
    $res = false;

    for($i=0; $i<count($list);$i++) {
        $p = $list[$i];
        if( $p->x == $position->x && $p->y == $position->y) return true;
    }

    return $res;

}

