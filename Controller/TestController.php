<?php
/**
 * Controller that its called in case of route or action not defined and throws an 404
 */
class TestController extends FController{
    
    public function testInsert()
    {
        $params = $_POST;

        $array = array_map(function($v){
            return mb_convert_encoding($v,"ISO-8859-1");
        },$params);
        
    }
    
	public function Hello()
	{
		print_r($_SERVER["REMOTE_ADDR"]);
	}
    
}
