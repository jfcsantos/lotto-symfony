// $(document).ready(function(){
//
//   // using jQuery
//   function getCookie(name) {
//       var cookieValue = null;
//       if (document.cookie && document.cookie !== '') {
//           var cookies = document.cookie.split(';');
//           for (var i = 0; i < cookies.length; i++) {
//               var cookie = jQuery.trim(cookies[i]);
//               // Does this cookie string begin with the name we want?
//               if (cookie.substring(0, name.length + 1) === (name + '=')) {
//                   cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
//                   break;
//               }
//           }
//       }
//       return cookieValue;
//   }
//   var csrftoken = getCookie('csrftoken');
//
//   function csrfSafeMethod(method) {
//     // these HTTP methods do not require CSRF protection
//     return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
// }
// $.ajaxSetup({
//     beforeSend: function(xhr, settings) {
//         if (!csrfSafeMethod(settings.type) && !this.crossDomain) {
//             xhr.setRequestHeader("X-CSRFToken", csrftoken);
//         }
//     }
// });
//
//     $("#reg-lottery-btn").click(function(){
//       event.preventDefault();
//       var url = $(this).attr("action");
//       var posting = $.post(url);
//       posting.done(function( data ) {
//         if(data.success==true) {
//           $('.participant-cta-wrapper').empty().append("<h3>Thank you for registering for this lottery.</h3>")
//         }
//       });
//     });
//     $("#gen-winner-btn").submit(function(){
//       event.preventDefault();
//       var url = $(this).attr("action");
//       var posting = $.post(url);
//       posting.done(function( data ) {
//         if(data.success==true) {
//           $('.participant-cta-wrapper').empty().append("<h3>The winner is " + data.winner + "</h3>")
//         }
//       });
//     });
// });
