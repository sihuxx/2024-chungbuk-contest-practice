<?php
$user = ss();
if ($user->type != 'admin') back("관리자만 접근 할 수 있는 페이지입니다");
$carRequests = db::fetchAll("select * from cars where status = 'pending' order by request_at");
?>

<main>
    <h1 class="title">차량 등록 승인</h1>
    <table>
        <thead>
            <th>기사ID</th>
            <th>요청일시</th>
            <th>차종</th>
            <th>100m당 요금</th>
            <th>거절 사유</th>
            <th>관리</th>
        </thead>
        <tbody>
            <?php foreach ($carRequests as $car) {
                $driver = db::fetch("select * from users where idx = '$car->driver_idx'") ?>
                <tr>
                    <td><?= $driver->id ?></td>
                    <td><?= $car->request_at ?></td>
                    <td><?= $car->type ?></td>
                    <td><?= $car->price ?>원</td>
                    <td><?= $car->reject_reason ?></td>
                    <td>
                        <form method="post" class="btns">
                            <input type="hidden" name="idx" value="<?= $car->idx ?>">
                            <button formaction="/carAccept">승인</button>
                            <button type="button" onclick="document.querySelector('.modal').style.display = 'flex'">거절</button>
                        </form>
                    </td>
                </tr>
                <div class="modal">
                    <button onclick="document.querySelector('.modal').style.display = 'none'">닫기</button>
                    <form action="/carReject" method="post">
                        <input type="hidden" name="idx" value="<?= $car->idx ?>">
                        <textarea name="reason" placeholder="거절 사유"></textarea>
                        <button>전송</button>
                    </form>
                </div>
            <?php } ?>
        </tbody>
    </table>
</main>