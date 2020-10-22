<?php
/**
 * Model that represents and Object on de database but ignores its columns
 */
class Entity {
    /**
     * Repository to make the querys
     */
   public $repository;
   
   /**
    * Form to save data (development)
    */
   public $form;
   
   /**
    * 
    * @return instance of the repository of the entity
    */
   public function getRepository(){
       /**
        * If $this->repository is already and object i'm not declaring it again, just return the instance.
        */
       if(!is_object($this->repository))
       {
           if(is_readable(__REPOSITORY__.$this->repository."_Repository.php"))
            {
                require  __REPOSITORY__.$this->repository."_Repository.php";
                $repo = $this->repository."_Repository";
                $this->repository = $repo::singelton();
            } 
       }
       return $this->repository;
       
   }
   
   /**
    * Instance of the repository to make the form
    */
   public function createForm($entity) {
       if(is_readable(__FORM__.$this->form."_Form.php"))
       {
           require_once __FORM__.$this->form."_Form.php";
           $form = $this->form."_Form";
       }
   }
   
   public function __construct() {
        $this->repository = get_class($this);
        $this->form = get_class($this);
    }
   
}
