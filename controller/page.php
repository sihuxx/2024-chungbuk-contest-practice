<?php

get('/', function () {
  views("main");
});
get('/logout', function () {
  session_destroy();
  $user = ss();
  db::exec("update users set is_login = 0 where idx = '$user->idx'");
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
      db::exec("update users set is_login = 1 where idx = '$user->idx'");
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
post("/rideRequest", function () {
  extract($_POST);
  $user = ss();
  db::exec("insert into reserves(user_idx, car_idx, driver_idx, start_location, end_location) values('$user->idx', '$car_idx', '$driver_idx', '$start_location', '$end_location')");
  move('/reserve', "택시 예약 성공");
});
get("/poll", function () {
  $user = ss();
  $newRequest = db::fetch("select u.id as user_id, r.* from users u inner join reserves r on u.idx = r.user_idx where driver_idx = '$user->idx' and status = 'pending' order by idx desc limit 1");
  echo json_encode(['newRequest' => $newRequest]);
});
post("/rideAccept", function() {
  extract($_POST);
  db::exec("update reserves set status = 'riding' where idx = '$idx'");
  move('/mypage', "요청 승인");
});
post("/rideReject", function() {
  extract($_POST);
  db::exec("update reserves set status = 'rejected' where idx = '$idx'");
  move('/mypage', "요청 거절");
});
post("/rideDone", function() {
  extract($_POST);
  db::exec("update reserves set status = 'done' where idx = '$idx'");
  move("/mypage", "운행 종료");
});