$('.toggle').on('click', function() {
  $('.container').stop().addClass('active');
});

$('.close').on('click', function() {
  $('.container').stop().removeClass('active');
});

$(document).ready(function() {
  $("input[name$='user']").click(function() {
    var test = $(this).val();

    $("div.desc").hide();
    $("#User" + test).show();
  });
});