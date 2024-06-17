$(function () {
  $(document).ready(function () {
    $("#login_form").submit(function (event) {
      event.preventDefault();

      Swal.fire({
        title: "Sedang mengunggah data...",
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
          Swal.showLoading();
        },
      });

      $.ajax({
        url: "login-check.php",
        type: "POST",
        data: new FormData($("#login_form")[0]),
        processData: false,
        contentType: false,
        success: function (data) {
          response = JSON.parse(data);
          Swal.fire({
            icon: response.status === "success" ? "success" : "error",
            title: response.status === "success" ? "Sukses" : "Error",
            text: response.message,
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = "main.php?module=home";
            }
          });
        },
        error: function () {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Terjadi kesalahan saat Login.",
          });
        },
      });
    });
    $("#logout_button").click(function (event) {
      Swal.fire({
        title: "Apakah Anda yakin ingin logout?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Tidak",
        confirmButtonText: "Ya",
      }).then(function () {
        $.ajax({
          url: "logout.php",
          success: function (data) {
            window.location.href = "index.php";
          },
          error: function () {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Terjadi kesalahan saat Logout.",
            });
          },
        });
      });
    });
  });
  var $sidebar = $(".control-sidebar");
  var $container = $("<div />", {
    class: "p-3 control-sidebar-content",
  });

  var $sidebar_collapsed_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    checked: $("body").hasClass("sidebar-collapse"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $("body").addClass("sidebar-collapse");
      $(window).trigger("resize");
    } else {
      $("body").removeClass("sidebar-collapse");
      $(window).trigger("resize");
    }
  });
  var $sidebar_collapsed_container = $("<div />", { class: "mb-1" })
    .append($sidebar_collapsed_checkbox)
    .append("<span>Collapsed</span>");
  $container.append($sidebar_collapsed_container);

  $(document).on(
    "collapsed.lte.pushmenu",
    '[data-widget="pushmenu"]',
    function () {
      $sidebar_collapsed_checkbox.prop("checked", true);
    }
  );
  $(document).on("shown.lte.pushmenu", '[data-widget="pushmenu"]', function () {
    $sidebar_collapsed_checkbox.prop("checked", false);
  });
});
