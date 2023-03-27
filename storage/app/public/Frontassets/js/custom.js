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
$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
});
var activeTab = localStorage.getItem('activeTab');
if(activeTab){
    $('#nav-tab a[href="' + activeTab + '"]').tab('show');
    let title=$('#nav-tab a[href="' + activeTab + '"]').text();
    let totals=$('#nav-tab a[href="' + activeTab + '"]').attr('data-count');
    if(totals!==undefined){
      $('#total-count').text(totals+' '+title);
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
});

$(window).on("load", function () {
  $("#spinner").fadeOut("3000");
});
