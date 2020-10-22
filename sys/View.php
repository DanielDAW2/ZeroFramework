<?php

/**
 * Class to render the html
 */
class View {

    /**
     * 
     * @param type $view (template to use)
     * @param type $data (data to send to $view)
     */
    public function render($view, $data = array())
    {
        ob_start();
        echo $this->getTemplate($view,$data);
        ob_end_flush();
    }
    
    /**
     * 
     * @param string $array array that is being encoded in json and send it as response
     */
    public function renderJSON($array = array())
    {
        ob_start();
		// Code de array to a UTF-8 and send the response
		foreach($array as $key => $value)
		{
			foreach($value as $keyv => $val)
			{
				$array[$key][$keyv] = utf8_encode($val);
			}
		}
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        ob_end_flush();

    }
    
    /**
     * Function to retrieve a template
     */
    private function getTemplate($file)
    {
        $file = file_get_contents(__VIEWS__.$file);
        
        return $html;
    }
}
