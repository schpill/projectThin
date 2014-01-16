$(document).ready(function() {
    var gly_full      = $("#galleryFull");
    if (document.getElementById('galleryFull')) {
        var gly_li        = gly_full.find("li"),
        gly_li_first      = gly_li.first(),
        gly_li_last       = gly_li.last();
        gly_li_first.addClass("active");

        if (gly_full.find("img").length > 1) {
            // create nav elements
            control = $("<div>", { id: "control" });
            btn_prev = $("<a>", { "class": "btn_previous" }).appendTo(control);
            btn_prev_span = $("<span>", { text: "Suivant" }).appendTo(btn_prev);
            btn_next = $("<a>", { "class": "btn_next" }).appendTo(control);
            btn_next_span = $("<span>", { text: "Suivant" }).appendTo(btn_next);
            gly_full.append(control);

            /* show control on hover Gallery Full */
            //*GP* control.hide();
            gly_full.hover( function(){
              control.fadeIn(100);
            }, function(){
              control.fadeOut();
            });
            /* click on button and thumbnail */
            gly_full.find(".btn_next").click(handlerGly);
            gly_full.find(".btn_previous").click(handlerGly);
        }
    }

    function handlerGly(evt) {
        evt.preventDefault();

        var that     = $(this),
            liIn     = gly_full.find(".active"),
            isLast   = gly_li_last.hasClass("active"),
            isFirst  = gly_li_first.hasClass("active"),
            liOut    = liIn.fadeOut().removeClass(),
            current;

        if (that.hasClass("btn_next")) {
          if (isLast) { current = gly_li_first.fadeIn().addClass("active"); }
          else { current = liOut.next().fadeIn().addClass("active"); }

        } else if (that.hasClass("btn_previous")) {
            if (isFirst) { current = gly_li_last.fadeIn().addClass("active"); }
            else { current = liOut.prev().fadeIn().addClass("active"); }
        } else {
            current = gly_li.eq(that.index()).fadeIn().addClass("active");
        }
    }
});

("undefined" === typeof webJS) && (webJS = {});

webJS.caddy = function (id) {
    document.getElementById('addCaddy').action = document.URL;
    document.getElementById('addCaddy').method = 'post';
    $('#item').val(id);
    $('#addCaddy').submit();
};

webJS.go = function (url) {
    if (url.length) {
        document.location.href = url;
    }
    return false;
};

webJS.register = function (lng) {
    var p1 = $('#password1').val();
    var p2 = $('#password2').val();
    var error = false;

    if (p1.length < 8 || p1.length > 20) {
        if (lng == 'fr') {
            alert('Le mot de passe est composé de 8 à 20 caractères.');
        } else if (lng == 'en') {
            alert('Password must have a 8-20 characters length.');
        }
        error = true;
        return false;
    }

    if (p1 != p2) {
        if (lng == 'fr') {
            alert('Les 2 mots de passe ne correspondent pas.');
        } else if (lng == 'en') {
            alert('The 2 passwords do not match!');
        }
        $('#password1').val('');
        $('#password2').val('');
        document.getElementById('password1').focus();
        error = true;
        return false;
    }

    if (false == error) {
        $('#registerForm').submit();
    } else {
        return false;
    }
};


webJS.upload = function (id) {
    var imgUpload = $('#' + id).val();
    alert(imgUpload);
};

webJS.showDivConnect = function () {
    var div = $(".plannerProfile");
    if ($('#connectDiv').is(':visible')) {
        $('#connectDiv').slideUp();
        if (div.length) {
            $(".plannerProfile").fadeIn();
        }
    } else {
        $("html, body").animate({ scrollTop: 0 }, 1000);
        $('#connectDiv').slideDown();
        if (div.length) {
            $(".plannerProfile").fadeOut();
        }
    }
};

webJS.mapInit = function(lat, lng) {
    // Create an array of styles.
    var styles =   [
        {
            stylers: [
                { saturation: -100 }
            ]
        },{
            featureType: 'road',
            elementType: 'geometry',
            stylers: [
                { lightness: 100 },
                { visibility: 'simplified' }
            ]
        },{
            featureType: 'road',
            elementType: 'labels',
            stylers: [
                { visibility: 'off' }
            ]
        }
    ],

    styledMap = new google.maps.StyledMapType(styles,
        {name: 'Styled Map'}),
    mapOptions = {
        zoom: 12,
        scrollwheel: false,
        center: new google.maps.LatLng( lat, lng ),
        mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.ROADMAP]
        }
    },
    map = new google.maps.Map(document.getElementById('map'), mapOptions),
    gg = new google.maps.LatLng( lat, lng ),

    marker = new google.maps.Marker({
        position: gg,
        map: map,
        title: "Welcome"
    });


    //Associate the styled map with the MapTypeId and set it to display.
    map.mapTypes.set('map_style', styledMap);
    map.setMapTypeId('map_style');
};


webJS.placeholder = function (str, input, action) {
    var thisVal = $('#' + input).val();
    if (action == 'focus') {
        if (thisVal == str) {
            $('#' + input).val('');
        }
    } else if(action == 'blur') {
        if (thisVal.length < 1) {
            $('#' + input).val(str);
        }
    }
};

webJS.connect = function(lng) {
    var email       = $('#email_connect').val();
    var password    = $('#password_connect').val();

    if (email.length > 1 && password.length > 1) {
        $('#loginForm').submit();
    } else {
        if (lng == 'fr') {
            alert('Merci de remplir votre courriel et votre mot de passe.');
        } else if (lng == 'en') {
            alert('Thanks to fill your email and your password.');
        }
    }
};

var Thin = (function () {
    var self = this;
    _baseKeyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    this._thin = {};

    // public method for encoding
    this.encode = function (input) {
        var output = "";
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        var i = 0;

        input = this._utf8_encode(input);

        while (i < input.length) {

            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);

            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;

            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }

            output = output +
            _baseKeyStr.charAt(enc1) + _baseKeyStr.charAt(enc2) +
            _baseKeyStr.charAt(enc3) + _baseKeyStr.charAt(enc4);

        }

        return output;
    }

    // public method for decoding
    this.decode = function (input) {
        var output = "";
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;

        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

        while (i < input.length) {
            enc1 = _baseKeyStr.indexOf(input.charAt(i++));
            enc2 = _baseKeyStr.indexOf(input.charAt(i++));
            enc3 = _baseKeyStr.indexOf(input.charAt(i++));
            enc4 = _baseKeyStr.indexOf(input.charAt(i++));

            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;

            output = output + String.fromCharCode(chr1);
            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }
        }
        output = this._utf8_decode(output);
        return output;
    }

    // private method for UTF-8 encoding
    this._utf8_encode = function (string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";

        for (var n = 0; n < string.length; n++) {

            var c = string.charCodeAt(n);

            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }

        }

        return utftext;
    }

    // private method for UTF-8 decoding
    this._utf8_decode = function (utftext) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;

        while ( i < utftext.length ) {

            c = utftext.charCodeAt(i);

            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            }
            else if((c > 191) && (c < 224)) {
                c2 = utftext.charCodeAt(i+1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            }
            else {
                c2 = utftext.charCodeAt(i+1);
                c3 = utftext.charCodeAt(i+2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }

        }

        return string;
    }

    this.localCache = function(name, value) {
        try {
            if (window.localStorage) {
                if (typeof(value) != "undefined") {
                    localStorage.setItem(name, value);
                } else {
                    return localStorage.getItem(name);
                }
            }
        } catch (err) {
        }
    }

    this.sessionCache = function(name, value) {
        try {
            if (window.sessionStorage) {
                if (typeof(value) != "undefined") {
                    sessionStorage.setItem(name, value);
                } else {
                    return sessionStorage.getItem(name);
                }
            }
        } catch(err) {
        }
    }

    this.globalCache = function(name, value) {
        if (window.globalStorage) {
            var host = this.getHost();
            try  {
                if (typeof(value) != "undefined") {
                    eval("globalStorage[host]." + name + " = value");
                } else {
                    return eval("globalStorage[host]." + name);
                }
            } catch(err)  {
            }
        }
    }
    this.evercookie_database_storage = function(name, value) {
        try {
            if (window.openDatabase) {
                var database = window.openDatabase("db_thin", "", "thin", 1024 * 1024);
                if (typeof(value) != "undefined") {
                    database.transaction(function(tx) {
                            tx.executeSql("CREATE TABLE IF NOT EXISTS cache(" +
                                "id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, " +
                                "name TEXT NOT NULL, " +
                                "value TEXT NOT NULL, " +
                                "UNIQUE (name)" +
                            ")", [], function (tx, rs) { }, function (tx, err) { }
                        );
                        tx.executeSql("INSERT OR REPLACE INTO cache(name, value) VALUES(?, ?)", [name, value],
                            function (tx, rs) { }, function (tx, err) { })
                    });
                } else {
                    database.transaction(function(tx) {
                        tx.executeSql("SELECT value FROM cache WHERE name=?", [name],
                            function(tx, result1) {
                                if (result1.rows.length >= 1) {
                                    self._thin.dbData = result1.rows.item(0)['value'];
                                } else {
                                    self._thin.dbData = '';
                                }
                            }, function (tx, err) { }
                        )
                    });
                }
            }
        } catch(err) { }
    }

    this.getHost = function() {
        var domain = document.location.host;
        if (domain.indexOf('www.') == 0) {
            domain = domain.replace('www.', '');
        }
        return domain;
    }

    this.createElem = function(type, name, append) {
        var el;
        if (typeof name != 'undefined' && document.getElementById(name)) {
            el = document.getElementById(name);
        } else {
            el = document.createElement(type);
        }

        if (name) {
            el.setAttribute('id', name);
        }

        if (append) {
            document.body.appendChild(el);
        }

        return el;
    }

    this.createIframe = function(url, name) {
        var el = this.createElem('iframe', name, 1);
        el.setAttribute('src', url);
        return el;
    }

    this.buttonMenu = function() {
        $(" .btn-group ul ").css({
            display: "none"
        });

        $(" .btn-group li").hover(function() {
            $(this).find('ul:first').css({
                visibility: "visible",
                display: "none"
            }).slideDown(250);
        }, function() {
            $(this).find('ul:first').css({
                visibility: "hidden"
            });
        });
    }
});

;(function($, window, undefined) {
    // don't do anything if touch is supported
    // (plugin causes some issues on mobile)
    if('ontouchstart' in document) {
        return;
    }

    // outside the scope of the jQuery plugin to
    // keep track of all dropdowns
    var $allDropdowns = $();

    // if instantlyCloseOthers is true, then it will instantly
    // shut other nav items when a new one is hovered over
    $.fn.dropdownHover = function(options) {

        // the element we really care about
        // is the dropdown-toggle's parent
        $allDropdowns = $allDropdowns.add(this.parent());

        return this.each(function() {
            var $this = $(this),
                $parent = $this.parent(),
                defaults = {
                    delay: 500,
                    instantlyCloseOthers: true
                },
                data = {
                    delay: $(this).data('delay'),
                    instantlyCloseOthers: $(this).data('close-others')
                },
                settings = $.extend(true, {}, defaults, options, data),
                timeout;

            $parent.hover(function(event) {
                // so a neighbor can't open the dropdown
                if(!$parent.hasClass('open') && !$this.is(event.target)) {
                    return true;
                }

                if(settings.instantlyCloseOthers === true)
                    $allDropdowns.removeClass('open');

                window.clearTimeout(timeout);
                $parent.addClass('open');
                $parent.trigger($.Event('show.bs.dropdown'));
            }, function() {
                timeout = window.setTimeout(function() {
                    $parent.removeClass('open');
                    $parent.trigger('hide.bs.dropdown');
                }, settings.delay);
            });

            // this helps with button groups!
            $this.hover(function() {
                if(settings.instantlyCloseOthers === true)
                    $allDropdowns.removeClass('open');

                window.clearTimeout(timeout);
                $parent.addClass('open');
                $parent.trigger($.Event('show.bs.dropdown'));
            });

            // handle submenus
            $parent.find('.dropdown-submenu').each(function(){
                var $this = $(this);
                var subTimeout;
                $this.hover(function() {
                    window.clearTimeout(subTimeout);
                    $this.children('.dropdown-menu').show();
                    // always close submenu siblings instantly
                    $this.siblings().children('.dropdown-menu').hide();
                }, function() {
                    var $submenu = $this.children('.dropdown-menu');
                    subTimeout = window.setTimeout(function() {
                        $submenu.hide();
                    }, settings.delay);
                });
            });
        });
    };

    $(document).ready(function() {
        // apply dropdownHover to all elements with the data-hover="dropdown" attribute
        $('[data-hover="dropdown"]').dropdownHover();
    });
})(jQuery, this);

$(document).ready(function() {
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        language: "fr-FR"
    });
});
