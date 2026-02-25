
document.getElementById('button_register').addEventListener('click', function() {

    event.preventDefault(); // Prevent the default behavior of the link
    var href = this.getAttribute('href'); // Get the href attribute
    
    var formData = new FormData(document.getElementById('registry_'));

    document.getElementById('verify_it').value = 'OK';



        // Get the entered password
    var password = document.getElementById("enter_password").value;

    // Define your password requirements
    var hasUpperCase = /[A-Z]/.test(password);
    var hasSpecialCharacter = /[!@#$%^&*]/.test(password);

    // Validate the password based on your requirements
    if (password.length >= 4 && hasUpperCase && hasSpecialCharacter) {
        $.ajax({
            url: href,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.message == "id existed")
                {
                    document.getElementById("Success_Register").innerText = response.message;
                    document.getElementById("enter_password").value = '';
                    document.getElementById("confirm_pass").value = '';
                    // document.getElementById("message").innerText = '';
                }else
                {
                    document.getElementById('username').value = '';
                    document.getElementById("enter_password").value = '';
                    document.getElementById("confirm_pass").value = '';
                    // document.getElementById("message").innerText = '';
                    document.getElementById("Success_Register").innerText = response.message;
                }
    
            },
            error: function(error) {
                console.error(error);
            }
            });
      
    } else {
    //   document.getElementById('passError').innerHTML ="Password must be at least 4 characters long \n include one uppercase letter\n and one special character.'";
      document.getElementById('passError').append("--Password must be at least 4 characters long");
      document.getElementById('passError').append(document.createElement('br'));
      document.getElementById('passError').append("--include one uppercase letter");
      document.getElementById('passError').append(document.createElement('br'));
      document.getElementById('passError').append("--one special character.");

    }
    
    });
