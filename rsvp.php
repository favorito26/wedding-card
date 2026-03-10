<?php
include 'db.php';

$id     = intval($_POST['id']);
$status = $_POST['status'];

$stmt = $db->prepare("UPDATE guests SET rsvp = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);
$stmt->execute();

header("Location: index.php?id=" . $id);
exit;
