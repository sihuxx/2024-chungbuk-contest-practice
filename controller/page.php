<?php

get('/', function () {
  views("main");
});
get('/logout', function () {
  session_destroy();
  move("/", "로그아웃 성공");
});
get("/login", function () {
  views("auth/login");
});
get("/edit/{idx}", function ($idx) {
  views("edit", ["idx" => $idx]);
});
get("/reserve", function () {
  views("reserve");
});
get("/requestTaxi", function () {
  views("reverse");
});
get("/mypage", function () {
  if (ss()->type == 'admin') views("mypage/admin");
  else if (ss()->type == 'driver') views("mypage/driver");
  else  views("mypage/basic");
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
post('/carAddRequest', function () {
  extract($_POST);
  $user = ss();
  $days_arr = $days ?? [];
  $days_str = implode(",", $days_arr);
  db::exec("insert into cars (type, price, days, location, driver_idx) values ('$type', '$price', '$days_str', '$location', '$user->idx ')");
  move("/carRequest", "차량 등록 요청 성공");
  /* 
  implode(구분자, 배열): 배열을 문자열로 합침
  explode(구분자, 문자열): 문자열을 배열로 쪼갬
  */
});
post("/carEditRequest", function () {
  extract($_POST);
  $days_arr = $days ?? [];
  $days_str = implode(",", $days_arr);
  db::exec("update cars set type = '$type', price = '$price', days = '$days_str', location = '$location', status = 'pending' where idx = '$idx'");
  move('/mypage', "차량 재등록 요청 성공");
});
post("/carAccept", function () {
  extract($_POST);
  db::exec("update cars set status = 'accepted' where idx = '$idx'");
  move('/respond', '차량 승인 수락');
});
post("/carReject", function () {
  extract($_POST);
  db::exec("update cars set status = 'rejected', reject_reason = '$reason' where idx = '$idx'");
  move('/respond', '차량 승인 거절');
});
post("/rideRequest", function() {
  extract($_POST);
  $user = ss();
  db::exec("insert into reserves(user_idx, car_idx, driver_idx, start_location) values('$user->idx', '$car_idx', '$driver_idx', '$start_location')");
  move('/reserve', "택시 예약 성공");
});