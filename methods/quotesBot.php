<?php

class QuotesBot
{
    private $apiUrl = 'https://api.quotable.io/random';

    public function getRandomQuote()
    {
        // Check if it's been more than 24 hours since the last post
        $lastPostTimestamp = $this->getLastPostTimestamp();
        $currentTimestamp = time();
        $timeDifference = $currentTimestamp - $lastPostTimestamp;

        if ($timeDifference >= 86400) { 
            // Make a GET request to the API
            $response = makeHttpRequest($this->apiUrl, 'GET', NULL, true);

            // Parse the JSON response
            $quoteData = json_decode($response, true);

            if ($quoteData && isset($quoteData['content']) && isset($quoteData['author'])) {
                $quote = $quoteData['content'];
                $author = $quoteData['author'];

                // Format the quote as <QUOTE> - <AUTHOR>
                $formattedQuote = "$quote - $author";

                // Write the quote to the database
                $this->writeQuoteToDatabase($formattedQuote);

                return $formattedQuote;
            } else {
                return "Failed to fetch a quote from the API.";
            }
        } else {
            return "It's not yet time to post a new quote.";
        }
    }


    private function getLastPostTimestamp()
    {
        $sql = "SELECT MAX(`timestamp`) AS last_post FROM jokes";
        $result = executeQuery($sql);

        if ($result && $row = $result[0]) {
            return strtotime($row['last_post']);
        } else {
            // Return a timestamp in the distant past if there are no previous posts
            return 0;
        }
    }

    private function writeQuoteToDatabase($quote)
    {
        $sql = "INSERT INTO jokes (joke, `type`) VALUES (?,?)";
        $params = array($quote, "quote");

        // Safely execute the SQL query
        return executeQuery($sql, $params);
    }

    public function getQuoteFromDatabase()
    {
        $sql = "SELECT joke FROM jokes ORDER BY RAND() LIMIT 1";

        // Safely execute the SQL query
        $result = executeQuery($sql);

        if ($result) {
            $row = $result[0];
            return $row['joke'];
        } else {
            return "Failed to retrieve a quote from the database.";
        }
    }
}
