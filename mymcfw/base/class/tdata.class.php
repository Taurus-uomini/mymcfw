<?php
    class tdata
    {
        private $data=array();
        public function setTData($key,$value)
        {
           $this->data[$key]=$value;
        }
        public function getTData($key)
        {
            if(isset($this->data[$key]))
            {
                return $this->data[$key];                               
            }
            else
            {
                return null;
            }
        }
        public function showInJson()
        {
            echo json_encode($this->data);
        }
    }
?>