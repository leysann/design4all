<?php

$contextOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false
    )
);

$context = stream_context_create($contextOptions);

$PAPER_ITEMS = array();

$PAPER_URL ='https://docs.google.com/a/unitn.it/spreadsheets/d/1MhMoM17qN7bZNZ1v0xMginvBi9pakR4NFISTp47f9xI/export?format=csv&id=1MhMoM17qN7bZNZ1v0xMginvBi9pakR4NFISTp47f9xI&gid=1861810641';


/* Load guidelines from Google Spreadsheets */                                   
function load_csv(){     
    global $PAPER_ITEMS, $PAPER_URL, $context;                                                                                   

    // open file for reading
    $n = 0;
    $media = FALSE;
    
    if (($handle = fopen($PAPER_URL, "r", TRUE, $context)) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            if ($n > 0 && $row[0] != '') {            
                            
                $pub = array(
                    "id" => $row[0],
                    "title" => $row[1]                   
                );

                array_push($PAPER_ITEMS, $pub);      
            }
            $n++;
        }
        fclose($handle);
    }
}

/* dump the array to json */
function to_json_papers(){
  global $PAPER_ITEMS;
  $json = json_encode($PAPER_ITEMS);
  print $json;
}

load_csv();
to_json_papers();

?>
