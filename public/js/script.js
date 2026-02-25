// let toggleBtn = document.getElementById('toggle-btn');
let body = document.body;
let darkMode = localStorage.getItem('dark-mode');

const enableDarkMode = () =>{
   // toggleBtn.classList.replace('fa-sun', 'fa-moon');
   body.classList.add('dark');
   localStorage.setItem('dark-mode', 'enabled');
}

const disableDarkMode = () =>{
   // toggleBtn.classList.replace('fa-moon', 'fa-sun');
   body.classList.remove('dark');
   localStorage.setItem('dark-mode', 'disabled');
}

if(darkMode === 'enabled'){
   enableDarkMode();
}

// toggleBtn.onclick = (e) =>{
//    darkMode = localStorage.getItem('dark-mode');
//    if(darkMode === 'disabled'){
//       enableDarkMode();
//    }else{
//       disableDarkMode();
//    }
// }

let profile = document.querySelector('.header .flex .profile');

let notificationForm = document.querySelector('.header .flex .notification-form');

let search = document.querySelector('.header .flex .search-form');

document.querySelector('#user-btn').onclick = () =>{
   notificationForm.classList.remove('active');
   profile.classList.toggle('active');
   search.classList.remove('active');
}

document.querySelectorAll(".btn").forEach(function(btnElement) {
   btnElement.addEventListener("click", function() {
      notificationForm.classList.remove('active');
      search.classList.remove('active');
      profile.classList.toggle('active');
   });
});

// let workDetails = document.querySelector('.work-view-container');
// document.querySelector('#day-work').onclick = () =>{
//    workDetails.classList.toggle('active');
// }

document.querySelector('.cls-btn').onclick = () => {
   workDetails.classList.remove('active');
}

document.querySelector('#search-btn').onclick = () =>{
   search.classList.toggle('active');
   profile.classList.remove('active');
}

// document.querySelector('html').onclick = () =>{
//    var ret_1 = profile.className.indexOf('active');
//    var ret_2 = notificationForm.className.indexOf('active');
//    var ret_3 = search.className.indexOf('active');

//    if(ret_3 == 12)
//    {
//       // ret_3 = -1;
//       console.log(ret_3);
//       // notificationForm.classList.remove('active');
//       // profile.classList.remove('active');
//        search.classList.toggle('active');
//    }
// }

document.querySelector('#notification-btn').onclick = () => {
   notificationForm.classList.toggle('active');
   profile.classList.remove('active');
   search.classList.remove('active');
}

document.querySelector('#notification-btn').onclick = () => {
   notificationForm.classList.toggle('active');
   // search.classList.toggle('active');
   profile.classList.remove('active');
}

let sideBar = document.querySelector('.side-bar');
let calendar = document.querySelector('.calendar-container');

document.querySelector('#menu-btn').onclick = () =>{
   notificationForm.classList.remove('active');
   profile.classList.remove('active');
   search.classList.remove('active');

   sideBar.classList.toggle('active');
   body.classList.toggle('active');
   calendar.classList.toggle('active');
}

document.querySelector('#close-btn').onclick = () =>{
   sideBar.classList.remove('active');
   body.classList.remove('active');
   calendar.classList.toggle('active');
}

window.onscroll = () =>{
   profile.classList.remove('active');
   search.classList.remove('active');
   notificationForm.classList.remove('active');

   if(window.innerWidth < 1200){
      sideBar.classList.remove('active');
      body.classList.remove('active');
      calendar.classList.remove('active');
   }
}
