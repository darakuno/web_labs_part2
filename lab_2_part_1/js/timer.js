const year = new Date().getFullYear();
const newyear = new Date(year+1, 0o2, 0o12).getTime();

let timer = setInterval(function() {
  const today = new Date().getTime();
  const diff = newyear - today;

  let days = Math.floor(diff / (1000 * 60 * 60 * 24));
  let hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
  let seconds = Math.floor((diff % (1000 * 60)) / 1000);

  document.getElementById("timer").innerHTML =
    days + " дней " + hours  + " часов " + minutes +" минут " + seconds + " секунд ";
}, 1000);