<?php

namespace Blog;

use PDO;

class PostMapper{

    private PDO $connection;

    /**
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $urlKey
     * @return array|null
     */
    public function getByUrlKey(string $urlKey) : ?array
    {
        $statement = $this->connection->prepare("SELECT * FROM post WHERE url_key = :url_key");
        $statement->execute([
            'url_key' => $urlKey
        ]);
        $result = $statement->fetchAll();

        return array_shift($result);
    }

    public function getList($direction) : ?array
    {
        if(!in_array($direction, ['DESC', 'ASC'])){
            throw new Exception('The direction is not supported');
        }
        $statement = $this->connection->prepare("SELECT * FROM post ORDER BY published_date DESC");
        $statement->execute();
        return $statement->fetchAll();
    }
}