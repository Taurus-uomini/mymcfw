<?php
    class baseController
    {
        private $postdata=array();
        public $db=null;
        public $tdata=null;
        function __construct(db $db, tdata $tdata)
        {
            $this->db=$db;
            $this->tdata=$tdata;
            $this->init();
        }
        public function init()
        {
            $this->postdata=json_decode(file_get_contents("php://input"),true);
        }
        public function getPostData($key)
        {
            if(isset($this->postdata[$key]))
            {
                return $this->postdata[$key];                               
            }
            else
            {
                return null;
            }
        }
    }
?>