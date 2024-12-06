<?php

namespace command;
use areas\admin\model\{ArticleModel, LinkModel, MusicModel, MessageModel, ConfigModel};

class Test
{
    public function __construct()
    {
        $data = ConfigModel::select();
        var_dump($data);
    }
}
