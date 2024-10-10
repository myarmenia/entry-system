$(function () {
    $('#selectedRole').on("change", function () {

        if($(this).val()=="client_admin"){
            let userName=$('input[name="name"]').val();
            let userEmail=$('input[name="email"]').val();
            let userPassword=$('input[name="password"]').val();
            let userConfirmPassword=$('input[name="confirm-password"]').val();

            // $('#componentContainer').html(<x-client></x-client>);
            $.ajax({
                url: '/client-component',
                type: 'POST',
                data: {
                    // _token: '{{ csrf_token() }}',
                    name:userName,
                    email:userEmail,
                    password:userPassword,
                    confirmPassword:userConfirmPassword
                    // Любые данные, которые нужно передать
                },
                success: function(response) {
                    console.log(response.html)
                    // Вставляем HTML компонента в контейнер
                    $('#componentContainer').html(response.html);
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                }
            });


        }

    })
})
