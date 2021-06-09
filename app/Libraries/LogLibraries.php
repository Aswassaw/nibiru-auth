<?php

namespace App\Libraries;

class LogLibraries
{
    public function setActivitylog($data){
        $ActivitylogModel = new \App\Models\ActivitylogModel();
        $ActivitylogModel->insert($data);
    }
}
