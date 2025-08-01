$(document).ready(function () {
  pageAction();
  $(".p-link").each(function () {
    if ($(this).attr("href") == window.location.href) {
      $(this).addClass("p-link-active");
    }
  });

  $(".navbar-nav-link,.module-link").each(function () {
    if ($(this).attr("href") == window.location.href) {
      $(this).addClass("active");
    }
  });
  

 
  $(".sub-link").each(function () {
    if ($(this).attr("href") == window.location.href) {
      $(this).addClass("sub-link-active");
    }
  });
  $(".p-link-hr").each(function () {
    if ($(this).attr("href") == window.location.href) {
      $(this).addClass(" p-link-hr-active");
    }
  });
  $(".sub-link-hr").each(function () {
    if ($(this).attr("href") == window.location.href) {
      $(this).addClass(" sub-link-hr-active");
    }
  });
  $(".select2").select2();
  $("#closeError").on("click", function () {
    $("#showErros").html("");
    $("#errorBase").removeClass("activateErrors").fadeOut(500);
  });
  $("#closeDownload").on("click", function () {
    $("#theDownloadLoader").css({ display: "none" });
  });
});
