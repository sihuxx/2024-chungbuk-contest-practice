<?php
$user = ss();
$start_location = $_GET["start"] ?? null;
$end_location = $_GET["end"] ?? null;
if ($user->type != 'basic') back("일반 회원만 접근 할 수 있습니다");

$locations = db::fetchAll('select * from locations');
$drivers = db::fetchAll("select c.location, c.idx car_idx, u.* from cars c inner join users u on c.driver_idx = u.idx where u.type = 'driver' and location = '$start_location'");
?>

<main>
  <h1 class="title">택시 예약</h1>
  <form action="/reserve" method="GET">
    <label>출발지:
      <select name="start">
        <?php foreach($locations as $loc) { ?>
        <option value="<?= $loc->name ?>"><?= $loc->name ?></option>
        <?php } ?>
      </select>
    </label>
    <label>도착지:
      <select name="end">
        <?php foreach($locations as $loc) { ?>
        <option value="<?= $loc->name ?>"><?= $loc->name ?></option>
        <?php } ?>
      </select>
    </label>
    <button>기사 찾기</button>
  </form>
  <h1 class="title">기사 목록</h1>
  <table>
    <thead>
      <th>기사 이름</th>
      <th>츨발지</th>
      <th>도착지</th>
      <th>예약</th>
    </thead>
    <tbody>
      <?php foreach($drivers as $driver) { 
      ?>
      <tr>
        <td><?= $driver->id ?></td>
        <td><?= $start_location ?></td>
        <td><?= $end_location ?></td>
        <td>
          <form action="/rideRequest" method="post">
            <input type="hidden" name="driver_idx" value="<?= $driver->idx ?>">
            <input type="hidden" name="car_idx" value="<?= $driver->car_idx ?>">
            <input type="hidden" name="start_location" value="<?= $start_location ?>">
            <input type="hidden" name="end_location" value="<?= $end_location ?>">
            <button>요청하기</button>
          </form>
        </td>
      </tr>
    <?php } ?>
  </tbody>
 </table>
</main>

<!-- <script src="/js/script.js"></script> -->