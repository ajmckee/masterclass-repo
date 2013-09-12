<?php

namespace Upvote\Application\Controllers;

use \Upvote\Application\Models as Model;
class Comment extends ControllerBase 
{
	
	public function create()
	{
		if(!isset($_SESSION['AUTHENTICATED'])) {
            die('not auth');
            header("Location: /");
            exit;
        }
        
        // New Comment model.
        $Comment = new Model\Comment($this->getConfig());
        
        // Could also use Model::populate method if k/v pairs match.
        $Comment->created_by = $_SESSION['username'];
        $Comment->story_id = $_POST['story_id'];
        $Comment->comment = $_POST['comment'];
        $Comment->created_on = new \DateTime();
        
        // @todo Add validation & exception handling.
        // ($Comment->isValid()) ? $Comment->save():null;
        
        $Comment->save();
        
        // Redirect back
        header("Location: /story/?id=" . $_POST['story_id']);
	}
}