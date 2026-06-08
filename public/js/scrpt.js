// // 각 select에 위치 정보 8개를 각각 집어넣어서 장소 옵션 추가
// $$("select").forEach(sel => {
//   locations.forEach(loc => {
//     sel.innerHTML = `<option value="${loc.idx}">${loc.name}</option>`;
//   })
// })

// // 인접 목록 만들기
// // { "1": [{to:"2", distance:3.9}, ...], ... }
// const map = {}
// locations.forEach(loc => { map[loc.idx] = [] })
// routes.forEach(r => {
//   if (r.distance !== null) {
//     map[r.from_idx].push({ to: String(r.to_idx), distance: +r.distance })
//     // 위에서 만든 location idx와 해당 from_idx가 같으면 해당 배열에 to, disatnce를 push함
//   }
// })

// let activePath = null // 선택된 경로 문자열
// let activeDistance = null // 선택된 경로 거리


// // select 바뀔 때마다 실행
// $("#routeForm").addEventListener('change', () => {
//   const start = $("[name='start']").value
//   const end = $("[name='end']").value
//   const waypoints = [
//     $("[name='wp1']").value,
//     $("[name='wp2']").value,
//     $("[name='wp3']").value,
//     $("[name='wp4']").value,
//   ].filter(Boolean) // 값이 있으면 true(유지), 빈 칸("")이면 false(제거)하여 빈 값 청소

//   // 출발, 도착, 경유지 2개 이상 있어야 계산 시작
//   if (!start || !end || waypoints.length < 2) return

//   // 경로 계산
//   const top3 = getTopPaths(start, end, waypoints)

//   $("#routeList").innerHTML = top3.map(({ path, totalDistance }) => {
//     const pathStr = path.map(idx =>
//       locations.find(l => +l.idx === +idx)?.name
//     ).join("->")

//     return `<div class="route" 
//                     data-path="${pathStr}" 
//                     data-distance="${Math.round(totalDistance * 100) / 100}">
//             <p>${pathStr}</p>
//             <p>${Math.round(totalDistance * 100) / 100}km</p>
//         </div>`;
//   })
// })

// // DFS 최단 경로
// // -> 어케하는지모르겟음 => 질문
// const getTop3Paths = (start, end, waypoints) => {
//   const results = []

//   const dfs = (current, visited, path, dist) => {
//     if (current === end && waypoints.every(w => path.includes(w))) {
//       results.push({ path: [...path, current], totalDistance: dist });
//       return
//     }
//     if ((visited[current] || 0) >= 2) return

//     visited[current] = (visited[current] || 0) + 1

//       (map[current] || []).forEach(({ to, distance }) => {
//         dfs(to, { ...visited }, [...path, current], dist + distance)
//       })
//   }

//   dfs(start, {}, [], 0)
//   return results.sort((a, b) => a.totalDistance - b.totalDistance).slice(0, 3)
// }
