// const toggle = document.getElementById('toggleDark');
// const body = document.querySelector('body');

// toggle.addEventListener('click', function(){
//     this.classList.toggle('bi-moon');
//     if(this.classList.toggle('bi-brightness-high-fill')){
//         body.style.background = 'white';
//         body.style.color = 'black';
//         body.style.transition = '2s';
//     }else{
//         body.style.background = 'black';
//         body.style.color = 'white';
//         body.style.transition = '2s';
//     }
// });
const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});

document.addEventListener("DOMContentLoaded", function () {
    const passwordIds = ["your_pass", "enter_password", "confirm_pass"];

    passwordIds.forEach(id => {
      const passwordInput = document.getElementById(id);
      const eyeIcon = passwordInput.nextElementSibling.querySelector('.eye');
      const eyeSlashIcon = passwordInput.nextElementSibling.querySelector('.eye-slash');

      if (!passwordInput || !eyeIcon || !eyeSlashIcon) {
        console.error("Password input or icons not found for ID:", id);
        return;
      }

      eyeIcon.addEventListener("click", function () {
        this.style.display = "none";
        eyeSlashIcon.style.display = "block";
        passwordInput.type = "text";
      });

      eyeSlashIcon.addEventListener("click", function () {
        this.style.display = "none";
        eyeIcon.style.display = "block";
        passwordInput.type = "password";
      });
    });
  });

  function capitalizeFirstLetter(input) {
    let value = input.value;
    // Capitalize the first letter
    input.value = value.charAt(0).toUpperCase() + value.slice(1);
}



// document.getElementById('enter_password').addEventListener('keyup', function() {
//     // Get the entered password
//     var password = this.value;

//     // Define your password requirements
//     var hasUpperCase = /[A-Z]/.test(password);
//     var hasSpecialCharacter = /[!@#$%^&*]/.test(password);

//     // Validate the password based on your requirements
//     if (password.length >= 4 && hasUpperCase && hasSpecialCharacter) {
//       //
//     } else {
//       document.getElementById('passError').innerHTML ="Password must be at least 4 characters long, include one uppercase letter, and one special character.'";
//     }
//   });
