$(function () {
    $('.enter_time_item').on('click', function () {
      let person_id = $(this).parents('.action').attr('data-person-id')

      let tb_name = $(this).parents('.action').attr('data-tb-name')
      let day = $(this).attr('data-day')
      let date = $(this).attr('data-date')

      console.log(id,tb_name,day,date, 5252)

      let url = `/enter-time/${tb_name}/${person_id}/${date}/${day}`
    //   console.log(person_id,tb_name, url)

      $('.enter_time_item').attr('data-url', url)
    //   $('.message_cont').html('')

    })
  })


  $(function () {
    $('.enter_time_item').on('click', function () {
      let url = $(this).attr('data-url')
      let id = url.split("/").pop();
      
      console.log(url,id)
      let row = $(`.action[data-id="${id}"]`).parents('tr')
      let image_div = $(this).parent('.uploaded-image-div')
      let image_divs = $('.uploaded-image-div')
    //   console.log(image_div)
      if ((image_divs.length > 1 && row.length == 0) || (image_divs.length == 0 && row.length > 0)) {
        $.ajax({
          type: "GET",
          url: url,
          cache: false,
          success: function (data) {
            let message = ''
            let type = ''
            if (data.result) {
                console.log(data.result)
              message = 'Գործողությունը հաստատված է։'
              type = 'success'
              row.remove()
              image_div.remove()
            }
            // else {
            //   message = 'Սխալ է տեղի ունեցել։'
            //   type = 'danger'
            // }

            $('.message_cont').html(`<span class="text-${type}">${message}</span>`)
          },
          error:function(xhr, status,error){

            console.log(xhr.responseJSON.error)
            $('.message_cont').html(`<span class="text-danger">${xhr.responseJSON.error}</span>`)
          }
        });
      }
    })
  })
