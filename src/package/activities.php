<?php
require __DIR__ . '/../bootstrap.php';

function retrieveActivities(): array
{
    $db = getDBConnection();

    $filter_season = $_GET['season'] ?? '';
    $sort_order = $_GET['sort'] ?? 'ASC';

    $query = "SELECT * FROM activities";

    // Apply filters if selected
    if (!empty($filter_season)) {
        $query .= " WHERE season = ?";
    }

    $query .= " ORDER BY price " . $sort_order;

    if ($stmt = $db->prepare($query)) {
        if (!empty($filter_menu_type)) {
            $stmt->bind_param("s", $filter_season);
        }

        $stmt->execute();

        $result = $stmt->get_result();

        $activities = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $activity = [
                    'id' => htmlspecialchars($row["id"]),
                    'name' => htmlspecialchars($row["name"]),
                    'description' => htmlspecialchars($row["description"]),
                    'info' => htmlspecialchars($row["info"]),
                    'price' => htmlspecialchars($row["price"]),
                    'season' => htmlspecialchars($row["season"]),
                    'country' => htmlspecialchars($row["country"]),
                    'photo' => htmlspecialchars($row["photo"]),
                    'max_group_number' => htmlspecialchars($row["max_group_number"])
                    // Add other fields as needed
                ];

                $activities[] = $activity;
            }
        } else {
            echo "0 results";
        }

        $stmt->close();
    } else {
        echo "Error in prepared statement";
    }

    $db->close();

    if (isset($_GET['name'])) {
        $nameFilter = $_GET['name'];
        $activities = array_filter($activities, function ($activity) use ($nameFilter) {
            return stripos($activity['name'], $nameFilter) !== false;
        });
    }

    return $activities;
}

function retrieveActivityById($activityId)
{
    $db = getDBConnection();

    $activityId = intval($activityId);

    $query = "SELECT * FROM activities WHERE id = ?";
    $stmt = $db->prepare($query);

    if (!$stmt) {
        return null;
    }

    $stmt->bind_param("i", $activityId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $activity = [
            'id' => htmlspecialchars($row["id"]),
            'name' => htmlspecialchars($row["name"]),
            'description' => htmlspecialchars($row["description"]),
            'info' => htmlspecialchars($row["info"]),
            'price' => htmlspecialchars($row["price"])
        ];

        $stmt->close();
        $db->close();

        return $activity;
    } else {
        $stmt->close();
        $db->close();
        return null;
    }
}

function retrieveActivitiesWithLimit($limit, $offset, $category): array
{
    $db = getDBConnection();

    $query = "SELECT * FROM activities";

    if (!empty($category)) {
        $query .= " WHERE category = ?";
    }

    $query .= " LIMIT ? OFFSET ?";

    $activities = [];

    try {
        $stmt = $db->prepare($query);

        if (!empty($category)) {
            $stmt->bind_param('sii', $category, $limit, $offset);
        } else {
            $stmt->bind_param('ii', $limit, $offset);
        }

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $activity = [
                    'id' => htmlspecialchars($row["id"]),
                    'name' => htmlspecialchars($row["name"]),
                    'description' => htmlspecialchars($row["description"]),
                    'info' => htmlspecialchars($row["info"]),
                    'price' => htmlspecialchars($row["price"]),
                    'season' => htmlspecialchars($row["season"]),
                    'country' => htmlspecialchars($row["country"]),
                    'max_group_number' => htmlspecialchars($row["max_group_number"]),
                    'category' => htmlspecialchars($row["category"]),
                    'photo' => base64_encode($row["photo"])
                ];

                $activities[] = $activity;
            }
        }

        $stmt->close();
    } catch (Exception $e) {
        throw new Exception("Error retrieving activities: " . $e->getMessage());
    } finally {
        $db->close();
    }

    return $activities;
}

function countActivities($category = ''): int
{
    $db = getDBConnection();

    $query = "SELECT COUNT(*) as count FROM activities";

    $whereClause = '';

    if (!empty($category)) {
        $whereClause .= (!empty($whereClause) ? " AND" : "") . " category = ?";
    }

    if (!empty($whereClause)) {
        $query .= " WHERE" . $whereClause;
    }

    $count = 0;

    try {
        $stmt = $db->prepare($query);

        $paramCount = 0;

        if (!empty($category)) {
            $stmt->bind_param("s", $category);
            $paramCount++;
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $count = $row['count'];
        }

        $stmt->close();
    } catch (Exception $e) {
        throw new Exception("Error counting activities: " . $e->getMessage());
    } finally {
        $db->close();
    }

    return $count;
}

function insertActivity($name, $description, $price, $season, $country, $max_group_number, $photo, $category, $info): string
{
    $db = getDBConnection();

    $stmt = $db->prepare("INSERT INTO activities (name, description, price, season, country, max_group_number, photo, category, info) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        return "Error in prepared statement: " . $db->error;
    }

    $stmt->bind_param("ssissibss", $name, $description, $price, $season, $country, $max_group_number, $photo, $category, $info);
    $stmt->execute();

    $affected_rows = $stmt->affected_rows;
    if ($stmt->affected_rows > 0) {
        $stmt->close();
        $db->close();
        return $affected_rows . " package inserted into the database.";
    } else {
        $stmt->close();
        $db->close();
        return "An error has occurred. The package was not added.";
    }
}

