/*
 * Copyright ©2023 JQL all rights reserved.
 * http://www.jql.co.uk
 */

/**
 * Set the language
 *
 * @returns {undefined}
 */
$(function () {
  $(document).on('click', '.language', function (event) {
    event.preventDefault();
    let lang = $(this).attr('id');  // Get the language key
    /* if not the top level, set the language and reload the page */
    if (lang !== 'languageTop') {
      $.post(document.location.origin + '/site/language', {'lang': lang}, function (data) {
        location.reload(true);
      });
    }
  });
});