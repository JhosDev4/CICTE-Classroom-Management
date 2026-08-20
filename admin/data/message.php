<?php
// Use include guards to prevent multiple function declarations if necessary

if (!function_exists('getAllMessages')) {
    function getAllMessages($conn) {
        $sql = "SELECT * FROM message ORDER BY is_read ASC, date_time DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() >= 1) {
            return $stmt->fetchAll();
        } else {
            return 0;
        }
    }
}

if (!function_exists('countUnreadMessages')) {
    function countUnreadMessages($conn) {
        $sql = "SELECT COUNT(*) AS unread_count FROM message WHERE is_read = 0";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? $result['unread_count'] : 0;
    }
}

if (!function_exists('getUnreadMessageCount')) {
    function getUnreadMessageCount($conn) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM message WHERE is_read = 0");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}

