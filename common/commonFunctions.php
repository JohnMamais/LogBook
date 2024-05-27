<?php

function getClientIp(): string {
    $ipAddress = '';

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
    }

    if (strpos($ipAddress, ',') !== false) {
        $ipAddress = explode(',', $ipAddress)[0];
    }

    return $ipAddress;
}

function getCurrentPagePath(): string {
    return dirname(__FILE__) . '/' . basename(__FILE__);
}

function getCurrentUserId(): ?string {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== 'guest') {
        $uid = $_SESSION['user_id'];
    } else {
        $uid = null;
    }

    return $uid;
}

function insertLog(mysqli $connection, string $logDescription): bool {
    $pagePath = getCurrentPagePath();
    $clientIp = getClientIp();
    $userId = getCurrentUserId();

    $sql = "INSERT INTO serverlog (logDesc, pageDir, uid, ip) VALUES (?, ?, ?, ?)";

    try {
        $stmt = $connection->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Statement preparation failed: " . $connection->error);
        }

        $stmt->bind_param("ssis", $logDescription, $pagePath, $userId, $clientIp);

        if (!$stmt->execute()) {
            throw new Exception("Statement execution failed: " . $stmt->error);
        }

        $stmt->close();
        return true;
    } catch (Exception $e) {
        error_log($e->getMessage());
        if (isset($stmt) && $stmt !== false) {
            $stmt->close();
        }
        return false;
    }
}

//function to port the js alert function to php
function alert($msg){
  echo "<script>alert(' ".$msg." ');</script>";
}
?>
