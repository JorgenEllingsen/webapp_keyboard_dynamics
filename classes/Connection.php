<?php

namespace classes;

class Connection
{
    private $mysql_dns = "mysql:host=localhost;dbname=biometrics;charset=utf8mb4";
    private $mysql_username = 'root';
    private $mysql_password = 'root';
    private $mysql_driver_opt = null;

    private $con;

    public function __construct()
    {
        $this->con = new \PDO($this->mysql_dns, $this->mysql_username, $this->mysql_password, $this->mysql_driver_opt);
    }

    private function storeEvents($entry_id, $events)
    {
        $start_time = $events[0]->timestamp;
        foreach ($events as $event)
        {
            $stmt = $this->con->prepare('INSERT INTO event (`entry_id`, `timestamp`, `key`, `type`) VALUES (?,?,?,?)');
            $stmt->execute([$entry_id, $event->timestamp - $start_time, $event->key, Connection::eventTypeToBool($event->type)]);
        }
    }

    public function storeEntry($user_id, $events, $keyboard)
    {
        $browser = explode(' ', $_SERVER['HTTP_USER_AGENT']);

        $stmt = $this->con->prepare('INSERT INTO entry (`user_id`, `browser`, `keyboard`) VALUES (?,?,?)');
        $stmt->execute([$user_id, end($browser), $keyboard]);
        $entry_id = $this->con->lastInsertId();

        file_put_contents('data.txt', serialize($stmt->errorInfo()));
        $this->storeEvents($entry_id, $events);
    }

    public static function eventTypeToBool($event_type)
    {
        return $event_type == 'keyup' ? 0 : 1;
    }

    public function getEntries()
    {
        $stmt = $this->con->prepare('SELECT e.id as id, u.name as user, e.browser as browser, k.name as keyboard FROM entry e JOIN keyboard k on e.keyboard = k.id JOIN user u on e.user_id = u.id');
        $stmt->execute();
        $entries = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($entries as $key => $entry)
        {
            $stmt = $this->con->prepare('SELECT * FROM event WHERE entry_id = ?');
            $stmt->execute([$entry['id']]);
            $entries[$key]['events'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $entries;
    }

    public function getUserList()
    {
        $stmt = $this->con->prepare('SELECT * FROM user');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getKeyboardList()
    {
        $stmt = $this->con->prepare('SELECT * FROM keyboard');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}