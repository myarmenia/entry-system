$(function () {
    $('.enter_time_item').on('click', function () {
        $('#time').val('')
      let person_id = $(this).parents('.action').attr('data-person-id')

      let tb_name = $(this).parents('.action').attr('data-tb-name')
      let day = $(this).attr('data-day')
      let date = $(this).attr('data-date')
      let direction = $(this).attr('data-direction')
      let clientId = $(this).attr('data-clientId')
      let existingTime =$(this).attr('data-time')

    //   console.log(person_id,tb_name,day,date, 5252)

      let url = `/enter-time/${tb_name}/${person_id}/${clientId}/${direction}/${date}/${day}/${existingTime}`
      console.log( url)

      $('.send_enter_time').attr('data-url', url)
    //   $('.message_cont').html('')

    })
})


  $(function () {
    $('.send_enter_time').on('click', function () {

        let time = $('#time').val()
        let url = $(this).attr('data-url')
        url = url+"/"+time
        let id = url.split("/").pop();

      console.log(time, url+"/"+time)
    //   let row = $(`.action[data-id="${id}"]`).parents('tr')
    //   let image_div = $(this).parent('.uploaded-image-div')
    //   let image_divs = $('.uploaded-image-div')
    //   console.log(image_div)
      if(url){
    //   if ((image_divs.length > 1 && row.length == 0) || (image_divs.length == 0 && row.length > 0)) {
        $.ajax({
          type: "GET",
          url: url,
          cache: false,
          success: function (data) {
            console.log(data)
            let message = ''
            let type = ''
            if (data.result) {
                    console.log(data.result)
                     message = data.result
                     console.log(message)
                     if(message!="Գործողությունը հաստատված է:"){
                        type = 'danger'
                     }
                     else{
                        type = 'success'
                     }
                // message = 'Գործողությունը հաստատված է։'
                // type = 'success'
                // // row.remove()
                // // image_div.remove()
                // }
                // else {
                // message = 'Սխալ է տեղի ունեցել։'
                // type = 'danger'
                // }

                $('.message_cont').html(`<span class="text-${type}">${message}</span>`)

            // $('.message_cont').html(`<span class="text-${type}">${message}</span>`)
            }
             },

        });
      }
    })


  })
