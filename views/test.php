test page

<script type="module">
const getUsers = () => fetch('/users').then(res => res.json());


let prevUsers = null;
setInterval(async () => {
  const users = await getUsers();
  if (JSON.stringify(prevUsers) !== users.lengh) {

  }
}, 3000);

</script>