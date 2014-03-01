<?php
$post_vars = [];


    parse_str(file_get_contents("php://input"),$post_vars);
    var_dump($post_vars);


try {
        if($post_vars!=null)
        {
            // Connect to MongoDB
            $conn = new Mongo('localhost:27017');
            // connect to test database
            $db = $conn->test;
            // api collection 
            $collection = $db->api;
            //We add game from url and date from php
            $game = substr($_SERVER['PATH_INFO'],7);
            date_default_timezone_set('Europe/Paris'); //Pour avoir l'heure de paris
            $datetime = date("d-m-Y H:i:s");

            //push
            array_push($post_vars, $game);
            array_push($post_vars, $datetime);
            // valeurs à inserer 
            $scores = $post_vars;
            // insertion
            $collection->insert( $scores );
            echo 'Scores inserted with ID: ' .$scores['_id'] . "\n";
            // close 
            $conn->close();
        }
	}
catch ( MongoConnectionException $e )
{
        // affichage erreurs
        echo $e->getMessage();
}
catch ( MongoException $e )
{
        echo $e->getMessage();
}

?>