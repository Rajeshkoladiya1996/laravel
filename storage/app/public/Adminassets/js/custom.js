// let buttonToggle = () => {
//   const button = document.getElementById("menu-button").classList,
//     isopened = "is-opened";
//   let isOpen = button.contains(isopened);
//   if (isOpen) {
//     button.remove(isopened);
//   } else {
//     button.add(isopened);
//   }
// };
$('a[data-toggle="tab"]').on("show.bs.tab", function (e) {
  localStorage.setItem("activeTab", $(e.target).attr("href"));
});
var activeTab = localStorage.getItem("activeTab");
if (activeTab) {
  $('#nav-tab a[href="' + activeTab + '"]').tab("show");
  let title = $('#nav-tab a[href="' + activeTab + '"]').text();
  let totals = $('#nav-tab a[href="' + activeTab + '"]').attr("data-count");
  if (totals !== undefined) {
    $("#total-count").text(totals + " " + title);
  }
}

$("#menu-button").click(function () {
  $("html").toggleClass("show-menu");
});

$(document).ready(function () {
  $("#example").DataTable({
    // paging: false,
    // ordering: false,
    // info: false,
  });
});
$(document).ready(function () {
  $("#example2").DataTable({
    // paging: false,
    // ordering: false,
    // info: false,
  });
  function LiveModalRation() {
    var $modalHeight = $("#live-modal .modal-content").outerHeight(true),
      $modalWidth = $modalHeight - ($modalHeight * 43.7) / 100;
    $("#live-modal .modal-dialog").width($modalWidth);
  }
  LiveModalRation();
  $(window).on("resize", function () {
    LiveModalRation();
  });
  $("#live-modal").on("shown.bs.modal", function (event) {
    LiveModalRation();
  });
});

$(window).on("load", function () {
  $("#spinner").fadeOut("3000");
});

$(document).on("keypress", function (e) {
  if (e.keyCode == 27) {
    e.preventDefault();
    return false;
  }
});
