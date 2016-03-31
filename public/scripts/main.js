var app = {};

app.config = {};
app.config.endpoint = 'http://localhost:8001/nestle-coupon-web/trunk/public/';

app.global = {};
app.global.logininfo = '';
app.global.cart = [];
app.global.uuid = '';
app.global.token = '';
app.global.brandFilter = 'All';
app.global.currentSort = 'newDeals';
app.global.currentSortToggleASC = true;

$(function(){

    app.events.click();
    app.language_retrieve();

});

//---------------------------CLICK EVENTS--------------------------------------

app.events = {}
app.events.click = function() {

    //User Sign In
    $('#signIn a').bind('click', function(){
        $('#signInForm').toggleClass('hidden');
        document.getElementById('signInForm').contentWindow.showSignIn();
    });

    //User Profile 
    $('#editProfile a').bind('click', function(){
        $('#signInForm').toggleClass('hidden');
        document.getElementById('signInForm').contentWindow.showEditProfile();
    });

    //User Sign Out
    $('#signOut a').bind('click', function(){
        $('#signInForm').toggleClass('hidden');
        document.getElementById('signInForm').contentWindow.showSignOut();
    });

    //Add Coupon to Cart
    $('#coupons a').bind('click', function(){
        if ($.inArray( $(this).data('coupon'), app.global.cart ) < 0){
            var couponId = $(this).data('coupon');
            var couponList = {coupons: [{offerId : couponId}]};

            app.shoppingcart_create(couponId);

            if (app.global.logininfo != ''){
                app.endpoint_shoppingcart_store(couponList, app.global.uuid);    
            }
        }
    });

    //Sort Coupons
    $('#sort a').bind('click', function(){
        var sortBy = {
            brand : app.global.brandFilter
        };
        $('#sort a').removeClass('selected');
        if ($(this).attr('id') === 'newDeals'){
            sortBy.type = 'newDeals';
            triggerSort(this, sortBy);
        } 
        else if ($(this).attr('id') === 'savings') {
            sortBy.type = 'savings';
            triggerSort(this, sortBy);
        }
        else if ($(this).attr('id') === 'popularDeals') {
            sortBy.type = 'popularDeals';
            triggerSort(this, sortBy);
        }
        function triggerSort(elem, obj){
            $(elem).addClass('selected');
            if (app.global.currentSort == obj.type) {
                app.global.currentSortToggleASC = !app.global.currentSortToggleASC;
            } else {
                app.global.currentSortToggleASC = true;
                app.global.currentSort = obj.type;
            }
            obj.order = (app.global.currentSortToggleASC) ? 'ASC' : 'DESC';
            app.endpoint_coupon_sort(obj);
        }
    });

    //Remove Coupon
    $('#cart').on('click', '.coupon a', function(){
        var couponId = $(this).prev('span').text();
        var couponList = {coupons: [{offerId : couponId}]};
        app.global.cart.splice( $.inArray(parseInt(couponId), app.global.cart), 1 );
        
        $(this).parent('.coupon').remove();
        $.cookie('nestle-coupons-shoppingcart', app.global.cart);

        if (app.global.logininfo != ''){
            app.endpoint_shoppingcart_remove(couponList, app.global.uuid);
        }
    });

    //Print Coupon
    $('#print').bind('click', function(){
        if (app.global.logininfo != ''){
            var printUrl = 'http://consumeraccessapi.smartsource.com:8080/consumeraccessapi/ConsumerAccessHTTPService/PrintService?req=<printServiceRequest><linkId>ABAILP6M3U5DK</linkId>'

            for(var coupon3 in app.global.cart) {
                printUrl += '<offerId>' + app.global.cart[coupon3] + '</offerId>';
            }

            printUrl += '<userEmailId></userEmailId><password></password><consumerId></consumerId></printServiceRequest>';

            app.endpoint_printUrl(printUrl);
        } else {
            alert('Please login to print!');
        }
    });

    //Language Toggle
    $('#setLanguage').bind('click', function(){
        var getLang = $(this).data('language');
        app.language_track(getLang, this);
        app.endpoint_language_set(getLang);
    });

    //Coupon filtering by brands
    $('#filterBrands').on('change',function(){
        app.global.brandFilter = this.value;
        $('#sort a').removeClass('selected');
        $('#newDeals').addClass('selected');
        var sortBy = {
            brand : app.global.brandFilter
        };
        app.endpoint_coupon_sort(sortBy);
    });   

}


//---------------------------FUNCTIONS--------------------------------------

//Initialize when user is logedin
app.loginInit = function(res){
    app.global.logininfo = res;
    app.global.uuid = JSON.parse(localStorage['janrainCaptureProfileData']).uuid;
    app.global.token = res.accessToken;
    var userData = {
        user_id : app.global.uuid,
        access_token : app.global.token
    }
    app.endpoint_user_access(userData, function(){
       app.shoppingcart_session(true); 
    });
}

//Initialize when user is not logedin
app.loginNotFound = function(){
    app.global.logininfo = '';
    app.global.uuid = '';
    app.global.token = '';
    app.shoppingcart_session(false);
}

//Store shopping cart session
app.shoppingcart_session = function(sess){

    //$.cookie('nestle-coupons-shoppingcart', [23961,30585,13849]);

    var couponList = [];
    var currentCart;
    var getcookie = $.cookie('nestle-coupons-shoppingcart');
    var getcoupons = getcookie.split(',');

    $('#coupons a').each(function(){
        couponList.push($(this).data('coupon'));
    });

    if ($('#coupons').length > 0) {
        //Remove coupons that are not active
        if (getcookie){
            for (var cId in getcoupons) {
                if ($.inArray(parseInt(getcoupons[cId]), couponList) == -1) {
                    getcoupons.splice( $.inArray(getcoupons[cId], getcoupons), 1 );
                }
            };
            $.cookie('nestle-coupons-shoppingcart', getcoupons);
            currentCart = getcoupons;
        }

        //Add coupons in shopping to account when logged in or else just create list
        if (sess){
            var couponListAdd = {coupons: []};
            for (var coupon2 in currentCart) {
                couponListAdd.coupons[coupon2] = {};
                couponListAdd.coupons[coupon2].offerId = currentCart[coupon2];
            }
            app.endpoint_shoppingcart_store(couponListAdd, app.global.uuid, function(){
                app.endpoint_shoppingcart_retrieve(app.global.uuid);
            });
            
        } else {
            if (getcookie){
                for (var coupon1 in getcoupons) {
                    app.shoppingcart_create(getcoupons[coupon1]);
                };
            }
        }
    }
}

//Create shopping cart item
app.shoppingcart_create = function(id){
    app.global.cart.push(parseInt(id));
    $('#cart').append('<div class="coupon"><span>' + id + '</span> - <a href="javascript:void(0)" class="remove">X</a><br /></div>');
    $.cookie('nestle-coupons-shoppingcart', app.global.cart);
}

//Create coupon item
app.coupon_create = function(coupons){
    var couponTemplate = $('#template_coupon');
    $('#coupons a').remove();
    for (var coupon in coupons) {
        $('#coupons').append(couponTemplate.html());
        $('#coupons a:last-child .offer_id').html(coupons[coupon].offer_id);
        $('#coupons a:last-child .offer_brand_name').html(coupons[coupon].brand_name);
        $('#coupons a:last-child .offer_category_name').html(coupons[coupon].category_name);
        $('#coupons a:last-child .offer_description').html(coupons[coupon].offer_description);
        $('#coupons a:last-child .offer_head_line').html(coupons[coupon].offer_head_line);
        $('#coupons a:last-child .offer_value').html(coupons[coupon].offer_value);
        $('#coupons a:last-child .offer_image_url').html(coupons[coupon].image_url);
        $('#coupons a:last-child .offer_type_description').html(coupons[coupon].offer_type_description);
        $('#coupons a:last-child').attr('data-coupon', coupons[coupon].offer_id);
    }
}


//Keep track of languages
app.language_track = function(result, elem){
    if (result === 'en'){
        $(elem).data('language', 'fr').html('French');
        $.cookie('nestle-coupons-language', 'en');
    } else {
        $(elem).data('language', 'en').html('English');
        $.cookie('nestle-coupons-language', 'fr');
    }
}

app.language_retrieve = function(){
    if ($.cookie('nestle-coupons-language')) {
        app.language_track($.cookie('nestle-coupons-language'), '#setLanguage');
    } else {
        app.endpoint_language_get();      
    }
}


//---------------------------ENDPOINTS--------------------------------------

//Endpoint - shopping cart store coupon
app.endpoint_shoppingcart_store = function(data, userid, func){
    $.ajax({
        type: 'POST',
        url: app.config.endpoint + 'shoppingcart/' + userid,
        data: data,
        headers: { 'Janrain-Access-Token': app.global.token }
    }).done(function( msg ) {
        //console.log(msg);
        if (func != 'undefined' && msg != 'Error') {
            func();
        }
    });
}

//Endpoint - shopping cart remove coupon
app.endpoint_shoppingcart_remove = function(data, userid){
    $.ajax({
        type: 'DELETE',
        url: app.config.endpoint + 'shoppingcart/' + userid,
        data: data,
        headers: { 'Janrain-Access-Token': app.global.token }
    }).done(function( msg ) {
        //console.log(msg);
    });
}

//Endpoint - shopping cart get coupons
app.endpoint_shoppingcart_retrieve = function(userid){
    $.ajax({
        type: 'GET',
        url: app.config.endpoint + 'shoppingcart/' + userid,
        headers: { 'Janrain-Access-Token': app.global.token }
    }).done(function( result ) {
        $('#cart .coupon').remove();
        for (var cart in result){
            app.shoppingcart_create(result[cart].coupon_id);
            //$('#coupons').find('[data-coupon="' + result[cart].offer_id + '"]').clone().appendTo("#cart .coupon:last-child");
        }
    });
}

//Endpoint - sort coupons
app.endpoint_coupon_sort = function(data){
    $.ajax({
        type: 'POST',
        url: app.config.endpoint + 'coupons',
        data: data
    }).done(function(results) {
        //console.log(results);
        app.coupon_create(results);
    });
}

//Endpoint - get language
app.endpoint_language_get = function(){
    $.ajax({
        type: 'POST',
        url: app.config.endpoint + 'languageGet'
    }).done(function(result) {
        app.language_track(result, '#setLanguage');
    });
}

//Endpoint - set language
app.endpoint_language_set = function(lang){
    $.ajax({
        type: 'POST',
        url: app.config.endpoint + 'languageSet',
        data: {language: lang}
    }).done(function(result) {
        //console.log(result);
        location.reload();
    });
}

//Endpoint - print coupons in shopping cart
app.endpoint_printUrl = function(url){
    $.ajax({
        type: 'POST',
        url: app.config.endpoint + 'print',
        data: {url: url},
        headers: { 'Janrain-Access-Token': app.global.token }
    }).done(function(result) {
        window.open(result);
    });
}

//Endpoint - keep track of user access token
app.endpoint_user_access = function(data, func){
    $.ajax({
        type: 'POST',
        url: app.config.endpoint + 'user',
        data: data
    }).done(function(result) {
        if (result == 1) {
            document.getElementById('signInForm').contentWindow.showSignOut();
        }
        func();
    });
}

