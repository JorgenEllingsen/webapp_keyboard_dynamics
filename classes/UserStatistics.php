<?php

namespace classes;


class UserStatistics
{
    public $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
        $this->con = new Connection();
    }

    public function getUserEntries()
    {
        return $this->addTypedString($this->con->getUserEntries($this->user_id));
    }

    public function addTypedString($entries)
    {
        foreach ($entries as $key => $entry)
        {
            $str = '';
            $datapoints = [];
            foreach ($entry['events'] as $ev)
            {
                if($ev['type'] == 1) // Keydown
                {
                    $str = $str.$ev['key'];
                    $datapoints[]= ['key' => $ev['key'], 'down' => $ev['timestamp']];
                }
                else // keyup
                {
                    $arr_len = count($datapoints);
                    $i = 1;
                    while($datapoints[$arr_len-$i]['key'] != $ev['key']) $i++;
                    $datapoints[$arr_len-$i]['up'] = $ev['timestamp'];
                }
            }
            $entries[$key]['string'] = $str;
            $entries[$key]['datapoints'] = $datapoints;
        }
        return $entries;
    }
}