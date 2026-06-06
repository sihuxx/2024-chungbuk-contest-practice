<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>세계문화도시경주</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>

<?php
$user = ss();
?>
  
<header>
  <img src="/asset/logo.png">
  <div class="btns">
    <a href="/respond">차량 등록 승인</a>
    <a href="/request">차량 등록 요청</a>
  </div>
  <div class="btns">
    <?php if($user) { ?>
      <a href="/logout">로그아웃</a>
      <a href="/mypage">마이페이지(<?= $user->id ?>)</a>
    <?php } else { ?>
    <a href="/">회원가입</a>
    <a href="/login">로그인</a>
    <?php } ?>
  </div>
</header>

