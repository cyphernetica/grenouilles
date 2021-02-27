<?php

$datas = [];


$animalTypes= ['grenouille', 'coleoptera'];


$playGroundWidth= (2220 / 60) ;
$playGroundHeight= (840 / 60 ) + 1;


for($i=0; $i< $playGroundHeight ; $i++) {
    $dataRow = [];
   for($j=0; $j < $playGroundWidth; $j++) {
        $position = new stdClass();
        $type = 1; 
        $position->x = $j * 60;
        $position->y = $i * 60;

        switch( [$i,$j]){
            case [6,6]:
            case [7,5]:
            case [7,6]:
            case [7,7]:
            case [8,6]:
                case [7,21]:
                    case [7,22]:
            case [8,21]:    
                case [8,22]:
                $type = 2;   
                break;
            case [6,13]:
                $type = 3;
                break;    
        }



        $data = [
            'position' => $position,
            'type' => $type,
        ];

       
        
        
        array_push($dataRow, $type);
   }
   array_push($datas, $dataRow);
}

echo '<h1>Generation de map</h1>';
echo '<pre>';
print_r($datas);
echo '</pre>';

$fp = fopen('./data/playground.json', 'wb');
fwrite($fp, json_encode($datas, JSON_PRETTY_PRINT) );
fclose($fp);


