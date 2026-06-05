<?php

get('/', function () {
  views("main");
});
get('/logout', function() {
  session_destroy();
  move("/", "로그아웃 성공");
});
get("/login", function() {
  views("/auth/login");
});
post("/signIn", function () {
  extract($_POST);
  $user = db::fetch("select * from users where id = '$id'");
  var_dump($user);
  if ($user) {
    if ($user->pw == $pw) {
      $_SESSION["ss"] = $user;
      move("/", "로그인 성공");
    } else {
      back("로그인 실패");
      }
      } else {
    back("로그인 실패");
  }
});
