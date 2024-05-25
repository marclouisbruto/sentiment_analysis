<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process</title>
</head>
<body>
<?php 
require_once 'control.php';
require_once 'config/connect.php';

use database\Database;

function computeSentiment($compoundScore) {
    $percentage = abs($compoundScore) * 100; // Calculate percentage from 0 to 100

    if ($compoundScore == 0) {
        return ['sentiment' => 'Neutral', 'percentage' => 100]; // Neutral
    } elseif ($compoundScore < 0) {
        return ['sentiment' => 'Negative', 'percentage' => round($percentage, 2)]; // Negative
    } else {
        return ['sentiment' => 'Positive', 'percentage' => round($percentage, 2)]; // Positive
    }
}

function View(){
    if (isset($_POST['comment']) && isset($_POST['user_id'])) {
        // Retrieve form data
        $comment = $_POST['comment']; 
        $user_id = $_POST['user_id']; // Assuming you are passing the user_id with the form
        
        // Establish database connection
        $db = new Database();
        $conn = $db->getConnection();
        
        $sentimentAnalyzer = new SentimentAnalyzerWrapper();
        $translatedText = $sentimentAnalyzer->convert($comment);
        
        // Analyze sentiment
        $sentiment = $sentimentAnalyzer->analyzeText($translatedText);
        
        $result = computeSentiment($sentiment["compound"]);
        
        // Insert data into the database
        $stmt = $conn->prepare("INSERT INTO tbl_comments (user_id, comment, translated_comment, sentiment, percentage) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssd", $user_id, $comment, $translatedText, $result['sentiment'], $result['percentage']);
        
        if ($stmt->execute()) {
            echo "<div><h2 class='text-success'>Comment successfully saved!</h2></div>";
        } else {
            echo "<div><h2 class='text-danger'>Error saving comment: " . $stmt->error . "</h2></div>";
        }
        
        $stmt->close();
        $conn->close();
        
        ?>
        <div>
            <h2 class="text-danger"><?php echo "Comment: $comment"; ?></h2>
        </div>
        <div>
            <h2 class="text-success"><?php echo "Translated Comment: $translatedText"; ?></h2>
        </div>
        <div>
            <h2 class="text-info"><?php echo "Sentiment: {$result['sentiment']}, Percentage: {$result['percentage']}%"; ?></h2>
        </div>
        <?php
    }
}
?>

</body>
</html>
