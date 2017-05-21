<?php
    class homeController extends baseController
    {
        public function index()
        {
            $result=$this->db->sqlselect("select * from user");
            $this->tdata->setTData('data',$result);
            $this->tdata->showInJson();
        }
    }
?>