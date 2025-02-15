<?php
function retrieveReviews()
{
    $db = getDBConnection();

    $query = "SELECT reviews.user_id, users.firstname, users.photo, reviews.review, reviews.rating FROM reviews
              JOIN users ON reviews.user_id = users.id";

    if ($stmt = $db->prepare($query)) {
        $stmt->execute();

        $result = $stmt->get_result();

        $reviews = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $review = [
                    'reviewer_id' => htmlspecialchars($row["user_id"]),
                    'reviewer_name' => htmlspecialchars($row["firstname"]),
                    'photo' => $row["photo"],
                    'review_text' => htmlspecialchars($row["review"]),
                    'rating' => $row["rating"],
                ];
                $reviews[] = $review;
            }
        } else {
            echo "0 results";
        }

        $stmt->close();
    } else {
        echo "Error in prepared statement";
    }

    $db->close();

    return $reviews;
}

function retrieveReviewsByUserId($user_id)
{
    $db = getDBConnection();

    $query = "SELECT reviews.user_id, users.firstname, users.photo, reviews.review, reviews.rating FROM reviews
              JOIN users ON reviews.user_id = users.id
              WHERE reviews.user_id = ?";

    if ($stmt = $db->prepare($query)) {
        $stmt->bind_param('i', $user_id);

        $stmt->execute();

        $result = $stmt->get_result();

        $reviews = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $review = [
                    'reviewer_id' => htmlspecialchars($row["user_id"]),
                    'reviewer_name' => htmlspecialchars($row["firstname"]),
                    'photo' => $row["photo"],
                    'review_text' => htmlspecialchars($row["review"]),
                    'rating' => $row["rating"],
                ];
                $reviews[] = $review;
            }
        } else {
            echo "No results found for user with ID: " . $user_id;
        }

        $stmt->close();
    } else {
        echo "Error in prepared statement";
    }

    $db->close();

    return $reviews;
}