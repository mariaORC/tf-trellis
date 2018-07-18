jQuery(document).ready(function($) {
  $.ajax({
    url: "https://thoughtfarmer.zendesk.com/satisfaction.json",
    dataType: "jsonp",
    cache: false,
    success:function(data){
      var satisfactionPercent = 0;

      for (i=0;i<data.length;i++) {
        if (data[i] === 1) {
          satisfactionPercent++;
        }
      }
      $(".zendeskRating").text(satisfactionPercent + "%");
    }
  });
});