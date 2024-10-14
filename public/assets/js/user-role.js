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
})
