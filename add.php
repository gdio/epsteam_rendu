<?php
$post_vars = [];

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo "this is a get request\n";
    //echo $_GET['player'];
   /* $post_vars['player'] = $_GET['player'];
    $post_vars['badge'] = $_GET['badge'];
    $post_vars['game'] = $_GET['game'];*/

    
} elseif($_SERVER['REQUEST_METHOD'] == 'PUT') {
    echo "this is a put request\n";
    parse_str(file_get_contents("php://input"),$post_vars);
    var_dump($post_vars);
}

try {
        if($post_vars!=null)
        {
            // Connect to MongoDB
            $conn = new Mongo('localhost:27017');
            // connect to test database
            $db = $conn->test;
            // api collection 
            $collection = $db->api;
            //We add game from url
            $game = substr($_SERVER['PATH_INFO'],7);
            array_push($post_vars, $game);
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