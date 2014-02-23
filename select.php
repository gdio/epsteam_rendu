<?php
try {
    // a new MongoDB connection
    $conn = new Mongo('localhost:27017');
    // connect to test database
    $db = $conn->test;
	//collection name
   $collection = $db->api;
    // récuperer le contenu de la collection
    $cursor = $collection->find();
    $i = 0;
    // taille
    $num_docs = $cursor->count();
    if( $num_docs > 0 )
    {
        // boucle cursor de resultats
        echo '{
                "sEcho": 1,
                "iTotalRecords": '.$num_docs.',
                "iTotalDisplayRecords": '.$num_docs.',
                "aaData": [';
        foreach ($cursor as $obj)
        {
            //Ici on traite l'objet récupéré de la bdd pour avoir un jolie json valide ! 
            $string = json_encode($obj);
            $arrayofString = explode(',',$string);
            
            if($i == $num_docs-1)
            {
              echo substr(stripslashes($arrayofString[1]).','.substr(stripslashes($arrayofString[2]),0,-4),1,-1).",\"game\":\"".$obj['0']."\"}";
            }
            else
            {
                echo substr(stripslashes($arrayofString[1]).','.substr(stripslashes($arrayofString[2]),0,-4),1,-1).",\"game\":\"".$obj['0']."\"},";
            }
            $i++;
        }
        echo ']}';
    }
    else
    {
       echo "No products found \n";
    }

    // close 
    $conn->close();
}
catch ( MongoConnectionException $e )
{
  
    echo $e->getMessage();
}
catch ( MongoException $e )
{
    echo $e->getMessage();
}

?>