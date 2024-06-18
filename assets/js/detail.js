$(function () {
  $(document).ready(function () {
    fd = new FormData();
    ticket_id = $('#ticket_id').val()
    fd.append('ticket_id',ticket_id);
    // console.log(...fd);
    $.ajax({
      url: "api.php/ticketinfo",
      type: "POST",
      data:fd,
      processData: false,
      contentType: false,

      success: function (data) {
        console.log(data);
        $("#ticket_id").val(data.ticket_id);
        $("#responder_select").select2({
          theme: "bootstrap4",
          data: data.responder,
        });
        $("#responder_select").find('option').prop("selected",true);
        $("#responder_select").trigger("change");
        $('#ticket_sub').val(data.ticket.sub_pesan);
        $('#ticket_id').val(ticket_id).trigger("change");
        $('#ticket_priority').val(data.ticket.level_prioritas);
        $('#ticket_status').val(data.ticket.status);
      },
      error: function (data) {
        console.log(data);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Terjadi kesalahan load daa",
        });
      },
    });
  });
});
