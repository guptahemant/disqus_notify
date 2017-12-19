/**
 * @file
 * disqus_notify.js
 */

(function($){
  console.log('disqus_notify.js Loaded !!')

  /**
   * some description about this module
   */
  Drupal.disqus.notifyDisqus = function (comment) {
    console.log("Comment Posted: ", comment,drupalSettings.disqus.identifier);
    $.ajax({
    url: Drupal.url('disqus-notify/notify-author'),
    type:"POST",
    data: {id: comment.id,text: comment.text,identifier: drupalSettings.disqus.identifier},
    dataType:"json",
    success: function(response) {
        console.log(response);
    }
  });
    console.log("Comment Posted: after ajax");
  };

})(jQuery);
