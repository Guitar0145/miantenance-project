<?php
// Include database file
include 'functions.php';

$mtObj = new Maintenance();

// Insert Record in customer table
if(isset($_POST['submit'])) {

    $m_user = $_POST['m_user'];
    $m_depart_id = $_POST['m_depart_id'];
    $m_c_id = $_POST['m_c_id'];
    $m_st_id = $_POST['m_st_id'];
    $m_urgency = $_POST['m_urgency'];
    $m_issue = $_POST['m_issue'];
    $check_status = $_POST['check_status'];
    $file = $_FILES['m_img'];
    $insertData = $mtObj->insertData($m_user, $m_depart_id, $m_c_id, $m_st_id, $m_urgency, $m_issue, $check_status, $file);

    if ($insertData){
        header("Location:test-2.php");
    }else{
        return false;
    }

}
?>

<html lang="en">
  <head>
    <title>Upload File in database using OOPs concept with PHP Mysqltitle></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <head>
  <body>
    <div class="card text-center" style="padding:15px;">
      <h4>Upload File in database using OOPs concept with PHP Mysqlh</h4>
      <div><br>
    <div class="container">
      <form method="POST" action="index.php" enctype="multipart/form-data">
        <div class="form-group">
          <label for="m_user">m_user:</label>
          <input type="text" class="form-control" name="m_user" placeholder="Enter m_user" value="test" required="">
          <div>
        <div class="form-group">
          <label for="email">m_depart_id:</label>
          <input type="text" class="form-control" name="m_depart_id" placeholder="Enter m_depart_id" value="1" required="">
          <div>
        <div class="form-group">
          <label for="m_c_id">m_c_id:</label>
          <input type="text" class="form-control" name="m_c_id" placeholder="Enter m_c_id" value="2" required="">
          <div>
          <div class="form-group">
          <label for="m_st_id">m_st_id:</label>
          <input type="text" class="form-control" name="m_st_id" placeholder="Enter m_st_id" value="3" required="">
          <div>
          <div class="form-group">
          <label for="m_urgency">m_urgency:</label>
          <input type="text" class="form-control" name="m_urgency" placeholder="Enter m_urgency" value="ด่วน" required="">
          <div>
          <div class="form-group">
          <label for="m_issue">m_issue:</label>
          <input type="text" class="form-control" name="m_issue" placeholder="Enter m_issue" value="test อาการ" required="">
          <div>
          <div class="form-group">
          <label for="check_status">check_status:</label>
          <input type="text" class="form-control" name="check_status" placeholder="Enter check_status" value="รอตรวจสอบ" required="">
          <div>
        <div class="form-group">
          <label for="profile_image">Profile Image:</label>
          <input type="file" class="form-control" name="m_img" required="">
          <div>
        <input type="submit" name="submit" class="btn btn-primary" style="float:right;" value="Submit">
        <form>
        <div>
        <body>
        <html>