<?php
/**
 * Controller that its called in case of route or action not defined and throws an 404
 */
class DefaultController extends FController{
    
    public function error()
    {
        http_response_code(404);
        echo json_encode("No route definded");
    }
    
	public function Hello()
	{
		print_r($_SERVER["REMOTE_ADDR"]);
	}
    
}
