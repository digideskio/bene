!function o(c,l,a){function r(t,e){if(!l[t]){if(!c[t]){var s="function"==typeof require&&require;if(!e&&s)return s(t,!0);if(d)return d(t,!0);var i=new Error("Cannot find module '"+t+"'");throw i.code="MODULE_NOT_FOUND",i}var n=l[t]={exports:{}};c[t][0].call(n.exports,function(e){return r(c[t][1][e]||e)},n,n.exports,o,c,l,a)}return l[t].exports}for(var d="function"==typeof require&&require,e=0;e<a.length;e++)r(a[e]);return r}({1:[function(e,t,s){var o;o=jQuery,Drupal,window,Drupal.behaviors.tsBENE={attach:function(e,t){var s={isMobile:function(){return"none"!=o(".mobile-menu-toggle").css("display")},beneMobile:function(){this.isMobile()&&o(".mobile-menu-toggle").once().click(function(){o(this).toggleClass("active"),o(".mobile-nav .menu").fadeToggle(500)})},formCleanup:function(){o(".region-content form").find("input").each(function(){var e=o(this),t=o('label[for="'+this.id+'"]').text().trim();e.attr("placeholder",t)})},messageDismiss:function(){o(".messages").once().click(function(){o(this).fadeOut()})},showHideTabs:function(){o(".user-logged-in .block-local-tasks-block").once().prepend('<div class="show-hide"><span></span></div>'),o(".block-local-tasks-block .show-hide").once().click(function(){o(this).parent().toggleClass("active")})},beneHero:function(){"none"==o(".block-hero").css("background-image")?o(".block-hero").addClass("no-bgimage").css("visibility","visible"):o(".block-hero").addClass("bgimage").css("visibility","visible")},beneNiceSelect:function(){o.fn.niceSelect=function(e){if("string"==typeof e)return"update"==e?this.each(function(){var e=o(this),t=o(this).next(".nice-select"),s=t.hasClass("open");t.length&&(t.remove(),i(e),s&&e.next().trigger("click"))}):"destroy"==e?(this.each(function(){var e=o(this),t=o(this).next(".nice-select");t.length&&(t.remove(),e.css("display",""))}),0==o(".nice-select").length&&o(document).off(".nice_select")):console.log('Method "'+e+'" does not exist.'),this;function i(e){e.after(o("<div></div>").addClass("nice-select").addClass(e.attr("class")||"").addClass(e.attr("disabled")?"disabled":"").attr("tabindex",e.attr("disabled")?null:"0").html('<span class="current"></span><ul class="list"></ul>'));var i=e.next(),t=e.find("option"),s=e.find("option:selected");i.find(".current").html(s.data("display")||s.text()),t.each(function(e){var t=o(this),s=t.data("display");i.find("ul").append(o("<li></li>").attr("data-value",t.val()).attr("data-display",s||null).addClass("option"+(t.is(":selected")?" selected":"")+(t.is(":disabled")?" disabled":"")).html(t.text()))})}this.hide(),this.each(function(){var e=o(this);e.next().hasClass("nice-select")||i(e)}),o(document).off(".nice_select"),o(document).on("click.nice_select",".nice-select",function(e){var t=o(this);o(".nice-select").not(t).removeClass("open"),t.toggleClass("open"),t.hasClass("open")?(t.find(".option"),t.find(".focus").removeClass("focus"),t.find(".selected").addClass("focus")):t.focus()}),o(document).on("click.nice_select",function(e){0===o(e.target).closest(".nice-select").length&&o(".nice-select").removeClass("open").find(".option")}),o(document).on("click.nice_select",".nice-select .option:not(.disabled)",function(e){var t=o(this),s=t.closest(".nice-select");s.find(".selected").removeClass("selected"),t.addClass("selected");var i=t.data("display")||t.text();s.find(".current").text(i),s.prev("select").val(t.data("value")).trigger("change")}),o(document).on("keydown.nice_select",".nice-select",function(e){var t=o(this),s=o(t.find(".focus")||t.find(".list .option.selected"));if(32==e.keyCode||13==e.keyCode)return t.hasClass("open")?s.trigger("click"):t.trigger("click"),!1;if(40==e.keyCode){if(t.hasClass("open")){var i=s.nextAll(".option:not(.disabled)").first();0<i.length&&(t.find(".focus").removeClass("focus"),i.addClass("focus"))}else t.trigger("click");return!1}if(38==e.keyCode){if(t.hasClass("open")){var n=s.prevAll(".option:not(.disabled)").first();0<n.length&&(t.find(".focus").removeClass("focus"),n.addClass("focus"))}else t.trigger("click");return!1}if(27==e.keyCode)t.hasClass("open")&&t.trigger("click");else if(9==e.keyCode&&t.hasClass("open"))return!1});var t=document.createElement("a").style;return t.cssText="pointer-events:auto","auto"!==t.pointerEvents&&o("html").addClass("no-csspointerevents"),this},o(".region-content select:not([multiple])").niceSelect()},init:function(){this.beneMobile(),this.formCleanup(),this.messageDismiss(),this.showHideTabs(),this.beneHero(),this.beneNiceSelect()}};s.init(),o(window).resize(function(){clearTimeout(window.resizedFinished),window.resizedFinished=setTimeout(function(){s.beneMobile()},250)})}}},{}]},{},[1]);
