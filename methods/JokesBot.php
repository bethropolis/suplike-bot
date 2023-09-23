<?php

class JokesBot
{
    private $jokes = array(
        "Why did the scarecrow win an award? Because he was outstanding in his field!",
        "What do you get when you cross a snowman and a vampire? Frostbite!",
        "How do you organize a space party? You 'planet'!",
    );

    public function getRandomJoke()
    {
        $randomIndex = rand(0, count($this->jokes) - 1);
        return $this->jokes[$randomIndex];
    }

    public function writeJokeToDatabase($joke)
    {
        $sql = "INSERT INTO jokes (joke) VALUES (?)";
        $params = array($joke);

        // Safely execute the SQL query
        return executeQuery($sql, $params);
    }

    public function getJokeFromDatabase()
    {
        $sql = "SELECT joke FROM jokes ORDER BY RAND() LIMIT 1";

        // Safely execute the SQL query
        $result = executeQuery($sql);

        if ($result) {
            $row = $result;
            return $row['joke'];
        } else {
            return "Failed to retrieve a joke from the database.";
        }
    }
}
