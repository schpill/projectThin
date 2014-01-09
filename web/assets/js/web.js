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
