<?php
function ft_count_item_in_category($category = null, $search = null) //optional parameter
{
    include("connection.php");
    $sql = "SELECT COUNT(media_id) FROM Media";
    try {
        if ($search) {
            $result->prepare($sql . " WHERE title LIKE ?");
            $result->bindValue(1, "%" . $search . "%", PDO::PARAM_STR);
        }
        else if ($category) {
            $category = strtolower($category);
            $result = $db->prepare($sql . " WHERE LOWER(Media.category) = ?");
            $result->bindParam(1, $category, PDO::PARAM_STR);
        } else {
            $result = $db->prepare($sql);
        }
        $result->execute();
    } catch (Exception $e) {
        echo "Bad Query" . $e->getMessage();
    }
    $count = $result->fetchColumn(0);
    return ($count);
}

function ft_get_full_catalog($limit = null, $offset = 0)
{
    include("connection.php");
    try {
        $sql = "SELECT media_id, title, category, img
                FROM media
                ORDER BY title";
        if (is_integer($limit)) {
            $result = $db->prepare($sql . " LIMIT ? OFFSET ?");
            $result->bindParam(1, $limit, PDO::PARAM_INT);
            $result->bindParam(2, $offset, PDO::PARAM_INT);
        } else {
            $result = $db->prepare($sql);
        }
        $result->execute();
    } catch (Exception $e) {
        echo "Bad query" . $e->getMessage();
        exit;
    }
    $catalog = $result->fetchAll(PDO::FETCH_ASSOC);
    return $catalog;
}

function ft_get_items_category($category, $limit = null, $offset = 0)
{
    include("connection.php");
    try {
        $sql =
            "SELECT media_id, title, category, img
            FROM media
            WHERE LOWER(media.category) = ?
            ORDER BY title";
        if (is_integer($limit)) {
            $result = $db->prepare($sql . " LIMIT ? OFFSET ?");
            $result->bindParam(1, $category, PDO::PARAM_STR);
            $result->bindParam(2, $limit, PDO::PARAM_INT);
            $result->bindParam(3, $offset, PDO::PARAM_INT);
        } else {
            $result = $db->prepare($sql);
            $result->bindParam(1, $category, PDO::PARAM_STR);
        }
        $result->execute();
    } catch (Exception $e) {
        echo "Bad query" . $e->getMessage();
        exit;
    }
    $catalog = $result->fetchAll(PDO::FETCH_ASSOC);
    return $catalog;
}

function ft_get_items_search($search, $limit = null, $offset = 0)
{
    include("connection.php");
    try {
        $sql =
            "SELECT media_id, title, category, img
            FROM media
            WHERE title LIKE ?
            ORDER BY title";
        if (is_integer($limit)) {
            $result = $db->prepare($sql . " LIMIT ? OFFSET ?");
            $result->bindValue(1, "%" . $search . "%", PDO::PARAM_STR);
            $result->bindParam(2, $limit, PDO::PARAM_INT);
            $result->bindParam(3, $offset, PDO::PARAM_INT);
        } else {
            $result = $db->prepare($sql);
            $result->bindValue(1, "%" . $search . "%", PDO::PARAM_STR);
        }
        $result->execute();
    } catch (Exception $e) {
        echo "Enable to retrieve results" . $e->getMessage();
        exit;
    }
    $catalog = $result->fetchAll(PDO::FETCH_ASSOC);
    return $catalog;
}

function ft_get_rdm_4items()
{
    include("connection.php");
    try {
        $result = $db->query(
        "SELECT media_id, title, category, img
        FROM media
        ORDER BY RAND()
        LIMIT 4");
    } catch (Exception $e) {
        echo "Bad query" . $e->getMessage();
        exit;
    }
    $random = $result->fetchAll(PDO::FETCH_ASSOC);
    return $random;
}

function ft_get_one_element($id)
{
    include("connection.php");
    try {
        $result = $db->prepare("SELECT title, category, img, format, year, category, genre, publisher, isbn
             FROM Media
             JOIN Genres ON Media.genre_id = Genres.genre_id
             LEFT OUTER JOIN Books ON Media.media_id = Books.media_id
             WHERE Media.media_id = ?");
        $result->bindParam(1, $id, PDO::PARAM_INT);
        $result->execute();
    } catch (Exception $e) {
        echo "Bad query" . $e->getMessage();
        exit;
    }
    $item = $result->fetch(PDO::FETCH_ASSOC);
    if (empty($item))
        return ($item);
    try {
        $result = $db->prepare("SELECT fullname, role
             FROM Media_People
             JOIN People ON Media_People.people_id = People.people_id
             WHERE media_id = ?");
        $result->bindParam(1, $id, PDO::PARAM_INT);
        $result->execute();
    } catch (Exception $e) {
        echo "Bad query" . $e->getMessage();
        exit;
    }
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $item[$row["role"]][] = $row["fullname"];
    }
    return $item;
}

function ft_get_array($category = null) {
    $category = strtolower($category);
    include("connection.php");

    $sql =  "SELECT genre, category
            FROM Genres
            JOIN Genre_Categories
            ON Genres.genre_id = Genre_Categories.genre_id";
    try {
        if (!empty($category)) {
            $sql .= " WHERE LOWER(category) = ?";
            $sql .= "ORDER BY genre";
            $result = db->prepare($sql);
            $result->bindParam(1, $category, PDO::PARAM_STR);
        } else {
            $sql .= "ORDER BY genre";
            $result = db->prepare($sql);
        }
    } catch (Exception $e) {
        echo "bad query" . $e->getMessage();
    }
    $result->execute();
    $genreArray = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $genreArray[$row["category"]][] = $row["genre"];
    }
    return ($genreArray);
}

function ft_get_html_by_id($item)
{
    $returns =  "<li>
                    <a href='detail.php?id=" . $item["media_id"] . "'>
                        <img src='" . $item["img"] . "' alt='" . $item["title"] . "'>
                        <p>View Details</p>
                    </a>
                </li>";
    return $returns;
}

function ft_catalog_by_type($catalog, $currentPage)
{
    $title = [];
    foreach ($catalog as $id => $item)
    {
        if (strtolower($item["category"]) == strtolower($currentPage) || $currentPage == null)
        {
            $tmp = ltrim($item["title"], "The ");
            $tmp = ltrim($item["title"], "A ");
            $tmp = ltrim($item["title"], "An ");
            $title[$id] = $tmp;
        }
    }
    asort($title);
    return array_keys($title);
}
