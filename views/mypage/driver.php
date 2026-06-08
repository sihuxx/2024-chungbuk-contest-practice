<?php
$user = ss();
if ($user->type !== 'driver') back("기사 회원만 접근 할 수 있는 페이지입니다");
$rejectCars = db::fetchAll("select * from cars where driver_idx = '$user->idx' and status = 'rejected'");
?>

<main>
    <h1 class="title">차랑 등록 요청</h1>
    <form action="/carAddRequest" method="post">
        <label>차종<input type="text" placeholder="차종" name="type"></label>
        <label>100m 당 요금<input type="number" placeholder="100m 당 요금" name="price" min="100" max="500" step="100"></label>
        <div class="box">
            운행 가능 요일
            <label>월<input type="checkbox" name="days[]" value="월"></label>
            <label>화<input type="checkbox" name="days[]" value="화"></label>
            <label>수<input type="checkbox" name="days[]" value="수"></label>
            <label>목<input type="checkbox" name="days[]" value="목"></label>
            <label>금<input type="checkbox" name="days[]" value="금"></label>
            <label>토<input type="checkbox" name="days[]" value="토"></label>
            <label>일<input type="checkbox" name="days[]" value="일"></label>
        </div>
        <div class="box">
            운행 시작 위치
            <label>무열왕릉 <input type="radio" name="location" value="무열왕릉"></label>
            <label>대릉원 <input type="radio" name="location" value="대릉원"></label>
            <label>국립경주박물관 <input type="radio" name="location" value="국립경주박물관"></label>
            <label>화랑의언덕 <input type="radio" name="location" value="화랑의언덕"></label>
            <label>경주엑스포공원 <input type="radio" name="location" value="경주엑스포공원"></label>
            <label>불국사 <input type="radio" name="location" value="불국사"></label>
            <label>석굴암 <input type="radio" name="location" value="석굴암"></label>
            <label>문무대왕릉 <input type="radio" name="location" value="문무대왕릉"></label>
        </div>
        <button>등록 요청</button>
    </form>
    <h1 class="title">거절 차량 목록</h1>
     <table>
        <thead>
            <th>기사ID</th>
            <th>요청일시</th>
            <th>차종</th>
            <th>100m당 요금</th>
            <th>거절 사유</th>
            <th>정보 수정</th>
        </thead>
        <tbody>
            <?php foreach ($rejectCars as $car) { ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= $car->request_at ?></td>
                    <td><?= $car->type ?></td>
                    <td><?= $car->price ?>원</td>
                    <td><?= $car->reject_reason ?></td>
                    <td><a href="/edit/<?= $car->idx ?>">수정</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h1 class="title">차량운행목록</h1>
    
</main>