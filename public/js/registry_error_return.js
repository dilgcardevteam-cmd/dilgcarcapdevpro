
function validateForm() {
    const username = document.getElementById('id_number');
    const pass = document.getElementById('enter_password');

    var errorDiv = document.getElementById('usernameError');
    var errorDiv2 = document.getElementById('passError');

    if (username.value === '') {
        errorDiv.textContent = 'Please fill out this field.';
      } else {
        errorDiv.textContent = '';
      }

    if (pass.value === '') {
        errorDiv2.textContent = 'Please fill out this field password.';
      } else {
        errorDiv2.textContent = '';
      }
  }
  
function resset()
{
    const username = document.getElementById('id_number');
    const pass = document.getElementById('enter_password');

    var errorDiv = document.getElementById('usernameError');
    var errorDiv2 = document.getElementById('passError');
    var errotDiv3 = document.getElementById("Success_Register");

        errorDiv.textContent = '';
        errorDiv2.textContent = '';
        errotDiv3.textContent = '';

        // document.getElementById('id_number').value = '';
        document.getElementById('fullname').value = '';
        document.getElementById("enter_password").value = '';
        document.getElementById("confirm_pass").value = '';
}

// document.getElementById("id_number").addEventListener("keyup", function() {
//     const username = document.getElementById('id_number');

//     var errorDiv = document.getElementById('usernameError');

//     if (username.value === '') {
//         errorDiv.textContent = 'Please fill out this field.';

//       } else {
//         errorDiv.textContent = '';

  
//       }
// });

document.getElementById("enter_password").addEventListener("keyup", function() {
    const username = document.getElementById('enter_password');

    var errorDiv = document.getElementById('passError');

    if (username.value === '') {
        errorDiv.textContent = 'Please fill out this field.';

      } else {
        errorDiv.textContent = '';

  
      }
});

$(document).ready(function() {
    $('#id_number').on('input', function() {
        if (this.value.length > 8) {
            this.value = this.value.slice(0, 8);
        }
    });
    $('#enter_password').on('input', function() {
        if (this.value.length > 16) {
            this.value = this.value.slice(0, 16);
        }
    });
    $('#confirm_pass').on('input', function() {
        if (this.value.length > 16) {
            this.value = this.value.slice(0, 16);
        }
    });
});

document.getElementById("confirm_pass").addEventListener("keyup", function() {
    const password = document.getElementById("enter_password").value;
    const confirmPassword = document.getElementById("confirm_pass").value;
    const message = document.getElementById("message");


    if (password === confirmPassword) {
        message.innerHTML = "Passwords match";
        message.style.color = "green";
    } else {
        message.innerHTML = "Passwords do not match";
        message.style.color = "red";
    }
});