$(function () {
    $('.change_status').on("change", function () {

      let id = $(this).parents('.action').attr('data-id')

      let tb_name = $(this).parents('.action').attr('data-tb-name')
      let status = $(this).prop('checked')
      let field_name = $(this).attr('data-field-name')
      let changeElemen = $(this)

console.log(id, tb_name, status, field_name)
      $.ajax({
        type: "post",
        url: "/change-status",
        data: { id, tb_name, status, field_name },
        cache: false,
        success: function (data) {
          console.log(data.result)
          let status_word = ''
          let status_class = ''
          console.log(changeElemen.closest('tr').children('.' + field_name))
          if (data.result == 1) {

              status ? (status_word = 'Ակտիվ', status_class = 'success') : (status_word = 'Ապաակտիվ', status_class = 'danger')

              console.log(status_word + '--status_word--', status_class + '--status_class --')

              changeElemen.closest('tr').children('.' + field_name).html(`
                <span class="badge bg-label-${status_class} me-1">${status_word}</span>`)
          }

        }

      });

    });

  });
