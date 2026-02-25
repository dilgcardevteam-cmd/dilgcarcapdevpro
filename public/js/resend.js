document.addEventListener('DOMContentLoaded', function () { // Wait for the DOM to load
    const resendLink = document.querySelector('.resend-link');
    const email = resendLink.getAttribute('data-email'); // Get the email from data attribute

    resendLink.addEventListener('click', (event) => {
        event.preventDefault(); // Prevent default GET request

        const formData = new FormData();
        formData.append('email', email);

        fetch(resendLink.href, { // Use the link's href as the URL
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            // Handle response (e.g., show success message)
        })
        .catch(error => {
            // Handle error (e.g., show error message)
        });
    });
});
