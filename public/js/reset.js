const container = document.getElementById('container');

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
