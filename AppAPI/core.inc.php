<?php
date_default_timezone_set('Asia/Kolkata');
$created_on = date('Y-m-d');
$updated_on = date('Y-m-d');

// home feeds / daily posts

function unlikeIfAlreayLiked($job_feed_id, $login_id, $connect)
{
    $query = "UPDATE job_feeds_like SET status = 'Inactive' WHERE job_feed_id = '$job_feed_id' AND login_id = '$login_id'
    AND status = 'Active'";

    $statement = $connect->prepare($query);
    $result = $statement->execute();
    $data = $statement->fetchAll();
    return $statement->rowCount();
}

function getLikeStatus($connect, $job_feed_id, $login_id)
{
    $query = "SELECT * FROM `job_feeds_like` WHERE `job_feed_id` = '$job_feed_id' AND `login_id` = '$login_id' AND `status` = 'Active'";

    $statement = $connect->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $count = count($result);
    if ($count == '1') {
        return 'true';
    } else {
        return 'false';
    }
}

function getLikeCount($connect, $job_feed_id)
{
    $query = "SELECT COUNT(`job_feeds_like_id`) AS 'total_likes' FROM job_feeds_like WHERE `job_feed_id` = '$job_feed_id'
    AND status = 'Active'";

    $statement = $connect->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['total_likes'];
}

function getCommentsCount($connect, $job_feed_id)
{
    $query = "SELECT COUNT(`job_feeds_comment_id`) AS 'total_comment' FROM job_feeds_comment WHERE `job_feed_id` = '$job_feed_id'
    AND status = 'Active'";

    $statement = $connect->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['total_comment'];
}

// current affairs

function unlikeCurrentAffairsIfAlreayLiked($current_affair_id, $login_id, $connect)
{
    $query = "UPDATE current_affairs_likes SET status = 'Inactive' WHERE current_affair_id = '$current_affair_id' AND login_id = '$login_id'
    AND status = 'Active'";

    $statement = $connect->prepare($query);
    $result = $statement->execute();
    $data = $statement->fetchAll();
    return $statement->rowCount();
}

function getCurrentAffairsLikeStatus($connect, $current_affair_id, $login_id)
{
    $query = "SELECT * FROM `current_affairs_likes` WHERE `current_affair_id` = '$current_affair_id' AND `login_id` = '$login_id' AND `status` = 'Active'";

    $statement = $connect->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $count = count($result);
    if ($count == '1') {
        return 'true';
    } else {
        return 'false';
    }
}

function getCurrentAffairsLikeCount($connect, $current_affair_id)
{
    $query = "SELECT COUNT(`current_affairs_likes_id`) AS 'total_likes' FROM current_affairs_likes WHERE `current_affair_id` = '$current_affair_id'
    AND status = 'Active'";

    $statement = $connect->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['total_likes'];
}

function getCurrentAffairsCommentsCount($connect, $current_affair_id)
{
    $query = "SELECT COUNT(`current_affairs_comments_id`) AS 'total_comment' FROM current_affairs_comments WHERE `current_affair_id` = '$current_affair_id'
    AND status = 'Active'";

    $statement = $connect->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['total_comment'];
}

function unSaveIfAlreaySaved($current_affair_id, $login_id, $connect)
{

    $query = "UPDATE current_affairs_saved SET status = 'Inactive' WHERE current_affair_id = '$current_affair_id' AND login_id = '$login_id' AND status = 'Active'";

    $statement = $connect->prepare($query);
    $result = $statement->execute();
    $data = $statement->fetchAll();
    return $statement->rowCount();
}

function getCurrentAffairsSaveStatus($connect, $current_affair_id, $login_id)
{
    $query = "SELECT * FROM `current_affairs_saved` WHERE `current_affair_id` = '$current_affair_id' AND `login_id` = '$login_id' AND `status` = 'Active'";

    $statement = $connect->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $count = count($result);
    if ($count == '1') {
        return 'true';
    } else {
        return 'false';
    }
}

// Yashogatha

function unlikeYashoGathaIfAlreayLiked($yashogatha_id, $login_id, $connect)
{
    $query = "UPDATE yashogatha_likes SET status = 'Inactive' WHERE yashogatha_id = '$yashogatha_id' AND login_id = '$login_id'
    AND status = 'Active'";

    $statement = $connect->prepare($query);
    $result = $statement->execute();
    $data = $statement->fetchAll();
    return $statement->rowCount();
}

function getYashoGathaLikeStatus($connect, $yashogatha_id, $login_id)
{
    $query = "SELECT * FROM `yashogatha_likes` WHERE `yashogatha_id` = '$yashogatha_id' AND `login_id` = '$login_id' AND `status` = 'Active'";

    $statement = $connect->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $count = count($result);
    if ($count == '1') {
        return 'true';
    } else {
        return 'false';
    }
}

function getYashoGathaLikeCount($connect, $yashogatha_id)
{
    $query = "SELECT COUNT(`yashogatha_likes_id`) AS 'total_likes' FROM yashogatha_likes WHERE `yashogatha_id` = '$yashogatha_id'
    AND status = 'Active'";

    $statement = $connect->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['total_likes'];
}

function getYashoGathaCommentsCount($connect, $yashogatha_id)
{
    $query = "SELECT COUNT(`yashogatha_comments_id`) AS 'total_comment' FROM yashogatha_comments WHERE `yashogatha_id` = '$yashogatha_id'
    AND status = 'Active'";

    $statement = $connect->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['total_comment'];
}

function unSaveYashoGathaIfAlreaySaved($yashogatha_id, $login_id, $connect)
{

    $query = "UPDATE yashogatha_saved SET status = 'Inactive' WHERE yashogatha_id = '$yashogatha_id' AND login_id = '$login_id' AND status = 'Active'";

    $statement = $connect->prepare($query);
    $result = $statement->execute();
    $data = $statement->fetchAll();
    return $statement->rowCount();
}

function getYashoGathaSaveStatus($connect, $yashogatha_id, $login_id)
{
    $query = "SELECT * FROM `yashogatha_saved` WHERE `yashogatha_id` = '$yashogatha_id' AND `login_id` = '$login_id' AND `status` = 'Active'";

    $statement = $connect->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $count = count($result);
    if ($count == '1') {
        return 'true';
    } else {
        return 'false';
    }
}

function getDailyQuizAttemptedOrNotStatus($connect, $quiz_id, $login_id)
{
    $query = "SELECT * FROM `daily_quiz_attempted` WHERE `quiz_id` = '$quiz_id' AND `login_id` = '$login_id' AND `status` = 'Active'";

    $statement = $connect->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $count = count($result);
    if ($count == '1') {
        return 'true';
    } else {
        return 'false';
    }
}

function getTestSeriesAttemptedOrNotStatus($connect, $test_series_exam_list_id, $login_id)
{
    $query = "SELECT * FROM `test_series_attempted` WHERE `test_series_exam_list_id` = '$test_series_exam_list_id' AND `login_id` = '$login_id' AND `status` = 'Active'";

    $statement = $connect->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $count = count($result);
    if ($count == '1') {
        return 'true';
    } else {
        return 'false';
    }
}

function getCurrentAffairsNextId($connect, $current_affair_id, $selected_exam_id)
{
    $query = "SELECT current_affair_id AS next_current_affair_id FROM current_affairs WHERE `current_affair_id` > '$current_affair_id'
    AND status = 'Active' AND JSON_CONTAINS(selected_exams_id, '[\"".$selected_exam_id."\"]') ORDER BY  STR_TO_DATE(created_on, '%Y-%m-%d') ASC, current_affair_id ASC LIMIT 1";
    
    $statement = $connect->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['next_current_affair_id'];
}

function getCurrentAffairsPreviousId($connect, $current_affair_id, $selected_exam_id)
{
    $query = "SELECT current_affair_id AS next_current_affair_id FROM current_affairs WHERE `current_affair_id` < '$current_affair_id'
    AND status = 'Active' AND JSON_CONTAINS(selected_exams_id, '[\"".$selected_exam_id."\"]') ORDER BY  STR_TO_DATE(created_on, '%Y-%m-%d') DESC, current_affair_id DESC LIMIT 1";
    
    $statement = $connect->query($query);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['next_current_affair_id'];
}
