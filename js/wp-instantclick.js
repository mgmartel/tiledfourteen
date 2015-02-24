InstantClick.on('change', function() {
  // Blacklist classes and IDs
  var c = WPInstantClick.blacklist.class,
      d = WPInstantClick.blacklist.id,
      add_no_instant = function(elms) {
        for (var i = 0; i < elms.length; i++) {
          elms[i].setAttribute("data-no-instant","");
        }
      };

  for (var i = 0; i < c.length; i++) {
    add_no_instant(document.getElementsByClassName(c[i]));
  }
  for (var i = 0; i < d.length; i++) {
    add_no_instant(document.getElementById(d[i]));
  }

  // Compatibility with GA
  if ( typeof ga === 'function' )
    ga('send', 'pageview', location.pathname + location.search);

  if ( typeof window._gaq === 'object' )
    window._gaq.push["_trackPageview", location.pathname + location.search];

});