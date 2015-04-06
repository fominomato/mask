/*
 * OpenSocial jQuery autoHeight 1.0.0
 * http://code.google.com/p/opensocial-jquery/
 *
 * Copyright(C) 2009 Nakajiman Software Inc.
 * http://nakajiman.lrlab.to/
 *
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 */
jQuery.fn.extend({
  autoHeight: function(delay) {
    if (this[0] === window)
      setInterval(function() {
        gadgets.window.adjustHeight();
      }, delay || 1000);
    return this;
  }
});
