$(function () {
  let editor1;
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
          type : "POST",
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

  $("#responder_select").select2({ theme: "bootstrap4" });
  $("#add_ticket").click(function (event) {
    $.ajax({
      url: "api.php/newticketinfo",
      type: "POST",

      success: function (data) {
        $('#ticket_id').val(data.ticket_id)
        $("#responder_select").select2({ 
          theme: "bootstrap4" ,
          data : data.items
        });
      },
      error: function (data) {
        console.log(data);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Terjadi kesalahan ",
        });
      },
    });
  });
  $("#ticket_form").submit(function (event) {
    event.preventDefault();
    formdata = new FormData($("#ticket_form")[0]);
    desc_data = editor1.getData();
    formdata.append('ticket_desc',desc_data);
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
      url: "api.php/new_ticket",
      type: "POST",
      data: formdata,
      processData: false,
      contentType: false,
      success: function (data) {
        console.log(data)
        Swal.fire({
          icon: data.status === "success" ? "success" : "error",
          title: data.status === "success" ? "Sukses" : "Error",
          text: data.message,
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "main.php?module=send";
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
  $("#detail_form").submit(function (event) {
    event.preventDefault();
    formdata = new FormData($("#detail_form")[0]);
    desc_data = editor1.getData();
    formdata.append('detail_desc',desc_data);
    formdata.append('detail_type','response');
    console.log(...formdata);
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
  $(".add_cordinator").click(function (event) {
    formdata = new FormData();
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
      url: "api.php/add_cordinator",
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
  $('#datatables1').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
  });
  CKEDITOR.ClassicEditor.create(document.getElementById("editor1"), {
    // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
    toolbar: {
      items: [
        "exportPDF",
        "exportWord",
        "findAndReplace",
        "|",
        "heading",
        "|",
        "bold",
        "italic",
        "strikethrough",
        "underline",
        "code",
        "subscript",
        "superscript",
        "removeFormat",
        "|",
        "bulletedList",
        "numberedList",
        "todoList",
        "|",
        "outdent",
        "indent",
        "-",
        "undo",
        "redo",
        "|",
        "fontSize",
        "fontFamily",
        "fontColor",
        "fontBackgroundColor",
        "highlight",
        "|",
        "alignment",
        "|",
        "link",
        "uploadImage",
        "blockQuote",
        "insertTable",
        "mediaEmbed",
        "codeBlock",
        "htmlEmbed",
        "|",
        "specialCharacters",
        "horizontalLine",
        "pageBreak",
        "|",
        "textPartLanguage",
        "|",
        "sourceEditing",
      ],
      shouldNotGroupWhenFull: true,
    },
    // Changing the language of the interface requires loading the language file using the <script> tag.
    // language: 'es',
    list: {
      properties: {
        styles: true,
        startIndex: true,
        reversed: true,
      },
    },
    // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
    heading: {
      options: [
        {
          model: "paragraph",
          title: "Paragraph",
          class: "ck-heading_paragraph",
        },
        {
          model: "heading1",
          view: "h1",
          title: "Heading 1",
          class: "ck-heading_heading1",
        },
        {
          model: "heading2",
          view: "h2",
          title: "Heading 2",
          class: "ck-heading_heading2",
        },
        {
          model: "heading3",
          view: "h3",
          title: "Heading 3",
          class: "ck-heading_heading3",
        },
        {
          model: "heading4",
          view: "h4",
          title: "Heading 4",
          class: "ck-heading_heading4",
        },
        {
          model: "heading5",
          view: "h5",
          title: "Heading 5",
          class: "ck-heading_heading5",
        },
        {
          model: "heading6",
          view: "h6",
          title: "Heading 6",
          class: "ck-heading_heading6",
        },
      ],
    },
    // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
    placeholder: "Welcome to CKEditor 5!",
    // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
    fontFamily: {
      options: [
        "default",
        "Arial, Helvetica, sans-serif",
        "Courier New, Courier, monospace",
        "Georgia, serif",
        "Lucida Sans Unicode, Lucida Grande, sans-serif",
        "Tahoma, Geneva, sans-serif",
        "Times New Roman, Times, serif",
        "Trebuchet MS, Helvetica, sans-serif",
        "Verdana, Geneva, sans-serif",
      ],
      supportAllValues: true,
    },
    // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
    fontSize: {
      options: [10, 12, 14, "default", 18, 20, 22],
      supportAllValues: true,
    },
    // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
    // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
    htmlSupport: {
      allow: [
        {
          name: /.*/,
          attributes: true,
          classes: true,
          styles: true,
        },
      ],
    },
    // Be careful with enabling previews
    // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
    htmlEmbed: {
      showPreviews: false,
    },
    // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
    link: {
      decorators: {
        addTargetToExternalLinks: true,
        defaultProtocol: "https://",
        toggleDownloadable: {
          mode: "manual",
          label: "Downloadable",
          attributes: {
            download: "file",
          },
        },
      },
    },
    // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
    // The "superbuild" contains more premium features that require additional configuration, disable them below.
    // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
    removePlugins: [
      // These two are commercial, but you can try them out without registering to a trial.
      // 'ExportPdf',
      // 'ExportWord',
      "AIAssistant",
      "CKBox",
      "CKFinder",
      "EasyImage",
      // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
      // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
      // Storing images as Base64 is usually a very bad idea.
      // Replace it on production website with other solutions:
      // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
      // 'Base64UploadAdapter',
      "MultiLevelList",
      "RealTimeCollaborativeComments",
      "RealTimeCollaborativeTrackChanges",
      "RealTimeCollaborativeRevisionHistory",
      "PresenceList",
      "Comments",
      "TrackChanges",
      "TrackChangesData",
      "RevisionHistory",
      "Pagination",
      "WProofreader",
      // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
      // from a local file system (file://) - load this site via HTTP server if you enable MathType.
      "MathType",
      // The following features are part of the Productivity Pack and require additional license.
      "SlashCommand",
      "Template",
      "DocumentOutline",
      "FormatPainter",
      "TableOfContents",
      "PasteFromOfficeEnhanced",
      "CaseChange",
    ],
  }).then(Neweditor =>{
    editor1 = Neweditor;
  } )
});
