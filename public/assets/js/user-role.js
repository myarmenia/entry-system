$(function () {
    $('#selectedRole').on("change", function () {

        if($(this).val()=="client_admin"){
            // let userName=$('input[name="name"]').val();
            // let userEmail=$('input[name="email"]').val();
            // let userPassword=$('input[name="password"]').val();
            // let userConfirmPassword=$('input[name="confirm-password"]').val();
            let userRole=$('input[name="roles"]').val();

            $.ajax({
                url: '/client-component',
                type: 'POST',
                data: {
                    // _token: '{{ csrf_token() }}',
                    // name:userName,
                    // email:userEmail,
                    // password:userPassword,
                    // confirmPassword:userConfirmPassword,
                    // userRole:userRole
                    // Любые данные, которые нужно передать
                },
                success: function(response) {
                    console.log(response.html)

                    $('#componentContainer').html(response.html);
                    $('#loginBtn').css({
                        'display': 'none'
                    });
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });


        }

    })
// alert()
    $('#myForm').on('submit', function(e) {
        e.preventDefault();
        // alert()
        var $that = $(this)
        var formData = new FormData($(this)[0]);;
        console.log(66666)
        // formData.append('name', );

        // Send AJAX request
        $.ajax({
            url: "/store-user", // The route to your Laravel controller
            type: 'POST',
            data: formData,
            contentType: false,  // Important: Prevent jQuery from processing the data
            processData: false,  // Important: Prevent jQuery from converting data to a string
            success: function(response) {
                alert('Form submitted successfully!');
                console.log(response); // You can handle the response here
            },
            error: function(xhr, status, error) {
                console.error('Form submission failed:', error);
            }
        });
    });

})
