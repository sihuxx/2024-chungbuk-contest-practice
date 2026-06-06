<?php
$car = db::fetch("select * from cars where idx = '$idx'");
?>

<main>
    <h1 class="title">차량 재등록 요청</h1>
    <form action="/carEditRequest" method="post">
        <input type="hidden" name="idx" value="<?= $idx ?>">
        <label>차종<input type="text" value="<?= $car->type ?>" placeholder="차종" name="type"></label>
        <label>100m 당 요금<input type="number" value="<?= $car->price ?>" placeholder="100m 당 요금" name="price" min="100" max="500" step="100"></label>
        <div class="box">
            운행 가능 요일
            <?php
            $days = explode(',', $car->days);
            $allDays = ['월', '화', '수', '목', '금', '토', '일'];
            foreach ($allDays as $day) {
                $checked = in_array($day, $days) ? 'checked' : '';
                echo "<label>$day <input type='checkbox' name='days[]' value='$day' $checked></label>";
            }
            ?>
        </div>
        <div class="box">
            운행 시작 위치
            <?php
            $locations = ['무열왕릉', '대릉원', '국립경주박물관', '화랑의언덕', '경주엑스포공원', '불국사', '석굴암', '문무대왕릉',];
            foreach ($locations as $location) {
                $checked = $car->location == $location ? 'checked' : '';
                echo "<label>$location <input type='radio' name='location' value='$location' $checked></label>" ;
            }
            ?>
        </div>
        <button>재등록 요청</button>
    </form>
</main>