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
    <a href="/"><img src="/asset/logo.png"></a>
    <div class="btns">
      <a href="/reserve">택시 예약</a>
    </div>
    <div class="btns">
      <?php if ($user) { ?>
        <a href="/logout">로그아웃</a>
        <a href="/mypage">마이페이지(<?= $user->id ?>)</a>
      <?php } else { ?>
        <a href="/">회원가입</a>
        <a href="/login">로그인</a>
      <?php } ?>
    </div>
  </header>

  <div class="popup"></div>

  <script src="/js/lib.js"></script>
  <script>
    let popupShown = false;
    setInterval(async () => {
      const res = await fetch("/poll").then(res => res.json());

      if (res.newRequest && !popupShown) {
        popupShown = true;
        showPopup(res.newRequest);
        startRejectCount(res.newRequest.idx);
      }
      
    }, 10)

    const showPopup = (req) => {
      $(".popup").style.display = 'flex';
      $(".popup").innerHTML = `
            <p>${req.user_id} 님의 요청</p>
        <button onclick="acceptRide(${req.idx})">승인</button>
        <button onclick="rejectRide(${req.idx})">거절</button>
    `;
    };

    const startRejectCount = idx => {
      let time = 10;
      const timer = setInterval(() => {
        time--;
        if (time <= 0) {
          clearInterval(timer);
          rejectRide(idx);
        }
      }, 1000)
    }

    const acceptRide = async (idx) => {
      await fetch('/rideAccept', {
        method: 'POST',
        body: new URLSearchParams({idx})
      });
      $('.popup').style.display = 'none';
      popupShown = false;
    }
    const rejectRide = async (idx) => {
      await fetch('/rideReject', {
        method: 'POST',
        body: new URLSearchParams({idx})
      });
      $('.popup').style.display = 'none';
      popupShown = false;
    };
  </script>