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
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Terjadi kesalahan load daa",
        });
      },
    });
  });
  $("#mark_form").submit(function (event) {
    event.preventDefault();
    formdata = new FormData($("#mark_form")[0]);
    formdata.append('detail_desc','');
    var clickedButton = document.activeElement;
    if (clickedButton && clickedButton.type === "submit") {
        formdata.append(clickedButton.name, clickedButton.value);
    }
    // console.log(...formdata);
    Swal.fire({
      title: "Sedang mengunggah data...",
      allowOutsideClick: false,
      showConfirmButton: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    $.ajax({
      url: "api.php/add_detail_respon",
      type: "POST",
      data: formdata,
      processData: false,
      contentType: false,
      success: function (data) {
        Swal.fire({
          icon: data.status === "success" ? "success" : "error",
          title: data.status === "success" ? "Sukses" : "Error",
          text: data.message,
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.reload();
          }
        });
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Terjadi kesalahan saat input.",
        });
      },
    });
  });
});
