$(document).ready(function () {
    let typingTimer;
    const delay = 400;
    const $input = $('#search-input');
console.log('delay comes here:');
    console.log(delay);
    $input.on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function () {
            let search = $input.val();

            $.ajax({
                url: asset + 'stores',
                type: 'GET',
                data: { search: search },
                success: function (res) {
                    $('#results').html(res.html);
                },
                error: function () {
                    $('#results').html('<h3 class="text-center text-danger py-5">Error fetching results.</h3>');
                }
            });
        }, delay);
    });
});
jQuery(document).ready(function () {


    if (loggedin == 0) {

        let logincheck = localStorage.getItem('authenticated_gift_kingdom')

        if (logincheck != '' && logincheck != null) {

            let data = JSON.parse(logincheck)

            jQuery.ajax({

                url: asset + 'auth-login',

                type: 'POST',

                data: data,

                headers: { 'X-CSRF-TOKEN': token },

                success: function (response) {

                    window.location.href = window.location.href
                }

            })
        }

    }

    jQuery('#checkship').click(function () {

        if (jQuery(this).parents('form').find('.inputhide').val() == '') {

            jQuery(this).parents('form').find('#hotel').css('border-color', 'red')

        }
        else {

            jQuery(this).parents('form').find('#hotel').removeAttr('style')
        }

    })

    jQuery('body').delegate('.read-more', 'click', function () {

        jQuery(this).text().includes('More') ? jQuery(this).text('Read Less') : jQuery(this).text('Read More')
        jQuery(this).siblings('.data-more').toggle()
        jQuery(this).siblings('.data-all').toggle()

    })
    jQuery('body').delegate('.toggle-text', 'click', function () {

        jQuery(this).siblings('p').show()
    })


    jQuery('.loader-main').css('display', 'none');

    var t_products_count = jQuery('.t_products_count').val();

    jQuery('.shop-load').text('LOAD MORE PRODUCTS');

    jQuery(".sec5SliderTop").delegate(".slick-arrow", 'click', function () {

        if (jQuery(this).hasClass('slick-next')) {

            jQuery(this).parents('.main-section').find(".sec5Slider").find('.slick-next').trigger('click')

            jQuery(this).parents('.main-section').find(".sec5Slider").find('.slick-next').click()
        }
        else {

            jQuery(this).parents('.main-section').find(".sec5Slider").find('.slick-prev').trigger('click')

            jQuery(this).parents('.main-section').find(".sec5Slider").find('.slick-prev').click()
        }

    })


    // CSRF Token

    let fpcheck = jQuery(".bday")

    if (jQuery(".date").length != 0) {
        jQuery(".date").flatpickr({ minDate: 'today', dateFormat: 'j F, Y' });
    }
    if (jQuery(".flatpickr").length != 0) {
        jQuery(".flatpickr").flatpickr({ minDate: 'today', dateFormat: 'j F, Y' });
    }
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    if (fpcheck.length != 0) {

const fp = flatpickr('.bday', {
    maxDate: 'today',
    dateFormat: 'Y-m-d',           // backend format
    altInput: true,
    altFormat: 'j F, Y'            // display format
});


        var currYear = new Date().getFullYear();

        var endYear = currYear - 99;

        var yearDropdown = document.createElement("select");

        yearDropdown.className = "year-dropdown";

        jQuery(yearDropdown).attr({ 'style': 'position:absolute;z-index:999999999999999' }).addClass('flatpickr-monthDropdown-months')

        for (var i = currYear; i >= endYear; i--) {
            var option = document.createElement("option");
            option.value = i;
            option.text = i;
            yearDropdown.appendChild(option);
        }

        $(".flatpickr-current-month").append(yearDropdown);

        jQuery('.numInput').change(function () {

            jQuery('.year-dropdown option').each(function () {

                if (jQuery(this).text() == jQuery('.numInput')) {

                    jQuery('.year-dropdown option').removeAttr('selected')

                    jQuery(this).attr('selected', 'true')

                }

            })

        })

        yearDropdown.addEventListener('change', function (evt) {

            setTimeout(function () {

                var year = evt.target.value;

                var cmonth = fp.currentMonth;

                for (var i = currYear; i >= endYear; i--) {

                    if (year > jQuery('.numInput').val()) {

                        if (year != i) { jQuery('.numInput').siblings('.arrowUp').trigger('click') }

                    } else {

                        if (year != i) { jQuery('.numInput').siblings('.arrowDown').trigger('click') }
                    }

                }

                if (year != jQuery('.numInput').val()) {

                    jQuery('.numInput').siblings('.arrowUp').trigger('click')
                }
            })

        }, 500)
    }

    if (register != 'false') {

        jQuery('#signup').modal('toggle');

        jQuery('#signup').find('form').append('<input type="hidden" name="referrer" value="' + register + '">')
    }

    if (login != 'false') {

        jQuery('#signin').modal('toggle');
    }

    jQuery('body').delegate('#brand_search', 'click', function () {

        let str = jQuery(this).siblings('#brand').val()

        let url = asset + 'brandsearch'

        jQuery.ajax({

            url: url,

            type: 'POST',

            data: { keywords: str },

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {

                jQuery('.brands-list').html(response)
            }

        })

    })


    jQuery('#change-addr').click(function () {

        let url = asset + 'get-addresses'

        jQuery.ajax({

            url: url,

            type: 'GET',

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {

                jQuery('#addresses-wrap').html(response)

            }

        })

    })

    jQuery('body').delegate('.change-addr', 'click', function () {

        let text = jQuery(this).find('span').text()

        let index = jQuery(this).attr('data-index')

        jQuery('#change-addr').find('p').text(text).show()

        jQuery('#changeaddr').modal('hide');

        let url = asset + 'set-default-address'

        jQuery.ajax({

            url: url,

            type: 'POST',

            headers: { 'X-CSRF-TOKEN': token },

            data: { index: index },

            success: function (response) {

                jQuery('#addresses-wrap').html(response)

            }

        })

    })


    jQuery('body').delegate('.record-product', 'click', function () {

        let dis = jQuery(this)

        let url = asset + 'search-record'

        jQuery.ajax({

            url: url,

            type: 'POST',

            data: { id: dis.attr('data-id') },

            headers: { 'X-CSRF-TOKEN': token },

        })

    })


jQuery('body').on('click', '.category:not(.slick-cloned) .cat-filter', function () {
    let dis = jQuery(this);
    let val = jQuery('#search').val();
    let cat = dis.attr('data-id');
    let url = asset + 'products/search';

    jQuery.ajax({
        url: url,
        type: 'POST',
        data: { val: val, cat: cat },
        headers: { 'X-CSRF-TOKEN': token },
        success: function (response) {
            console.log('response comes here:', response);

            // replace content
            jQuery('.suggestions').html(response).addClass('active');

            // re-init slick slider
            $('.keywords-slider').slick({
                infinite: true,
                swipeToSlide: true,
                autoplay: false,
                speed: 1000,
                variableWidth: true,
                draggable: true,
                arrows: false,
                dots: false,
                slidesToShow: 4,
                responsive: [
                    { breakpoint: 991, settings: { slidesToShow: 2 } },
                    { breakpoint: 767, settings: { slidesToShow: 1 } }
                ]
            });

            // prevent accessibility warnings on clones
            $('.slick-cloned').attr('tabindex', '-1').css('pointer-events', 'none');
        }
    });
});



    jQuery('#mainMenu').click(function (e) {

        e.stopPropagation()

    })

    jQuery('body').delegate('.delivery_option', 'click', function () {
        let url = asset + 'timeslots'

        let date = jQuery('.delivery-date').val()

        jQuery.ajax({

            url: url,

            type: 'POST',

            data: { val: jQuery(this).val(), date: date },

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {

                jQuery('.time-slots').show().find('.slots').html(response)

                jQuery('.delivery-date').attr('required', 'ture')

                jQuery('#place_order').addClass('cus-disabled').attr('type', 'button')

            }

        })

    })

    jQuery('.area_change').keyup(function () {

        let url = asset + 'check_area'

        let val = jQuery(this).val()

        let opt = jQuery(".delivery_option:checked:enabled").val()

        let = jQuery('input[name="address[emirate]]"').val()

        jQuery.ajax({

            url: url,

            type: 'POST',

            data: { val: val, opt: opt },

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {

            }
        })
    })

    jQuery('body').delegate('#place_order', 'click', function (e) {

        e.preventDefault();



        let pass = true;

        let isLoggedIn = jQuery('body').hasClass('logged-in');

        if (!isLoggedIn) {

let addressForm = jQuery('#address_form .form.mt-4.active');

            console.log('Validating address_form inputs for guest user');

            addressForm.find('input[name^="address["]').each(function (index) {
                let input = jQuery(this);
                let inputName = input.attr('name').trim();
                console.log('input name comes here:');
                console.log(input.val().trim());

                if (inputName === 'address[address-details]') {
                    console.log('Skipping validation for address[address-details]');
                    return true;
                }

                input.next('.error-message').remove();

                if (inputName === 'address[phone]') {
                    let itiWrapper = input.closest('.iti');
                    let invalidDiv = itiWrapper.siblings('.invalid');
                    invalidDiv.empty();

                    if (input.val().trim() === '') {
                        pass = false;
                        input.css('border-color', 'red');

                        console.log('Empty phone field found:', inputName);

                        invalidDiv.html('<svg width="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#ff0000" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"></path></svg> Please enter a valid phone number.');
                    } else {
                        input.css('border-color', '');
                        invalidDiv.empty();
                    }

                } else {
                    if (input.val().trim() === '') {
                        pass = false;
                        input.css('border-color', 'red');

                        console.log('Empty address field found:', inputName);

                        input.after('<p class="error-message text-danger mt-1">This field is required.</p>');
                    } else {
                        input.css('border-color', '');
                    }
                }
            });


        }

        let dis = jQuery('#checkout_form');

        if (dis.find('.ct-slct').length != 0) {

            console.log('Found ct-slct elements:', dis.find('.ct-slct').length);

            dis.find('.ct-slct').each(function (index) {

                if (jQuery(this).find('input[name^="shipping["]').length > 0) {
                    console.log('Skipping ct-slct at index', index, 'because it has shipping input');
                    return;
                }

                let inputhideVal = jQuery(this).find('.inputhide').val();

                console.log('Index:', index,
                    'ct-slct element:', this,
                    '.inputhide value:', inputhideVal);

                if (inputhideVal == '') {
                    console.log("Setting pass to false for ct-slct at index", index);

                    pass = false;

                    jQuery(this).find('button.form-control').attr('style', 'border-color:red !important');
                }
                else {
                    jQuery(this).find('button.form-control').removeAttr('style');
                }

            });
        }

        if (dis.hasClass('cus-disabled')) {
            pass = false;
            console.log("setting pass to false from cus-disabled");
            document.getElementById('validate-slots').scrollIntoView({ inline: 'center', block: 'center' });

            jQuery('#validate-slots').find('button').attr('style', 'border-color:red !important').click();
        }

        let areaInput = dis.find('input[name="address[area]"]');
        let emailInput = dis.find('input[name="address[email]"]');
        console.log('Area input found:', areaInput.length > 0);
        console.log('Email input found:', emailInput.length > 0);

        areaInput.next('.error-message').remove();
        emailInput.next('.error-message').remove();

        if (areaInput.length && areaInput.val().trim() === '') {
            pass = false;
            areaInput.css('border-color', 'red');
            areaInput.after('<p class="error-message text-danger mt-1">Please enter the area for delivery.</p>');
        } else {
            areaInput.css('border-color', '');
        }

        if (emailInput.length && emailInput.val().trim() === '') {
            pass = false;
            emailInput.css('border-color', 'red');
            emailInput.after('<p class="error-message text-danger mt-1">Please enter a valid email address.</p>');
        } else {
            emailInput.css('border-color', '');
        }
if (pass) {
    triggerDeliveryFormSubmit()
        .then(() => {
            console.log("Delivery form(s) submitted successfully. Submitting checkout form.");
            jQuery('#checkout_form').submit();
        })
        .catch(() => {
            console.log("Delivery form submission failed or invalid. Checkout halted.");
        });
}


    });

function triggerDeliveryFormSubmit() {
    return new Promise((resolve, reject) => {
        const triggerBtn = jQuery('.delivery-form-submit');
        let forms;

        if (triggerBtn.closest('.cart-item-new').length) {
            forms = triggerBtn.closest('.cart-item-new').find('form#delivery-form');
        } else {
            forms = jQuery('#delivery-form');
        }

        let pendingAJAX = 0;
        let hasError = false;

        forms.each(function () {
            const form = jQuery(this)[0];
            const formData = new FormData(form);
            let isValid = true;

            jQuery(form).find('.is-invalid').removeClass('is-invalid');
            jQuery(form).find('.invalid-feedback').remove();

            jQuery(form).find('input[required]').each(function () {
                const input = jQuery(this);
                if (!input.val().trim()) {
                    isValid = false;
                    input.addClass('is-invalid');
                    if (!input.next('.invalid-feedback').length) {
                        input.after('<div class="invalid-feedback" style="margin-left: 8px;font-size: 13px;">This field is required.</div>');
                    }
                }
            });

            if (!isValid) {
                hasError = true;
                return;
            }

            let productId = formData.get('product_id');
            let cartItemId = formData.get('cart_item_id');
            let deliveries = {};

            for (let [key, value] of formData.entries()) {
                let match = key.match(/^([a-zA-Z_-]+)-(\d+)$/);
                if (match) {
                    const field = match[1].replace(/-/g, '_');
                    const index = match[2];

                    if (!deliveries[index]) {
                        deliveries[index] = {
                            product_id: productId,
                            cart_item_id: cartItemId
                        };
                    }

                    deliveries[index][field] = value;
                }
            }

            const deliveryArray = Object.values(deliveries);
            pendingAJAX++;

            jQuery.ajax({
                url: asset + 'save-cart-item-addresses',
                method: 'POST',
                data: JSON.stringify({ deliveries: deliveryArray }),
                headers: { 'X-CSRF-TOKEN': token },
                contentType: 'application/json',
                success: function (res) {
                    const responseContainer = jQuery(form).find('.response');
                    if (res.status === 'success') {
                        responseContainer.html('<p class="my-2" style="color:#2D3C0A;">' + res.message + '</p>').addClass('active');
                    } else {
                        responseContainer.html('<p class="my-2 text-danger">' + res.message + '</p>').addClass('active');
                        hasError = true;
                    }
                },
                error: function () {
                    hasError = true;
                },
                complete: function () {
                    pendingAJAX--;
                    if (pendingAJAX === 0) {
                        if (hasError) {
                            reject();
                        } else {
                            resolve();
                        }
                    }
                }
            });
        });

        // If no forms processed (edge case)
        if (forms.length === 0) resolve();
    });
}


    jQuery('body').delegate('.change-slot', 'click', function () {

        let url = asset + 'slotprice'

        let val = jQuery(this).attr('data-value')

        let opt = jQuery(".delivery_option:checked:enabled").val()

        let price = jQuery('input[name="order-total"]').val()
if(price == '0'){
            price = jQuery('input[name="order-subtotal"]').val()
}
        if (val == '000000000') {

            jQuery('#place_order').addClass('cus-disabled').attr('type', 'button')

        } else {

            jQuery('#place_order').removeClass('cus-disabled').attr('type', 'submit')

            jQuery('#validate-slots').find('button').removeAttr('style')

        }

        jQuery.ajax({

            url: url,

            type: 'POST',

            data: { val: val, opt: opt, price: price },

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {

                url = asset + 'update-checkout'

                jQuery.ajax({

                    url: url,

                    type: 'POST',

                    data: { shipping: response },

                    headers: { 'X-CSRF-TOKEN': token },

                    success: function (response) {

                        jQuery('.checkout-summary').html(response)

                    }

                })

            }

        })

    })


jQuery('body').delegate('.delivery-date', 'change', function () {
    let url = asset + 'timeslots';
    let val = jQuery(".delivery_option:checked:enabled").val();

    let date = jQuery(this).val();
    let data_validate_slots = jQuery(this).attr('data-validate-slots') ?? null;

    // check context
    let cartItem = jQuery(this).closest('.cart-item-new');
    let multipleCartItems = jQuery('.cart-item-new').length > 1;

    jQuery.ajax({
        url: url,
        type: 'POST',
        data: { val: val, date: date, data_validate_slots: data_validate_slots },
        headers: { 'X-CSRF-TOKEN': token },

        success: function (response) {
            if (
                cartItem.length &&              // inside cart-item-new
                multipleCartItems &&            // more than 1 cart-item-new
                data_validate_slots             // has slot identifier
            ) {
                cartItem.find('.slots-' + data_validate_slots)
                    .closest('.time-slots')
                    .show()
                    .find('.slots-' + data_validate_slots)
                    .html(response);
            } else {
                if (data_validate_slots !== undefined && data_validate_slots !== null && data_validate_slots !== '') {
                    jQuery('.slots-' + data_validate_slots)
                        .closest('.time-slots')
                        .show()
                        .find('.slots-' + data_validate_slots)
                        .html(response);
                } else {
                    jQuery('.time-slots').show().find('.slots').html(response);
                }
            }
        }
    });
});



    jQuery('body').delegate('.track-shipment', 'click', function () {

        let id = jQuery(this).attr('ship-id')

        let url = asset + 'track-shipment'

        jQuery.ajax({

            url: url,

            type: 'POST',

            data: { id: id },

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {

                jQuery('#shipment').find('.shipment-data').replaceWith(response)

                jQuery('#shipment').modal('show')

            }

        })
    })

    jQuery('.btn.cancel-refund').click(function () {
        let parent = jQuery('#refund')

        if (jQuery(this).hasClass('cancel')) {

            parent.find('.refund').hide()

            parent.find('input[name="status"]').val('Cancel Requested')

        }
        else {

            parent.find('.cancel').hide()

            parent.find('input[name="status"]').val('Refund Requested')
        }

    })

    jQuery('.copy-share').click(function () {

        navigator.clipboard.writeText(jQuery(this).siblings('input').val())

        jQuery(this).attr('title', 'Copied!');
    })

    jQuery('#buynow').click(function () {

        setTimeout(function () {

            window.location.href = asset + 'checkout'

        }, 2000)

    })


    jQuery('body').delegate('.social-share a', 'click', function () {

        let type = jQuery(this).attr('type')

        let url = asset + '/social-share'

        jQuery.ajax({

            url: url,

            type: 'POST',

            data: { type: type },

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {

                // alert('These points will be credited after 24 hours')
            }

        })
    })

    jQuery('body').delegate('.edit-email', 'click', function () {

        jQuery(this).removeClass('edit-email')
        jQuery(this).addClass('save-email')
        jQuery(this).text('Save')
        jQuery('.careerFilter input[type="email"]').removeAttr('readonly')
        jQuery('.careerFilter input[type="email"]').trigger('focus')

    })

    jQuery('body').delegate('.save-email', 'click', function () {

        jQuery(this).removeClass('save-email')
        jQuery(this).addClass('edit-email')
        jQuery(this).text('Edit')
        jQuery('.careerFilter input[type="email"]').attr('readonly', 'true')

    })

    jQuery('#editprofile,#changepass').click(function () {

        jQuery('.profile,.password-el').toggle()

    })

    jQuery('body').delegate('.cart-select', 'click', function () {

        let data = {}

        data['id'] = jQuery(this).val()

        let url = asset + 'cart/moveitemtoorder'

        if (jQuery(this).is(':checked')) {

            data['in_order'] = 1

        }
        else {

            data['in_order'] = 0

            if (jQuery('#selectAll').is(':checked')) {

                jQuery('#selectAll').prop('checked', false)

            }
        }

        jQuery.ajax({

            url: url,

            type: 'POST',

            data: data,

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {

                updateCartCount()

                updateCart()

                let count = 0

                jQuery('.cart-item').each(function (index) {

                    if (jQuery(this).find('.cart-select').is(':checked')) {

                        count++
                    }

                })

                if (count == jQuery('.cart-item').length) {

                    jQuery('#selectAll').prop('checked', true)

                }

                if (count == 0) {

                    jQuery('button[type="submit"]').attr('disabled', 'true')
                } else {
                    jQuery('button[type="submit"]').removeAttr('disabled')
                }
            }

        })

    })

    // Add to Cart Listing
    jQuery('body').delegate('.add-to-cart', 'click', function () {

        let id = jQuery(this).attr('data-product')

        let url = asset + 'cart/add'

        jQuery.ajax({

            url: url,

            type: 'POST',

            data: { ID: id, qty: 1 },

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {

                cartNotification(response)

                updateCartCount()
            }

        })

    })


    jQuery(document).ready(function () {
        const reorderBtn = jQuery('.reorder-to-cart');

        function toggleReorderButton() {
            const anyChecked = jQuery('.order-his-check:checked').length > 0;
            reorderBtn.prop('disabled', !anyChecked);
        }

        toggleReorderButton();

        jQuery('body').on('change', '.order-his-check', function () {
            toggleReorderButton();
        });

        jQuery('body').delegate('.reorder-to-cart', 'click', function () {
            const url = asset + 'reorder-cart';

            const items = [];

            jQuery('.order-his-check:checked').each(function () {
                const checkbox = this;

                const item = {
                    ID: checkbox.dataset.productId,
                    qty: checkbox.dataset.productQty,
                    variation: checkbox.dataset.variation,
                    attributes: {
                        values: {}
                    }
                };
                for (const dataAttr in checkbox.dataset) {
                    if (['productId', 'productQty', 'variation'].includes(dataAttr)) continue;

                    let attrKey = dataAttr;

                    if (dataAttr === 'specialPackaging') {
                        attrKey = 'special-packaging';
                    } else if (dataAttr === 'personal-message') {
                        attrKey = 'personal-message';
                    }

                    item.attributes.values[attrKey] = checkbox.dataset[dataAttr];
                }

                items.push(item);
                jQuery(checkbox).prop('checked', false);
            });

            reorderBtn.prop('disabled', true);

            jQuery.ajax({
                url: url,
                type: 'POST',
                data: JSON.stringify({ items }),
                contentType: 'application/json',
                headers: { 'X-CSRF-TOKEN': token },
                success: function (response) {
                    cartNotification(response);
                    updateCartCount();
                    toggleReorderButton();
                },
                error: function (xhr) {
                    console.error('Error:', xhr.responseText);
                    toggleReorderButton();
                }
            });
        });
    });





    jQuery('body').delegate('.empty-wishlist', 'click', function () {

        let url = asset + 'wishlist/empty'

        jQuery.ajax({

            url: url,

            type: 'POST',

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {

                setTimeout(function () {

                    window.location.href = window.location.href

                }, 1000)

            }

        })

    })

    jQuery('body').delegate('.check-to-add', 'click touchstart', function () {

        let count = 0

        jQuery('.check-to-add').each(function () {

            jQuery(this).is(':checked') ? count++ : ''

        })

        console.log(count)

        count != 0 ? jQuery('.add-to-cart-multi').show() : jQuery('.add-to-cart-multi').hide()

    })

    jQuery('body').delegate('.add-to-cart-multi', 'click', function () {

        jQuery(this).hide()

        let url = asset + 'wishlist/add-cart'

        let dis

        let val

        jQuery('.check-to-add').each(function () {

            if (jQuery(this).is(':checked')) {

                dis = jQuery(this)

                val = jQuery(this).val()

                jQuery(this).prop('checked', false)

                jQuery.ajax({

                    url: url,

                    type: 'POST',

                    data: { id: val },

                    headers: { 'X-CSRF-TOKEN': token },

                    success: function (response) {

                        updateCartCount()

                        jQuery('.wishlist-icon small').text(jQuery('.wishlist-list .cart-item').length)

                        if (jQuery('.cart-body').find('.cart-item').length == 0) {

                            window.location.href = window.location.href

                        }
                    }

                })


            }
        })

        jQuery('#wishlist-notification').find('.notification p').text('Items added to cart successfully!')

        jQuery('#wishlist-notification').addClass('active')

        setTimeout(function () {

            jQuery('#wishlist-notification').removeClass('active')

        }, 2000)
    })


jQuery('body').delegate('.add-to-cart-wishlist', 'click', function () {

	let dis = jQuery(this);
	let id = dis.attr('data-id');
	let url = asset + 'wishlist/add-cart';
let container = dis.parents('.cart-item');
let productName = container.find('h5.text-capitalize').text().trim();
let variants = container.find('p.text-capitalize').text().trim();

let name = `${productName} - ${variants}`;
	jQuery.ajax({
		url: url,
		type: 'POST',
		data: { id: id },
		headers: { 'X-CSRF-TOKEN': token },
		success: function (response) {

			let message = '';

			if (response.status === 'exists') {
				message = name + ' ' + ' is already in your cart.';
			} else {
				message = name + ' ' + ' added to cart successfully!';
				updateCartCount();
			}

			jQuery('#wishlist-notification').find('.notification p').text(message);
			jQuery('#wishlist-notification').addClass('active');

			setTimeout(function () {
				jQuery('#wishlist-notification').removeClass('active');

				if (dis.parents('.cart-item').length == 0) {
					window.location.href = window.location.href;
				}
			}, 1000);
		}
	});
});


    jQuery('#selectAll,#AddToCartAll').click(function (e) {

        jQuery('.cart-item .form-check-input').prop('checked', true)

        if (jQuery(this).attr('id') == 'AddToCartAll') {

            let url = asset + 'wishlist/add-cart'

            jQuery.ajax({

                url: url,

                type: 'POST',

                headers: { 'X-CSRF-TOKEN': token },

                success: function (response) {

                    updateCartCount()

                    jQuery('#wishlist-notification').find('.notification p').text('Items added to cart successfully!')

                    jQuery('#wishlist-notification').addClass('active')

                    setTimeout(function () {

                        jQuery('#wishlist-notification').removeClass('active')

                        jQuery('.check-to-add').prop('checked', false)

                    }, 1000)


                }

            })

        }
        else {

            jQuery('.cart-item').each(function () {

                let url = asset + 'cart/moveitemtoorder'

                let data = {}

                data['id'] = jQuery(this).find('.cart-select').val()
                data['in_order'] = 1

                jQuery.ajax({

                    url: url,

                    type: 'POST',

                    data: data,

                    headers: { 'X-CSRF-TOKEN': token },

                    success: function (response) {

                        updateCartCount()

                        updateCart()

                        jQuery('button[type="submit"]').removeAttr('disabled')

                    }

                })

            })
        }

    })


    let varcheck = jQuery('.var-attribute')

    console.log(varcheck.length)

    if (varcheck.length != 0) {

        setTimeout(function () {

            if (jQuery('.color-family.var-attribute').length != 0) {

                jQuery('.var-attribute.color-family').find('input').first().trigger('click')
                jQuery('.var-attribute.color-family').find('input').first().click()

            }
            else {

                jQuery('.var-attribute').find('input').first().trigger('click')
                jQuery('.var-attribute').find('input').first().click()

            }

        }, 1000)

    }
    // Variations Product Detail

    jQuery('body').delegate('.var-attribute input', 'click', function () {

        let dis = jQuery(this);
        let product = '';

        if (jQuery('#productID').length > 0) {
            product = jQuery('#productID').val();
        } else {
            product = dis.closest('.var-attribute').siblings('.prod_id').val();
        }

        dis.parents('.var-attribute').find('input').removeClass('active')

        if (dis.parents('.var-attribute').hasClass('color-family')) {

            if (dis.parents('.var-attribute').find('h5').find('strong').length == 0) {

                dis.parents('.var-attribute').find('h5').append('<strong>: ' + dis.parents('.img-btn').attr('title') + '</strong>')

            }
            else {


                dis.parents('.var-attribute').find('h5').find('strong').text(': ' + dis.parents('.img-btn').attr('title'))

            }

        }

        dis.addClass('active')

        let data = {}

        jQuery('.var-attribute').each(function () {

            attr = jQuery(this).attr('data-attr')

            data[attr] = jQuery(this).find('input.active').val()

        })

        data['product'] = product

        data['attr'] = dis.parents('.var-attribute').attr('data-attr')

        data['val'] = dis.val()

        let url = asset + 'variation/relations'

        jQuery.ajax({

            url: url,

            type: 'POST',

            data: data,

            headers: { 'X-CSRF-TOKEN': token },

            success: function (json) {

                json = JSON.parse(json)

                let available = json.available

                jQuery('.var-attribute').each(function () {

                    if (jQuery(this).attr('data-attr') != data['attr']) {

                        jQuery(this).find('input').each(function () {

                            available.includes(parseInt(jQuery(this).val())) ? jQuery(this).parents('.img-btn').addClass('available') : jQuery(this).parents('.img-btn').addClass('not-available')

                            !available.includes(parseInt(jQuery(this).val())) ? jQuery(this).prop('checked', false) : ''//jQuery(this).click()

                            available.includes(parseInt(jQuery(this).val())) ? jQuery(this).parents('.img-btn').removeClass('not-available') : jQuery(this).parents('.img-btn').removeClass('available')

                            available.includes(parseInt(jQuery(this).val())) ? jQuery(this).removeAttr('disabled') : jQuery(this).attr('disabled', 'true')

                        })

                    }

                })

                if (json.relations != undefined) {

                    json = json.relations

                }

                if (json.no_variation != undefined) {

                    jQuery('.stock').attr('style', 'background-color:red !important').text('NOT AVAILABLE')

                    jQuery('button[type="submit"],#tradein').attr('disabled', true)

    $('h5:contains("Additional Information")').addClass('d-none');
    $('.js-add-class').addClass('d-none').html(''); // also clear the description
                }
                else {
                    console.log('prod_title comes here:');
console.log(json.prod_title);
                    jQuery('.prod_title').text(json.prod_title)
                    jQuery('#variationID').val(json.ID)
                    if (jQuery('.whishlist-btn')) {

                        jQuery('.whishlist-btn').attr('data-var_id', json.ID)
                    } else {
                    }
                    jQuery('#qty').attr('max', json.prod_quantity)

                    jQuery('.rating_count').text(json.review.rating + '/5');
                    jQuery('.review_count').text(json.review.count);

                    jQuery('.review_comments').html(json.review_comments);

                    const rating_star = json.review.rating;

                    jQuery('.rating_count').text(rating_star + '/5');

                    jQuery('.rating_star').each(function () {
                        const starValue = parseInt(jQuery(this).val(), 10);
                        const label = jQuery(`label[for="${jQuery(this).attr('id')}"]`);

                        if (starValue <= rating_star) {
                            label.css('color', '#FFBC11');
                        } else {
                            label.css('color', '');
                        }
                    });

                    let pricehml = '';
   var locale = 'ae';
                    var options = { minimumFractionDigits: 2, maximumFractionDigits: 2 };
                    var formatter = new Intl.NumberFormat(locale, options);
          if (
    json.sale_price != json.prod_price &&
    json.sale_price != null &&
    json.sale_price != 0
) {
    let pricehml = `
        <div class="d-flex align-items-center gap-3">
            <h4>
                <i><i class="sale_price">${json.symbol} ${formatter.format(json.sale_price)}</i></i>
                <del><i class="prod_price">${json.symbol} ${formatter.format(json.prod_price)}</i></del>
            </h4>
            <h6><span class="badge bg-danger text-white">${json.discount}% off</span></h6>
        </div>`;

    jQuery('.pro-price').html(pricehml);
} else {
    jQuery('.pro-price').html(`
        <div class="d-flex align-items-center gap-3">
            <h4><i><i class="sale_price">${json.symbol} ${formatter.format(json.prod_price)}</i></i></h4>
        </div>
    `);
}



                    if (json.prod_quantity == 0) {

                        jQuery('.stock').attr('style', 'background-color:red !important').text('OUT OF STOCK')
                        jQuery('button[type="submit"]').attr('disabled', true)
                    }
                    else {

                        jQuery('.stock').removeAttr('style').text('IN STOCK')
                        jQuery('button[type="submit"]').removeAttr('disabled')

                    }

if (json.prod_description && json.prod_description.trim() !== '') {

    $('.js-prod-description-heading').removeClass('d-none');
    $('.js-prod-description-content').removeClass('d-none').html(json.prod_description);
}
if (json.prod_description && json.prod_description.trim() !== '') {

    $('.js-additional-info-heading').removeClass('d-none');
    $('.js-additional-info-content').removeClass('d-none').html(json.prod_description);
}
if (json.prod_features && json.prod_features.trim() !== '') {

    $('.js-prod-features-heading').removeClass('d-none');
    $('.js-prod-features-content').removeClass('d-none').html(json.prod_features);
}
                    jQuery('.prod_image[prod-id="' + product + '"]').find('img').attr('src', json.prod_image);

// Clear previous slider completely
jQuery('.pro-slider').slick('unslick');
jQuery('.pro-slider-thumb').slick('unslick');

jQuery('.pro-slider').empty();
jQuery('.pro-slider-thumb').empty();

// Append main image only once
if (json.prod_image && json.prod_image !== 'https://v5.digitalsetgo.com/gift-kingdom-v2/public/' && json.prod_image !== 'https://v5.digitalsetgo.com/gift-kingdom/public/') {
    jQuery('.pro-slider').append(`
        <div class="sliderInr">
            <a href="${json.prod_image}" data-src="${json.prod_image}" data-touch="false" data-fancybox="gallery">
                <figure><img class="prod_imgs" src="${json.prod_image}" alt="*" class="w-100 mx-auto"></figure>
            </a>
        </div>
    `);

    jQuery('.pro-slider-thumb').append(`
        <a href="javascript:;" class="gallery">
            <figure><img class="prod_img" src="${json.prod_image}" alt="*" style="height: 4.375rem;"></figure>
        </a>
    `);
}

// Append gallery images if any
if (Array.isArray(json.prod_images)) {
    json.prod_images.forEach(function (imgUrl) {
        if (imgUrl && imgUrl !== 'https://v5.digitalsetgo.com/gift-kingdom-v2/public/' && imgUrl !== 'https://v5.digitalsetgo.com/gift-kingdom/public/' && imgUrl !== json.prod_image) {
            jQuery('.pro-slider').append(`
                <div class="sliderInr">
                    <a href="${imgUrl}" data-touch="false" data-src="${imgUrl}" data-fancybox="gallery">
                        <figure><img class="prod_imgs" src="${imgUrl}" alt="*" class="w-100 mx-auto"></figure>
                    </a>
                </div>
            `);

            jQuery('.pro-slider-thumb').append(`
                <a href="javascript:;" class="gallery">
                    <figure><img class="prod_img" src="${imgUrl}" alt="*" style="height: 4.375rem;"></figure>
                </a>
            `);
        }
    });
}

// Re-initialize slick
jQuery('.pro-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: true,
    infinite: true,
    arrows: false,
    autoplay: true,
    speed: 1000,
    swipeToSlide: true,
    asNavFor: '.pro-slider-thumb',rtl: $('html').attr('dir') === 'rtl',
});

jQuery('.pro-slider-thumb').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.pro-slider',
    speed: 0,
    dots: false,
    centerPadding: 0,
    centerMode: true,
    focusOnSelect: true,
    arrows: true,
    variableWidth: true,
    swipeToSlide: true,
    infinite: true,
    cssEase: 'linear',rtl: $('html').attr('dir') === 'rtl',
    prevArrow: '<a href="javascript:;" class="slick-arrow slick-prev"><svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.5752 16.8L1.1002 9.32499L8.5752 1.84999" stroke="#080F22" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>',
    nextArrow: '<a href="javascript:;" class="slick-arrow slick-next"><svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.1001 1.84998L8.5751 9.32498L1.1001 16.8" stroke="#080F22" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>',
    responsive: [
        { breakpoint: 992, settings: { slidesToShow: 2 } },
    ]
});

                }

            }

        })

    })

    // Product Detail Comments

    jQuery('body').delegate('.ask-question', 'click', function () {

        jQuery('.comment-form').toggle()

        jQuery(this).toggle()

    })

    // Thumbnail

    jQuery('.thumbnail').change(function () {

        let dis = jQuery(this)

        let data = new FormData

        data.append('file', dis[0].files[0])

        jQuery.ajax({

            url: asset + 'uploadfile',

            type: 'POST',

            data: data,

            cache: false,

            processData: false,

            contentType: false,

        }).done(function (response) {

            response = JSON.parse(response)

            jQuery('.fileupload').css('background-image', 'url(' + response.url + ')')

            jQuery('.fileupload figcaption').hide()

            jQuery('.fileupload').append('<input type="hidden" name="thumbnail" value="' + response.id + '">')

        })


    })

    // List Grid View

    jQuery('.list-grid a').click(function () {

        jQuery('.list-grid a').removeClass('active')

        jQuery(this).addClass('active')

        let type = jQuery(this).attr('type')

        if (type.includes('List')) {

            jQuery('#results').addClass('list')

            jQuery('.wrap').removeClass('col-xl-4').addClass('col-sm-12')

        }
        else {

            jQuery('#results').removeClass('list')
            jQuery('.wrap').addClass('col-xl-4').removeClass('col-sm-12')

        }
    })

    let slide1 = 0
    let slide2 = 0

    jQuery('body').delegate('#range', 'click', function () {

        jQuery('#filterform').find('.filterrating').val(jQuery(this).val())

        jQuery(this).siblings('.filter-item').trigger('click')
    })

    // Filter

    jQuery('body').on('click', '.btn-close', function () {
        jQuery('.modal').removeClass('show')
        jQuery('.modal').css('display', 'none')
        jQuery('body').removeClass('modal-open')
        jQuery('body').attr('style', '')
        jQuery('.modal-backdrop').removeClass('show')
        jQuery('#cart-notification').removeClass('active')
        jQuery('#wishlist-notification').removeClass('active')

    })

    setTimeout(function () { jQuery('.msg_alert').addClass('d-none'); }, 2000)


    jQuery('body').delegate('.clear-filter', 'click', function () {

        jQuery('#filterform').find('input').val('')
        let activeSort = jQuery('.filter-item[data-type="sort"].active');

        let sortValue = activeSort.length > 0 ? activeSort.data('value') : 'default';
        jQuery('#filterform').find('.sort').val(sortValue)

        jQuery('.filter-item').removeClass('active')

        jQuery('.filter-item').prop('checked', false)

        jQuery(this).siblings('.filter-item').trigger('click')
    })

    jQuery('body').delegate('.filter-item', 'click', function () {

        jQuery(this).parents('.accordion-item').find('input').prop('checked', false)

        jQuery(this).prop('checked', true)

        jQuery(this).parents('.accordion-item').find('.filter-item').removeClass('active')

        jQuery(this).addClass('active')

        jQuery('.shop-load').attr('offset', 0)

        jQuery('.loader-main').css('display', 'flex');

        if (jQuery(this).parents('.offcanvas').length != 0) {

            jQuery('.offcanvas button.btn-close').trigger('click')
        }

        let type = jQuery(this).attr('data-type')

        let val = ''

        val = jQuery(this).attr('data-value')

        if (type == 'attribute') {

            let attr = jQuery(this).attr('data-attr')

            jQuery('#filterform').find('#attr_' + attr).val(val)

        }



        if (type == 'brand') {

            let brandarr = []

            jQuery('#filter').find('.brands-list').find('.filter-item').each(function () {

                if (jQuery(this).is(':checked')) {

                    brandarr.push(jQuery(this).data('value'))

                }
            })

            val = JSON.stringify(brandarr)
        }


        jQuery('#filterform').find('.' + type).val(val)

        jQuery('#filterform').find('.lastactive').val(type)
        let data = new FormData(jQuery('#filterform')[0]);

        if (type == 'clear') {
            if (window.location.href.includes('category/')) {
                const filterForm = jQuery('#filterform')[0];
                let oldData = new FormData(filterForm);
                let newData = new FormData();

                for (let [key, value] of oldData.entries()) {
                    if (key !== 'filter[category]') {
                        newData.append(key, value);
                    }
                }
                catId = jQuery(this).attr('data-value-category-id');
                newData.append('filter[category]', catId || '');
                data = newData;
            }
        }

        if (type == 'sort' && val == 'default' || val == 'best-sellers' || val == 'price-asc' || val == 'price-desc' || val == 'featured') {
            if (window.location.href.includes('category/')) {
                const filterForm = jQuery('#filterform')[0];
                let oldData = new FormData(filterForm);
                let newData = new FormData();

                for (let [key, value] of oldData.entries()) {
                    if (key !== 'filter[category]') {
                        newData.append(key, value);
                    }
                }
                let catId;

                let activeCategory = $('[data-type="category"].active');

                if (activeCategory.length) {
                    catId = activeCategory.data('value');
                } else {
                    let fallback = $('[data-type="clear"]');
                    catId = fallback.attr('data-value-category-id');
                }

                newData.append('filter[category]', catId || '');
                data = newData;
            }
        }

        var f_count = parseInt(jQuery(this).attr('f_count'));

        jQuery.ajax({

            url: asset + 'shop/filter',

            type: 'POST',

            headers: { 'X-CSRF-TOKEN': token },

            data: data,

            cache: false,

            processData: false,

            contentType: false,

            success: function (response) {

                jQuery('.loader-main').css('display', 'none');

                response = JSON.parse(response)

                console.log(response.count)

                response.count < 9 || response.count == 9 ? jQuery('.pagination').hide() : jQuery('.pagination').show();

                // jQuery('#filter').html(response.filter)

                jQuery('#results').html(response.loop)

                let sliderSections = document.getElementsByClassName("range-slider");

                for (x = 0; x < sliderSections.length; x++) {
                    let sliders = sliderSections[x].getElementsByTagName("input");
                    for (y = 0; y < sliders.length; y++) {
                        if (sliders[y].type === "range") {
                            sliders[y].oninput = getVals;

                            sliders[y].oninput();
                        }
                    }
                }

                jQuery('.select-category').html(response.activefilter)

                jQuery('.list-grid .active').trigger('click')

            }


        })

    })
    jQuery(document).on('click', '.pagination .page-link-products', function (e) {
        e.preventDefault();

        const pageUrl = jQuery(this).attr('href');
        if (!pageUrl || pageUrl === 'javascript:;') return;

        const page = new URL(pageUrl).searchParams.get('page') || 1;

        const formData = new FormData(jQuery('#filterform')[0]);
        formData.append('page', page);

        jQuery('.loader-main').css('display', 'flex');

        jQuery.ajax({
            url: asset + 'shop/filter',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': token },
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response) {
                jQuery('.loader-main').hide();

                response = JSON.parse(response);
                jQuery('#results').html(response.loop);

                jQuery('.select-category').html(response.activefilter);

                jQuery('.list-grid .active').trigger('click');
            }
        });
    });

    jQuery('body').delegate('.label-brand', 'click', function () {

        if (jQuery(this).siblings('input').is(':checked')) {

            jQuery(this).siblings('input').removeAttr('checked')

        }
        else {

            jQuery(this).siblings('input').attr('checked', 'true')
        }
    })

    function getVals() {
        // Get slider values
        let parent = this.parentNode;
        let slides = parent.getElementsByTagName("input");
        slide1 = parseFloat(slides[0].value);
        slide2 = parseFloat(slides[1].value);
        if (slide1 > slide2) { let tmp = slide2; slide2 = slide1; slide1 = tmp; }

        jQuery('.rangeValues').find('valo').text(slide1)
        jQuery('.rangeValues').find('valt').text(slide2)
    }

    let sliderSections = document.getElementsByClassName("range-slider");

    for (x = 0; x < sliderSections.length; x++) {
        let sliders = sliderSections[x].getElementsByTagName("input");
        for (y = 0; y < sliders.length; y++) {
            if (sliders[y].type === "range") {
                sliders[y].oninput = getVals;

                sliders[y].oninput();
            }
        }
    }


    jQuery('body').delegate('.range-slider-check', 'click touchend', function () {

        jQuery('#filterform').find('.price-from').val(slide1)
        jQuery('#filterform').find('.price-to').val(slide2)

        jQuery('.price-filter').trigger('click')
    })

    jQuery('body').delegate('.shop-load', 'click', function () {

        jQuery('.loader-main').css('display', 'flex');

        let offset = (parseInt(jQuery(this).attr('offset')) + 9)

        jQuery(this).attr('offset', offset)

        let data = new FormData(jQuery('#filterform')[0])

        data.append('offset', offset)

        jQuery.ajax({

            url: asset + 'shop/filter',

            type: 'POST',

            headers: { 'X-CSRF-TOKEN': token },

            data: data,

            cache: false,

            processData: false,

            contentType: false,

            success: function (response) {

                response = JSON.parse(response)

                if (!response.loop.includes('No Products Found Related to Query!')) {

                    jQuery('#results').append(response.loop)

                    divCount = jQuery('#results .wrap').length;

                    console.log(divCount, response.count)

                    if (divCount == response.count) {

                        jQuery('.pagination').hide();

                    } else {

                        jQuery('.pagination').show()

                    }

                } else {

                    jQuery('.pagination').hide()

                }

                if (jQuery('#results').find('.wrap').length == 0) {

                    jQuery('.pagination').hide()
                }

                jQuery('.loader-main').hide();

            }


        })

    })

    jQuery('body').delegate('.remove-filter', 'click', function () {

        jQuery('.loader-main').show();

        let key = jQuery(this).attr('data-remove')

        jQuery('#filterform').find('.' + key).val('')

        key == 'rating' ? jQuery('#filterform').find('.filterrating').val('') : ''

        key == 'price-filter' ? jQuery('#filterform').find('.price-from').val('') : ''

        key == 'price-filter' ? jQuery('#filterform').find('.price-to').val('') : ''

        let data = new FormData(jQuery('#filterform')[0])

        jQuery.ajax({

            url: asset + 'shop/filter',

            type: 'POST',

            headers: { 'X-CSRF-TOKEN': token },

            data: data,

            cache: false,

            processData: false,

            contentType: false,

            success: function (response) {

                response = JSON.parse(response)

                response.count < 9 || response.count == 9 ? jQuery('.pagination').hide() : jQuery('.pagination').show()

                jQuery('#filter').html(response.filter)

                jQuery('#results').html(response.loop)

                jQuery('.select-category').html(response.activefilter)

                jQuery('.list-grid .active').trigger('click')

                jQuery('.loader-main').hide();

            }


        })

    })

    // Add to Cart Detail

    jQuery('#add-to-cart').submit(function (e) {

        e.preventDefault();

        let data = new FormData(jQuery(this)[0])

        let url = asset + 'cart/add'

        jQuery.ajax({

            url: url,

            type: 'POST',

            headers: { 'X-CSRF-TOKEN': token },

            data: data,

            cache: false,

            processData: false,

            contentType: false,

            success: function (response) {
                updateCartCount()

                cartNotification(response)
            }

        })
    })


    // Quantity

    jQuery('#qty').change(function () {

        let qty = parseInt(jQuery(this).val())

        let id = jQuery(this).parents('.cart-item').attr('data-item-id')

        let max = parseInt(jQuery(this).attr('max'))

        if (qty <= max) {

            updateProductQty(qty, id)

        } else {

            jQuery(this).val(max)
        }

    })

    jQuery('body').delegate('.qty-btn', 'click', function () {

        let parent = jQuery(this).parents('.qty-wrap');
        let qty = parseInt(parent.find('.qty').val())
        console.log(qty);
        let max = parseInt(parent.find('.qty').attr('max'))
        console.log(max)

        jQuery(this).hasClass('cart-minus') ? qty -= 1 : qty += 1

        if (qty <= max) {

            if (qty != 0) {

                parent.find('.qty').val(qty)

                if (jQuery(this).parents('.cart').length != 0) {

                    let id = jQuery(this).parents('.cart-item').attr('data-item-id')

                    updateProductQty(qty, id);

                }
            }

        }
        else {

            jQuery('#wishlist-notification').find('p').text('Only ' + max + ' items left in stock!')

            jQuery('#wishlist-notification').addClass('fadeInLeft active')

            setTimeout(function () {

                jQuery('#wishlist-notification').removeClass('fadeInLeft active')

            }, 1000)
        }

    })

    jQuery('body').delegate('.empty-cart', 'click', function () {

        let url = asset + 'cart/empty'

        jQuery.ajax({

            url: url,

            type: 'POST',

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {

                window.location.href = window.location.href

            }

        })

    })

    jQuery('body').delegate('.already-wish', 'click', function () {

        jQuery('#wishlist-notification').find('p').text('Product already exists in wishlist!')

        jQuery('#wishlist-notification').addClass('active')

        setTimeout(function () {

            jQuery('#wishlist-notification').removeClass('active')

        }, 1000)
    })

    jQuery('body').delegate('.delete-cart', 'click', function () {
        const $this = jQuery(this);

        const product = $this.attr('product-id');
        const variation_id = $this.attr('variation-id');
        const url = $this.attr('delete-url');
        const is_wishlist = $this.attr('whishlist');
        const serial = $this.attr('data-serial') || '';
        const attributes = $this.attr('data-attributes') || '{}';

        const $modal = jQuery('#delete-item');
        const $wishlistBtn = $modal.find('.wishlist-cart');

        if (is_wishlist == "exists") {
            $wishlistBtn.addClass('d-none');
        } else {
            $wishlistBtn.removeClass('d-none');
        }

        $modal.find('.delete-item').attr('href', url);

        // Set wishlist-cart data
        $wishlistBtn
            .attr('data-id', product)
            .attr('data-var_id', variation_id)
            .attr('data-serial', serial)
            .attr('data-attributes', attributes);
    });


    jQuery('body').delegate('.wishlist-cart', 'click', function () {
        const $btn = jQuery(this);
        const url = asset + 'wishlist/removefromcart';

        const id = $btn.attr('data-id');
        const var_id = $btn.attr('data-var_id');
        const serial = $btn.attr('data-serial') || '';
        let attributes = {};

        try {
            attributes = JSON.parse($btn.attr('data-attributes') || '{}');
        } catch (e) {
            attributes = {};
        }

        jQuery.ajax({
            url: url,
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': token },
            data: {
                id: id,
                var_id: var_id,
                serial: serial,
                variation: var_id,
                attributes: attributes
            },
            success: function (response) {
                response = JSON.parse(response);
                jQuery('#wishlist-notification p').text(response.message);

                response.message.includes('added') ? $btn.addClass('exists') : $btn.removeClass('exists');
                jQuery('#wishlist-notification').addClass('active');
                jQuery('.wishlist-icon small').text(response.count);

                updateCartCount();
                $btn.parents('.cart-item').remove();

                setTimeout(function () {
                    jQuery('#wishlist-notification').removeClass('active');
                    window.location.href = window.location.href;
                }, 2000);
            }
        });
    });


    jQuery(document).on('click', '.whishlist-btn', function () {
        const url = asset + 'wishlist/addorremove';
        const $btn = jQuery(this);
        const id = $btn.data('id');
        const var_id = jQuery('#variationID').length ? jQuery('#variationID').val() : 0;
        const formStr = jQuery('#add-to-cart').serialize();
        const serial = $btn.attr('serial') || '';

        jQuery.ajax({
            url: url,
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': token },
            data: formStr + '&id=' + id + '&var_id=' + var_id + '&serial=' + encodeURIComponent(serial),
            success: function (response) {
                response = JSON.parse(response);
                jQuery('#wishlist-notification p').text(response.message);
                response.message.includes('added') ? $btn.siblings('.delete-cart').attr('whishlist', 'exists') : $btn.siblings('.delete-cart').attr('whishlist', '');
                response.message.includes('added') ? $btn.addClass('exists') : $btn.removeClass('exists');
                jQuery('#wishlist-notification').addClass('active');
                jQuery('.wishlist-icon small').text(response.count);
                setTimeout(function () {
                    jQuery('#wishlist-notification').removeClass('active');
                }, 3000);
            }
        });
    });


    jQuery('a.link[data-bs-target="#signup"]').click(function () {

        jQuery('#signin').modal('hide')
    })


    let Mcheck

    setInterval(function () {

        Mcheck = false

        jQuery('.modal').each(function () {

            if (jQuery(this).hasClass('show')) {

                Mcheck = true

            }

        })

        console.log(Mcheck)

        if (!Mcheck) {

            jQuery('body').find('.modal-backdrop').remove()

        }

    }, 1000)

    // jQuery('.signup,.forgot').submit(function(e) {
    jQuery('.signup').submit(function (e) {

        e.preventDefault();

        let form = jQuery('#signup form')

        let data = new FormData(form[0]);

        let url = form.attr('action');

        jQuery.ajax({
            url: url,
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': token },
            data: data,
            cache: false,
            processData: false,
            contentType: false,

            success: function (response) {

                response = JSON.parse(response)

                form.find('.response').html('<p class="my-2">' + response.message + '</p>').addClass('active');

                setTimeout(function () {

                    response.redirect != '' ? window.location.href = response.redirect : ''

                    form.find('.response').removeClass('active');

                }, 3000);

            }
        });

        // let dis = jQuery(this)

        // let data = new FormData(jQuery(this)[0]);

        // dis.hasClass('signup') ? data.append('signup','true') : data.append('forgot','true')

        // jQuery.ajax({
        //     url: asset+'validate',
        //     type: 'POST',
        //     headers: { 'X-CSRF-TOKEN': token },
        //     data: data,
        //     cache: false,
        //     processData: false,
        //     contentType: false,
        //     success: function(response) {

        //         response = JSON.parse(response)

        //         if( response.message != undefined && response.message != '' ){

        //             dis.find('.response').text(response.message).addClass('active')

        //         }

        //         setTimeout(function() {

        //             dis.find('.response').removeClass('active')

        //         },2000)

        //         if( response.validate ){

        //             jQuery.ajax({
        //                 url: asset+'otp',
        //                 type: 'POST',
        //                 headers: { 'X-CSRF-TOKEN': token },
        //                 data: data,
        //                 cache: false,
        //                 processData: false,
        //                 contentType: false,
        //                 success: function(response) {

        //                     jQuery('#otp').modal('show');

        //                     jQuery('#resend-otp').addClass('disabled')
        //                     jQuery('.otp-loader').show()
        //                     jQuery('.circle_wrapper').find('.mask_left').addClass('active')
        //                     jQuery('.circle_wrapper').find('.mask_right').addClass('active')


        //                     setTimeout(function() {

        //                         jQuery('#resend-otp').removeClass('disabled')
        //                         jQuery('.circle_wrapper').find('.mask_left').removeClass('active')
        //                         jQuery('.circle_wrapper').find('.mask_right').removeClass('active')
        //                         jQuery('.otp-loader').hide()

        //                     },60000)
        //                 }
        //             })

        //         }

        //     }
        // })

    });

    jQuery('.otp-input').on('input', function () {

        let str = ''

        let count = 0

        if (jQuery(this).val().length == 1) { jQuery(this).val(jQuery(this).val().replace(/\D/g, '')) }

        else if (jQuery(this).val().length == 2) { jQuery(this).val(jQuery(this).val().slice(0, -(jQuery(this).val().length - 1))) }

        var currentIndex = jQuery(this).data('index');
        var nextIndex = currentIndex + 1;
        var $nextInput = jQuery('.otp-input[data-index="' + nextIndex + '"]');

        if (jQuery(this).val().length === 1 && $nextInput.length) {
            $nextInput.focus();
        }

        jQuery('.otp-input').each(function (index) {

            if (jQuery(this).val() != '') {

                str += jQuery(this).val()

                count = index
            }

        })

        jQuery('#otp-inp').val(str)

        if (count == 4) {

            jQuery('.otp').submit()

        }

    });

    $('.otp-input').on('keydown', function (e) {
        var currentIndex = $(this).data('index');
        var prevIndex = currentIndex - 1;

        if (e.key === "Backspace" && $(this).val().length === 0 && prevIndex >= 0) {
            $('.otp-input[data-index="' + prevIndex + '"]').focus();
        }
    });

    jQuery('.otp-input').on('paste', function () {

        let dis = jQuery(this)

        let count

        setTimeout(function () {

            jQuery('#otp-inp').val(dis.val())

            let val = dis.val().split('')

            jQuery('.otp-input').each(function (index) {

                if (val[index] != undefined) {

                    count = index

                    jQuery(this).val(val[index])
                }

            })


            if (count == 4) {

                jQuery('.otp').submit()
            }

        }, 500)
    })


    jQuery('#resend-otp').click(function () {

        let parent = jQuery(this).parents('form')

        if (jQuery(this).hasClass('disabled')) {

            parent.find('.response').html('<p class="my-2">Cannot resend OTP too soon. Please wait.</p>').addClass('active');

            setTimeout(function () {

                parent.find('.response').removeClass('active')

            }, 2000)
        }
        else {

            jQuery(this).addClass('disabled')

            let signup = jQuery('form.signup')

            let check = jQuery('form.forgot')

            data = check.length != 0 ? check[0] : signup[0]

            data = new FormData(data)

            jQuery.ajax({
                url: asset + 'otp',
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {

                    parent.find('.response').html('<p class="my-2">OTP Sent!</p>').addClass('active');

                    setTimeout(function () {

                        parent.find('.response').removeClass('active')

                    }, 2000)

                }
            })

            jQuery('.otp-loader').show()
            jQuery('.circle_wrapper').find('.mask_left').addClass('active')
            jQuery('.circle_wrapper').find('.mask_right').addClass('active')


            setTimeout(function () {

                jQuery('#resend-otp').removeClass('disabled')
                jQuery('.circle_wrapper').find('.mask_left').removeClass('active')
                jQuery('.circle_wrapper').find('.mask_right').removeClass('active')
                jQuery('.otp-loader').hide()

            }, 60000)


            // 300000
        }
    })

    jQuery('.otp').submit(function (e) {

        e.preventDefault()

        let val = jQuery('#otp-inp').val();

        let dis = jQuery(this)

        jQuery.ajax({

            url: asset + 'verify',

            type: 'POST',

            headers: { 'X-CSRF-TOKEN': token },

            data: { opt: val },

            success: function (response) {

                response = JSON.parse(response);

                dis.find('.response').html('<p class="my-2">' + response.message + '</p>').addClass('active');

                setTimeout(function () {

                    dis.find('.response').removeClass('active');

                    if (response.message.includes('Verified')) {

                        jQuery('#otp').modal('hide');

                        jQuery('#otp-inp,.otp-input').val('');

                        if (jQuery('#signup').hasClass('show')) {

                            let form = jQuery('#signup form')

                            let data = new FormData(form[0]);

                            let url = form.attr('action');

                            jQuery.ajax({
                                url: url,
                                type: 'POST',
                                headers: { 'X-CSRF-TOKEN': token },
                                data: data,
                                cache: false,
                                processData: false,
                                contentType: false,

                                success: function (response) {

                                    response = JSON.parse(response)

                                    window.location.href = window.location.href

                                    form.find('.response').html('<p class="my-2">' + response.message + '</p>').addClass('active');

                                    setTimeout(function () {
                                        form.find('.response').removeClass('active');
                                    }, 3000);

                                }
                            });
                        }
                        else {

                            window.location.href = asset + 'reset-password/' + response.username

                        }
                    }


                }, 1000);
            }

        })
    })


    $('body').on('submit', '.js-form', function (e) {
        e.preventDefault();

        let dis = jQuery(this);

        let data = new FormData(jQuery(this)[0]);

        let pass = true

        if (dis.find('.ct-slct').length != 0) {

            dis.find('.ct-slct').each(function () {

                if (jQuery(this).find('.inputhide').val() == '') {

                    pass = false

                    jQuery(this).find('button.form-control').attr('style', 'border-color:red !important')
                }
                else {

                    jQuery(this).find('button.form-control').removeAttr('style')
                }

            })
        }

        if (dis.find('input[name="confirmpassword"]').length != 0) {

            if (dis.find('input[name="confirmpassword"]').val() != dis.find('input[name="password"]').val()) {

                pass = false

                dis.find('input[name="confirmpassword"]').attr('style', 'border-color:red')

                dis.find('.response').addClass('active').text('Passwords donot match!')

                setTimeout(function () {

                    dis.find('.response').removeClass('active')

                }, 2000)

            }
            else {

                dis.find('input[name="confirmpassword"]').removeAttr('style')
            }

        }
        let areaInput = dis.find('input[name="address[area]"]');
        let emailInput = dis.find('input[name="address[email]"]');
        console.log(areaInput);
        console.log(emailInput);

        if (pass) {
            let url = jQuery(this).attr('action');

            jQuery.ajax({
                url: url,
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                data: data,
                cache: false,
                processData: false,
                contentType: false,

                success: function (response) {

                    response = JSON.parse(response);

                    if (response.html != undefined) {

                        jQuery('.add_form_address').html(response.html)

                        jQuery('.add-address').show()

                        jQuery('input[name="Phone"],input[name="phone"],input[name="number"],input[type="phone"],input[name="meta[vendor_phone]').intlTelInput({
                            initialCountry: "ae",
                            nationalMode: false,
                            autoInsertDialCode: true,
                            separateDialCode: true
                        });

                        jQuery('#confirm-address').attr('disabled', 'true')
                    }

                    if (dis.hasClass('forgot')) {

                        if (response.status == "1") {

                        }
                        else {
                            jQuery('.response').html('<p class="my-2">' + response.message + '</p>').addClass('active');
                        }
                    }

                    if (dis.hasClass('signin')) {

                        if (response.message.includes('Successfully')) {

                            localStorage.setItem('authenticated_gift_kingdom', JSON.stringify({ id: data.get('email_phone') }));
                        }
                        else {

                            localStorage.removeItem('authenticated_gift_kingdom');

                        }
                    }

                    if (response.redirect != '') {

                        window.location.href = response.redirect;

                    } else {

                        response.loggedin != undefined ? window.location.href = window.location.href : ''

                    }

                    if (dis.hasClass('has-response')) {
                        dis.find('.response').html('<p class="my-2">' + response.message + '</p>').addClass('active');
                    }
                    if (dis.attr('id') === 'event_inquiry') {
                        dis[0].reset();
                        dis.find('.inputhide').val('');
                    }

                    setTimeout(function () {
                        dis.find('.response').removeClass('active');
                    }, 3000);

                }
            });
        }
    });


    jQuery('body').delegate('#loguserout', 'click', function () {

        localStorage.removeItem('authenticated_gift_kingdom');

    })
    // Shipment

    let checkshipment = jQuery('#shipment')

    if (checkshipment.length != 0) {

        let dis = checkshipment.parents('.js-form')

        let data = new FormData(dis[0])

        let url = dis.attr('action')

        jQuery.ajax({

            url: url,

            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },

            type: 'POST',

            data: data,

            cache: false,

            processData: false,

            contentType: false,

            success: function (response) {

                console.log(response)

            }

        })


    }


    // Store Follow

    jQuery('body').delegate('.store-follow', 'click', function () {

        let id = jQuery(this).attr('data-id')

        let text = jQuery(this).find('h6').text()

        text.includes('Unfollow') ? jQuery(this).find('h6').text('Follow Store') : jQuery(this).find('h6').text('Unfollow Store')

        let url = asset + 'follow/store/'

        jQuery.ajax({

            url: url,

            type: 'POST',

            data: { id: id },

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {


                text.includes('Unfollow') ? jQuery('#exampleModal').find('.unfollowed').show() : jQuery('#exampleModal').find('.unfollowed').hide()

                text.includes('Unfollow') ? jQuery('#exampleModal').find('.followed').hide() : jQuery('#exampleModal').find('.followed').show()

            }

        })
    })

    // SEARCH

    jQuery('body').click(function () {

        jQuery('.suggestions').html('').removeClass('active')

    })

    jQuery('body').delegate('#search,.suggestions', 'click', function (e) {

        e.stopPropagation();

    })

    jQuery('body').delegate('.clear-search', 'click', function () {

        jQuery('#search').val('').trigger('keyup')

    })

    jQuery(document).on('keyup focus', '#search', function () {

        let dis = jQuery(this)
        let val = dis.val()


        let url = asset + 'products/search'

        jQuery.ajax({

            url: url,

            type: 'POST',

            data: { val: val },

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {

                jQuery('.suggestions').html(response).addClass('active')

                $('.keywords-slider').slick({
                    infinite: true, swipeToSlide: true, autoplay: false, speed: 1000, variableWidth: true, variableWidth: true,
                    draggable: true, arrows: false, dots: false, slidesToShow: 4,
                    responsive: [{
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 2
                        }
                    }
                        , {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 1
                        }
                    }]
                });
            }

        })
    })


    // Checkout Shipping

    jQuery('#shipping-address').click(function () {

        jQuery('.shipping-form').toggle();

        jQuery('.shipping-form').find('.required').attr('required') ?
            jQuery('.shipping-form').find('.required').removeAttr('required') :
            jQuery('.shipping-form').find('.required').attr('required', 'true')

    })

    jQuery('body').delegate('.add-address', 'click', function () {

        let url = asset + 'add-address'

        jQuery(this).hide()

        jQuery.ajax({

            url: url,

            type: 'POST',

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {

                jQuery('.add_form_address').prepend(response)

                jQuery('input[name="Phone"],input[name="phone"],input[name="number"],input[type="phone"],input[name="meta[vendor_phone]').intlTelInput({
                    initialCountry: "ae",
                    nationalMode: false,
                    autoInsertDialCode: true,
                    separateDialCode: true
                });
            }

        })

    })
    // Edit Address

    jQuery('body').delegate('.edit-form', 'click', function () {

        jQuery('.wrap .address-detail').addClass('active')

        jQuery('.wrap .form').removeClass('active')


        jQuery(this).text() == 'Show' ? jQuery(this).text('Hide') : jQuery(this).text('Show')

        jQuery(this).text() == 'Show' ? jQuery(this).parents('.wrap').find('.form').removeClass('active') : jQuery(this).parents('.wrap').find('.form').addClass('active')

        jQuery(this).text() == 'Show' ? jQuery(this).parents('.wrap').find('.address-detail').addClass('active') : jQuery(this).parents('.wrap').find('.address-detail').removeClass('active')

        jQuery('.wrap').each(function () {

            jQuery(this).find('.edit-form').text() == 'Hide' && jQuery(this).find('.address-detail').hasClass('active') ? jQuery(this).find('.edit-form').text('Show') : ''

        })

    })


    function updateProductQty(qty, id, hasDelivery = null) {

        let url = asset + 'cart/qty'

        jQuery.ajax({

            url: url,

            type: 'POST',

            data: { qty: qty, item: id, hasDelivery: hasDelivery },

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {

                updateCartCount()

                updateCart();

            }

        })

    }
    function updateCart() {

        jQuery('.cart-loader').removeAttr('style');

        let url = asset + 'cart/update'

        jQuery.ajax({

            url: url,

            type: 'POST',

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {

                response = JSON.parse(response)

                jQuery('.cart-items').html(response.loop);

                jQuery('.cart-summary').html(response.summary);

                jQuery('.cart-loader').hide();

                jQuery('.wow').addClass('animated')
            }

        })

    }

    function updateCartCount() {

        let url = asset + 'cart/count'

        jQuery.ajax({

            url: url,

            type: 'GET',

            headers: { 'X-CSRF-TOKEN': token },

            success: function (response) {
console.log('showing in response');
jQuery('.cart-icon .small').text(response);

            }

        })

    }

    function cartNotification(response) {
        response = JSON.parse(response);
        const notification = jQuery('#cart-notification');
        const figure = notification.find('figure');
        const deliveryBtn = jQuery('[data-bs-target="#product-delivery-modal"]');
        jQuery('#product-detail-repeat-wrapper').find('.delivery-info').remove();
        if (response.cart_item && response.cart_item.product) {
            const product = response.cart_item.product;

            deliveryBtn.attr('data-title', product.prod_title || '');
            deliveryBtn.attr('data-image', product.prod_image || '');
            deliveryBtn.attr('data-price', product.price || '');
            deliveryBtn.attr('data-product_id', response.cart_item.product_ID || '');
            deliveryBtn.attr('data-cart_item_id', response.cart_item.id || '');
            deliveryBtn.attr('data-meta', JSON.stringify(response.cart_item.display_meta || {}));
            deliveryBtn.attr('data-addresses', JSON.stringify(response.cart_item.addresses || []));

            deliveryBtn.attr('data-qty', response.cart_item.product_quantity || '');
            deliveryBtn.attr('data-max_qty', product.prod_quantity || '');
        }
        figure.empty();

        if (Array.isArray(response.images) && response.images.length > 0) {
            const imagesToShow = response.images.length === 1
                ? response.images
                : response.images.slice(0, 2);

            imagesToShow.forEach(function (imgSrc) {
                const img = jQuery('<img>').attr('src', imgSrc).addClass('cart-thumb me-2');
                figure.append(img);
            });
        } else if (response.img) {
            const img = jQuery('<img>').attr('src', response.img).addClass('cart-thumb me-2');
            figure.append(img);
        } else {
            figure.html('<img src="" alt="No image">');
        }

        notification.find('p').html(response.message.replace(/\n/g, '<br>'));

        notification.addClass('active');
    }
    jQuery(document).on('click', '.qty-btn-delivery', function () {
        let parent = jQuery(this).closest('.qty-wrap');
        let input = parent.find('.qty-input-delivery');
        let qty = parseInt(input.val());
        let max = parseInt(input.attr('max'));
        let min = 1;

        if (jQuery(this).hasClass('delivery-cart-minus')) {
            qty = Math.max(min, qty - 1);
        } else {
            qty = Math.min(max, qty + 1);
        }

        input.val(qty);

        const container = jQuery('#product-detail-repeat-wrapper');
        const existingForms = container.find('.delivery-info');
        const currentFormCount = existingForms.length;

        const modal = jQuery('[data-bs-target="#product-delivery-modal"]');
        const cart_item_id = modal.attr('data-cart_item_id') || '';
        const product_id = modal.attr('data-product_id') || '';

        if (typeof updateProductQty === 'function') {
            updateProductQty(qty, cart_item_id, true);
        }

        if (qty > currentFormCount) {
            const nextIndex = currentFormCount + 1;

            const sameAsAboveOption = nextIndex > 1 ? `
    <label class="form-check-label">
        <input type="radio" 
               class="form-check-input" 
               name="select-type-${nextIndex}" 
               value="same-as-above" 
               data-target="${nextIndex}">
        Same As Above
    </label>` : "";

            const newBlock = `
    <div class="delivery-info mb-3 border rounded p-4">
        <h6 class="mb-3">Delivery Info #${nextIndex}</h6>

        <div class="col-sm-12 mb-3">
            <label class="form-label d-block mb-2">Select Type</label>
            <div class="d-flex gap-3">
                <label class="form-check-label">
                    <input type="radio" 
                           class="form-check-input" 
                           name="select-type-${nextIndex}" 
                           value="manual" 
                           checked>
                    Fill Manually
                </label>
                <label class="form-check-label">
                    <input type="radio" 
                           class="form-check-input" 
                           name="select-type-${nextIndex}" 
                           value="addressbook">
                    Choose From Address Book
                </label>
                ${sameAsAboveOption}
            </div>
        </div>

        <div class="row g-2">
            <input type="hidden" name="label-${nextIndex}" value="${nextIndex}">
            <input type="hidden" name="cart_item_id-${nextIndex}" value="${cart_item_id}">
            <input type="hidden" name="product_id-${nextIndex}" value="${product_id}">

            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label">Recipient's Name</label>
                    <input type="text" class="form-control form-control-sm" name="name-${nextIndex}" required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="number" class="form-control form-control-sm" name="phone-${nextIndex}" required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control form-control-sm" name="address-${nextIndex}" required>
                </div>
            </div>
            <div class="col-12 time-slots">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input 
                                name="delivery-date-${nextIndex}" 
                                class="flatpickr delivery-date form-control" 
                                type="text" required
                                data-validate-slots="${nextIndex}"
                                value="${new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })}"
                                placeholder="Delivery Date"
                            >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="slots-${nextIndex}" id="validate-slots-${nextIndex}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>`;

            jQuery('.response').before(newBlock);

            flatpickr(`input[name="delivery-date-${nextIndex}"]`, {
                dateFormat: "d M, Y",
                minDate: "today"
            });
            jQuery(`input[name="delivery-date-${nextIndex}"]`).trigger('change');
        }
        else if (qty < currentFormCount) {
            container.find('.delivery-info').last().remove();
        }
    });



    jQuery(document).on('click', '[data-bs-target="#product-delivery-modal"]', function () {
        const btn = jQuery(this);
        const notification = jQuery('#cart-notification');
        notification.removeClass('active');
        const modal = jQuery('#product-delivery-modal');
        const container = modal.find('#product-detail-repeat-wrapper');
        const currentProduct = modal.attr('data-current-product');
        const existingAddresses = btn.data('addresses') || [];
        const product_id = btn.attr('data-product_id') || '';
        const cart_item_id = btn.attr('data-cart_item_id') || '';
        const title = btn.attr('data-title') || '';
        const image = btn.attr('data-image') || '';
        const price = btn.attr('data-price') || '';
        const qty = parseInt(btn.attr('data-qty') || '1');
        const maxQty = parseInt(btn.attr('data-max_qty') || '999');
        const rawMeta = btn.attr('data-meta') || '{}';
        const existingForms = container.find('.delivery-info');

        let metaValuesText = '';
        let personalMessage = '';

        try {
            const displayMeta = JSON.parse(rawMeta);

            const values = [];
            for (const key in displayMeta) {
                const value = displayMeta[key]?.value;

                if (typeof value === 'object' && value?.value_title) {
                    values.push(value.value_title);
                }

                else if (typeof value === 'string') {
                    if (key === 'personal-message') {
                        personalMessage = value;
                    } else {
                        values.push(value);
                    }
                }
            }
            if (values.length) metaValuesText = `(${values.join(', ')})`;
        } catch (e) {
            console.warn('Invalid meta:', e);
        }
        const personalMessageHtml = personalMessage
            ? `<div class="mt-1 text-muted small w-50">Personal Message: ${personalMessage}</div>`
            : '';
        container.empty();
        modal.attr('data-current-product', product_id);


        const header = `
	<div class="product-header mb-3">
		<div class="row align-items-center">
			<div class="col-2 text-center">
				<img src="${image}" alt="${title}" class="img-fluid rounded">
			</div>
			<div class="col-10">
				<h5 class="mb-1">${title} ${metaValuesText}</h5>
				${personalMessageHtml}
				<p class="mb-1">$${parseFloat(price).toFixed(2)}</p>
				<div class="d-flex align-items-center gap-2">
					<span>Qty</span>
					<div class="qty-wrap d-flex align-items-center gap-1">
						<button class="delivery-cart-minus qty-btn-delivery" type="button">
							<svg width="16" height="2" viewBox="0 0 16 2" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect x="16" width="2" height="16" rx="1" transform="rotate(90 16 0)" fill="#6D7D36"></rect>
							</svg>
						</button>
						<input type="number" class="form-control qty qty-input-delivery form-control-sm text-center p-0" name="qty" max="${maxQty}" readonly value="${qty}" style="width: 2.25rem;">
						<button class="delivery-cart-plus qty-btn-delivery" type="button">
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect x="7" width="2" height="16" rx="1" fill="#6D7D36"></rect>
								<rect x="16" y="7" width="2" height="16" rx="1" transform="rotate(90 16 7)" fill="#6D7D36"></rect>
							</svg>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
`;
        container.append(header);

        let formHtml = `<form id="delivery-form" class="small delivery-form" data-product="${product_id}">`;

        for (let i = 1; i <= qty; i++) {
            const label = i.toString();

            const exists = existingAddresses.some(addr =>
                addr.cart_item_id == cart_item_id && addr.label == label
            );

            if (exists) {
                continue;
            }
            const sameAsAboveOption = (i > 1 && existingForms.length > 0) ? `
        <label class="form-check-label">
            <input type="radio" 
                   class="form-check-input" 
                   name="select-type-${i}" 
                   value="same-as-above" 
                   data-target="${i}"> 
            Same As Above
        </label>` : "";
            formHtml += `
        <div class="delivery-info mb-3 border rounded p-4 accounts-section">
            <h6 class="mb-3">Delivery Info #${i}</h6>

            <div class="col-sm-12 mb-3">
                <label class="form-label d-block mb-2">Select Type</label>
                <div class="d-flex gap-3">
                    <label class="form-check-label">
                        <input type="radio" 
                            class="form-check-input" 
                            name="select-type-${i}" 
                            value="manual" 
                            checked> 
                        Fill Manually
                    </label>
                    <label class="form-check-label">
                        <input type="radio" 
                            class="form-check-input" 
                            name="select-type-${i}" 
                            value="addressbook"> 
                        Choose From Address Book
                    </label>
                   ${sameAsAboveOption}
                </div>
            </div>

            <div class="row g-2">
                <input type="hidden" name="label-${i}" value="${i}">
                <input type="hidden" name="cart_item_id-${i}" value="${cart_item_id}">
                <input type="hidden" name="product_id-${i}" value="${product_id}">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label">Recipient's Name</label>
                        <input type="text" class="form-control form-control-sm" name="name-${i}" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="number" class="form-control form-control-sm" name="phone-${i}" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control form-control-sm" name="address-${i}" required>
                    </div>
                </div>
                <div class="col-12 time-slots">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input 
                                    name="delivery-date-${i}" 
                                    class="flatpickr delivery-date form-control" 
                                    type="text" required
                                    data-validate-slots="${i}"
                                    value="${new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })}"
                                    placeholder="Delivery Date"
                                >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="slots-${i}" id="validate-slots-${i}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
        }




        formHtml += `
    <div class="response"></div>

		<div class="text-end pt-2">
			<button type="button" id="delivery-form-submit" class="btn btn-sm">Submit</button>
		</div>
	</form>`;

        container.append(formHtml);
        jQuery('.flatpickr').each(function () {
            if (this._flatpickr) {
                this._flatpickr.destroy();
            }
        });

        flatpickr(".flatpickr", {
            dateFormat: "d M, Y",
            minDate: "today"
        });
        container.find('.delivery-date').trigger('change');

    });








    jQuery('input[name="Phone"],input[name="phone"],input[name="number"],input[type="phone"],input[name="meta[vendor_phone]').intlTelInput({
        initialCountry: "ae",
        nationalMode: false,
        autoInsertDialCode: true,
        separateDialCode: true,

    });



    jQuery('body').delegate('input[type="number"]', 'input', function (e) {

        dis = jQuery(this)

        if (dis.val().length > dis.attr('maxlength')) {

            dis.val(dis.val().slice(0, dis.attr('maxlength')))

        }

        if (dis.hasClass('from')) {

            jQuery('input.to').val(dis.val()).attr('min', dis.val())
        }

    })


    jQuery('body').delegate('input[name="Phone"], input[name="phone"], input[name="number"], input[type="phone"], input[name="meta[vendor_phone]"]', 'keyup focus blur', function (e) {

        dis = jQuery(this)

        dis.val(dis.val().replace(/\D/g, ''))

        let btn = dis.parents('form.validate').find('button[type="submit"]')

        if (!dis.val().trim()) {

            btn.attr('disabled', 'true')
            dis.attr('style', 'border-color:red !important;padding-left:5.438rem !important')

        } else if (dis.val().length == 9) {

            dis.attr('style', 'padding-left:5.438rem !important')
            dis.parents('.iti').siblings('.valid').addClass('active')
            dis.parents('.iti').siblings('.invalid').removeClass('active')
            btn.removeAttr('disabled')

        } else {

            btn.attr('disabled', 'true')
            dis.attr('style', 'border-color:red !important;padding-left:5.438rem !important')
            dis.parents('.iti').siblings('.valid').removeClass('active')
            dis.parents('.iti').siblings('.invalid').addClass('active')


        }

    });


    jQuery('input[name="Phone"],input[name="phone"],input[type="phone"]').css('padding-left', '5.438rem !important')


    jQuery('.js-add-class').each(function () {

        let cls = jQuery(this).attr('data-class')

        jQuery(this).children().addClass(cls)

        jQuery(this).children().unwrap();

    })

    function showresponse(field, message) {

        if (message == 'Invalid phone number') {

            field.css({ 'border-color': 'red', 'padding-left': '5.438rem' });

        }
        else {

            field.css('border-color', 'red');

        }

        field.siblings('.info').text(message);

        field.parents('.iti').siblings('.info').text(message);

        throw "Invalid data";

    }

    function removeresponse(field) {

        if (field.attr('name') == 'Phone' || field.attr('name') == 'phone') {

            field.removeAttr('style');

            field.css('padding-left', '5.438rem');

        }
        else {

            field.removeAttr('style');

        }

        field.siblings('.info').text('');

        field.parents('.iti').siblings('.info').text('');

    }


    jQuery('.currency-change').click(function () {

        let id = jQuery(this).attr('val')

        jQuery.ajax({

            beforeSend: function (xhr) { xhr.setRequestHeader('X-CSRF-Token', jQuery('[name="_csrfToken"]').val()); },

            url: asset + "change_currency",

            type: "POST",

            data: { "currency_id": id, "_token": token },

            success: function (res) {

                window.location.reload();
            }

        })

    })



    jQuery('body').delegate('#applycoupon', 'click', function () {

        let dis = jQuery(this)

        let code = dis.siblings('input').val()

        if (dis.hasClass('has-coupon')) {

            dis.after('<small class="ms-3">Cart already has a coupon</small>')

            setTimeout(function () { dis.siblings('small').remove() }, 4000)

            throw 'Coupon Code Cannot Be Empty'
        }

        dis.siblings('small').remove()

        if (code == '') {

            dis.after('<small class="ms-3">Coupon code cannot be empty</small>')

            setTimeout(function () { dis.siblings('small').remove() }, 4000)

            throw 'Coupon Code Cannot Be Empty'
        }

        let url = asset + 'cart/applycoupon'

        jQuery.ajax({

            url: url,

            type: 'POST',

            headers: { 'X-CSRF-TOKEN': token },

            data: { code: code },

            success: function (response) {

                dis.after('<small class="ms-3">' + response + '</small>')

                setTimeout(function () {

                    if (!response.includes('Invalid') || !response.includes('Expired')) {

                        window.location.href = window.location.href

                    }

                    dis.siblings('small').remove()

                }, 2000)
            }

        })
    })


jQuery(document).on('click', '#store_credit', function () {
        console.log('inside hts');
    const timeSlot = jQuery('#validate-slots input[name="time-slot"]').val();

    jQuery('#validate-slots .open-menu2').removeClass('border border-danger');

    if (!timeSlot) {
        jQuery('#validate-slots .open-menu2').addClass('border border-danger');

        jQuery('html, body').animate({
            scrollTop: jQuery('#validate-slots').offset().top - 100
        }, 500);

        return; // prevent AJAX call
    }

let selectedShipping = jQuery('input[name="shipping_cost"]').val()
        let url = asset + 'cart/usestorecredit'

        jQuery.ajax({

            url: url,

            type: 'POST',
            headers: { 'X-CSRF-TOKEN': token },
            data: { shipping: selectedShipping },
            success: function (response) {
                        jQuery('.checkout-summary').html(response)

                
            }

        })

    })

    jQuery('body').delegate('.rating-container input', 'click', function () {

        let parent = jQuery(this).parents('.rating-container')

        let val = jQuery(this).val()

        let rating = { 1: 'Terrible', 2: 'Poor', 3: 'Average', 4: 'Good', 5: 'Exellent' }

        parent.find('input').each(function () {

            if (val <= jQuery(this).val()) {

                jQuery(this).css('color', '#FFBC11')
            }
            else {

                jQuery(this).removeAttr('style')
            }

        })


        jQuery(this).closest('.wrap').find('.rating-span').text(rating[val])


    })

    jQuery('#add-device').click(function () {

        let length = jQuery('#devices-append').find('.accordion-item').length

        if (length < 3) {

            let html = jQuery('.tradeinhtml').html()

            jQuery('#devices-append').append(html)

        }

        length = jQuery('#devices-append').find('.accordion-item').length

        jQuery('#devices-append').find('.accordion-item').each(function (index) {

            index += 1

            jQuery(this).find('button').attr('data-bs-target', '#collapse' + index)
            jQuery(this).find('button').attr('aria-controls', 'collapse' + index)
            jQuery(this).find('button h6').text('Device ' + index)
            jQuery(this).find('.collapse').attr('id', 'collapse' + index)
            // jQuery(this).find('button').trigger('click')

            index -= 1

            jQuery(this).find('select').each(function () {

                let name = jQuery(this).attr('name')

                name = name.replace('[]', '[' + index + ']')

                jQuery(this).attr('name', name)
            })

            jQuery(this).find('.form-check-input').each(function () {

                let name = jQuery(this).attr('name')

                name = name.replace('[]', '[' + index + ']')

                jQuery(this).attr('name', name)
            })
        })

        if (length != 0) {

            jQuery('.proceed-btn').show()

        } else {

            jQuery('.proceed-btn').hide()
        }

        jQuery('#devices-append').find('.accordion-item').last().find('.devicechange').trigger('change')

        setTimeout(function () {

            jQuery('#devices-append').find('.accordion-item').last().find('.select2').select2({ placeholder: "Select an option" })

        }, 1000)

    })


    jQuery('body').delegate('#devices-append .form-check', 'click', function () {

        jQuery(this).find('input[type="radio"]').prop('checked', true)

    })


    jQuery('body').delegate('.change-lang', 'click', function () {

        let dis = jQuery(this)

        let lang = dis.attr('data-lang')

        let url = asset + 'change_language'

        jQuery.ajax({

            url: url,

            type: 'POST',

            headers: { 'X-CSRF-TOKEN': token },

            data: { lang: lang },

            success: function (response) {

                window.location.href = window.location.href
            }

        })

    })

    jQuery('#validateonly').submit(function (e) {

        e.preventDefault();

        jQuery(this).find('.accordion-item').each(function () {

            jQuery(this).find('select').each(function () {

                if (jQuery(this).val() == 'Select an option' || jQuery(this).val() == null || jQuery(this).val() == undefined) {

                    jQuery(this).siblings('.select2').attr('style', 'border: solid 1px red;')

                    jQuery('.modal.fade.show').animate({
                        scrollTop: jQuery("#size").offset().top
                    }, 500);

                    if (jQuery(this).parents('.accordion-item').find('button').hasClass('collapsed')) {

                        jQuery(this).parents('.accordion-item').find('button').trigger('click')

                    }

                    throw 'Invalid Input';
                }
                else {

                    jQuery(this).siblings('.select2').removeAttr('style')

                }

            })

            jQuery(this).find('.form-check-input').each(function () {

                if (jQuery(this).val() == '' || jQuery(this).val() == null || jQuery(this).val() == undefined) {

                    jQuery(this).parents('.form-check').attr('style', 'border-color:red;')

                    jQuery('.modal.fade.show').animate({
                        scrollTop: jQuery("#size").offset().top
                    }, 500);

                    if (jQuery(this).parents('.accordion-item').find('button').hasClass('collapsed')) {

                        jQuery(this).parents('.accordion-item').find('button').trigger('click')

                    }

                    throw 'Invalid Input';
                }
                else {

                    jQuery(this).parents('.form-check').removeAttr('style')

                }

            })

        })

        jQuery('#add-to-cart').prepend('<div id="devices"></div>')

        let html = ''

        jQuery('#devices-append').find('select').each(function () {


            html += '<input type="hidden" name="' + jQuery(this).attr('name') + '" value="' + jQuery(this).val() + '">'

        })

        let checkarr = {}

        jQuery('#devices-append').find('.form-check-input').each(function () {

            if (jQuery(this).is(':checked')) {

                checkarr[jQuery(this).attr('name')] = jQuery(this).val()


            }

        })

        for (i in checkarr) {

            html += '<input type="hidden" name="' + i + '" value="' + checkarr[i] + '">'

        }


        jQuery('#add-to-cart').find('#devices').html(html)

        jQuery('#add-to-cart').submit()

        jQuery('#tradein').modal('hide')

        jQuery('#validateonly').find('.accordion-item').each(function () {

            let check2 = jQuery(this).find('.error')

            if (check2.length != 0) {

                jQuery(this).addClass('border border-danger')
            }
            else {

                jQuery(this).removeClass('border border-danger')
            }
        })


    })

    jQuery('body').delegate('.remove-device', 'click', function (e) {

        e.stopPropagation();

        jQuery(this).parents('.accordion-item').remove()

        let check = jQuery('#devices-append').find('.accordion-item')

        if (check.length < 3) {

            jQuery('#add-device').show()

        }
        if (check.length == 0) {

            jQuery('.proceed-btn').hide()

        }

        jQuery('#devices-append').find('.accordion-item').each(function (index) {

            index += 1

            jQuery(this).find('button').attr('data-bs-target', '#collapse' + index)
            jQuery(this).find('button').attr('aria-controls', 'collapse' + index)
            jQuery(this).find('button h6').text('Device ' + index)
            jQuery(this).find('.collapse').attr('id', 'collapse' + index)
            // jQuery(this).find('button').trigger('click')

            index -= 1

            jQuery(this).find('select').each(function () {

                let name = jQuery(this).attr('name')

                name = name.replace('[]', '[' + index + ']')

                jQuery(this).attr('name', name)
            })

            jQuery(this).find('.form-check-input').each(function () {

                let name = jQuery(this).attr('name')

                name = name.replace('[]', '[' + index + ']')

                jQuery(this).attr('name', name)
            })
        })
    })


    jQuery('body').delegate('.view-device', 'click', function () {

        let html = jQuery(this).find('.device-data').html()

        jQuery('#view-device').find('.device-details').html(html)
    })

    jQuery('body').delegate('.devicechange', 'change blur', function () {

        let dis = jQuery(this)

        let count = (dis.parents('#devices-append').find('.accordion-item').length - 1)

        let url = asset + 'get-sizes'

        let id = jQuery(this).val()

        jQuery.ajax({

            url: url,

            type: 'POST',

            headers: { 'X-CSRF-TOKEN': token },

            data: { id: id, count: count },

            success: function (response) {

                dis.parents('.accordion-body').find('#size').html(response)

                dis.parents('.accordion-body').find('#size select').select2({
                    placeholder: "Select an option"
                })
            }

        })

    })

    jQuery('body').delegate('.eye-open', 'click', function () {

        jQuery(this).parents('.form-group.position-relative').find('input').attr('type', 'text')

        jQuery(this).parents('.form-group.position-relative').find('.eye-close').show()

        jQuery(this).hide()

    })

    jQuery('body').delegate('.eye-close', 'click', function () {

        jQuery(this).parents('.form-group.position-relative').find('input').attr('type', 'password')

        jQuery(this).parents('.form-group.position-relative').find('.eye-open').show()

        jQuery(this).hide()

    })

    // MAP


    jQuery('#showStep2Btn').click(function () {

        let data = JSON.parse(jQuery(this).attr('data'))

        jQuery('.form.active').find('input[name="address[address]"]').val(data.formatted_address)

        if (data.address_components.length != undefined) {

            jQuery('.form.active').find('.careerFilterInr .dropdown_select').each(function () {


                if (jQuery(this).text().includes(data.address_components[data.address_components.length - 2].long_name)) {

                    jQuery(this).trigger('click')

                }

            })
        }

        let check333 = jQuery('.form.active').find('.map-url')
        if (check333.length == 0) {
            jQuery('.form.active .row.careerFilter').prepend('<div class="col-md-12 map-url"><button type="button" class="edit map-overlap"><svg width="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#6D7D36" d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"></path></svg> Edit</button><iframe src="https://maps.google.com/maps?&q=' + data.formatted_address + '&output=embed" width="100%"></iframe></div>')

            jQuery('.form.active .row.careerFilter').find('.map-url').append('<input type="hidden" name="address[url]" value="https://maps.google.com/maps?&q=' + data.formatted_address + '&output=embed">')

        }
        else {

            check333.find('iframe').attr('src', 'https://maps.google.com/maps?&q=' + data.formatted_address + '&output=embed')
            check333.find('input[type="hidden"]').val('https://maps.google.com/maps?&q=' + data.formatted_address + '&output=embed')

        }

        jQuery('#addressModal').modal('hide')

        jQuery('#addresses').attr('style', 'display:block').addClass('show')

    })
    jQuery('body').delegate('.map-overlap', 'click', function () {

        jQuery('#addressModal').modal('show')

        jQuery('#addresses').hide()

    })

    jQuery('body').delegate('.addressess-select .wrap', 'click', function () {

        let check = jQuery(this).parents('#current-address')

        let check2 = jQuery(this).parents('.acc-right')

        if (check.length == 0 && check2.length == 0) {

            jQuery('.addressess-select .wrap').removeClass('selected')

            jQuery(this).addClass('selected');

            if (jQuery('.addressess-select .wrap.selected').length != 0) {

                if (jQuery(this).find('.form').hasClass('active')) {

                    jQuery('#confirm-address').attr('disabled', 'true')
                }
                else {

                    jQuery('#confirm-address').removeAttr('disabled')

                }

            }

        }

    })

    jQuery('body').delegate('#addressModal .btn-close', 'click', function () {

        jQuery('#addresses').addClass('show').attr('style', 'display:block;opacity:1')

        if (jQuery('.addressess-select').find('.wrap').length == 0) {

            jQuery('#addresses').modal('hide')

            jQuery('.change-address').text('Add Address')

            jQuery('.add-address').show()

        }

        jQuery('.modal-backdrop.fade').addClass('show')

        jQuery('.btn.add-address').show()

        jQuery('.add_form_address').find('.wrap').each(function () {

            if (jQuery(this).find('.form').hasClass('active')) {

                if (jQuery(this).find('.map-url').length == 0) {

                    jQuery(this).remove()

                }
            }

        })

    })

    jQuery('body').delegate('#confirm-address', 'click', function () {

        jQuery('#current-address .wrap').html(jQuery('.addressess-select .wrap.selected').html())

        jQuery('#current-address .wrap').find('.edit-form').before('<a href="javascript:;" class="edit change-address" data-bs-toggle="modal" data-bs-target="#addresses">Change</a>')

        jQuery('#addresses').hide().removeClass('show')

        jQuery('.add-address').show()

        jQuery('#current-address .wrap').removeClass('selected')


    })

    if (jQuery('.addressess-select').length != 0) {

        if (loggedin == 1) {

            if (jQuery('.addressess-select .wrap').length == 0) {

                jQuery('#addresses').hide()

                setTimeout(function () {

                    jQuery('.add-address').trigger('click')


                    jQuery('#addresses').hide().attr('style', 'opacity:0');

                    jQuery('#addresses').modal('show')

                    jQuery('.addressess-select .wrap').last().remove()

                    setTimeout(function () {

                        jQuery('#addresses').hide()


                    }, 1000)


                }, 1000)
            }
        }
    }

    jQuery('#filter-loader').hide()

}) //Document Ready Closing

let check = jQuery('#range')

if (check.length != 0) {
    const
        range = document.getElementById('range'),
        setValue = () => {
            const
                newValue = Number((range.value - range.min) * 100 / (range.max - range.min)),
                newPosition = 16 - (newValue * 0.32);
            document.documentElement.style.setProperty("--range-progress", `calc(${newValue}% + (${newPosition}px))`);
        };
    document.addEventListener("DOMContentLoaded", setValue);
    range.addEventListener('input', setValue);
}

$(".error-section").height($(window).height()), jQuery(window).resize(function () { $(".error-section").height($(window).height()) })

function getContrastColor(bgColor) {
    // Convert HEX to RGB
    const rgb = parseInt(bgColor.slice(1), 16);
    const r = (rgb >> 16) & 0xff;
    const g = (rgb >> 8) & 0xff;
    const b = rgb & 0xff;

    // Calculate luminance
    const luminance = 0.2126 * r + 0.7152 * g + 0.0722 * b;

    // Return black or white based on luminance
    return luminance > 128 ? '#000000' : '#ffffff';
}

function updateColors(backgroundColor) {
    const iconColor = getContrastColor(backgroundColor);

    // Update CSS variables
    document.documentElement.style.setProperty('--background-color', backgroundColor);
    document.documentElement.style.setProperty('--icon-color', iconColor);
}
function rgbToHex(rgb) {
    // Extract the RGB values using a regex
    var result = rgb.match(/\d+/g);
    if (result) {
        return "#" + result
            .slice(0, 3) // Only use R, G, B values (ignore A if present)
            .map(function (x) {
                // Convert each value to hex
                return parseInt(x).toString(16).padStart(2, '0');
            })
            .join('');
    }
    return rgb;
}

$('.color-family input').on('click', function () {
    var bgColor = $(this).siblings('p').css('background-color');
    var hex = rgbToHex(bgColor)
    updateColors(hex);

})
jQuery(document).on('click', '#delivery-form-submit, .delivery-form-submit', function (e) {
    e.preventDefault();
    const triggerBtn = jQuery(this);
    let forms;

    // Check if the button is inside a cart-item-new
    if (triggerBtn.closest('.cart-item-new').length) {
        forms = triggerBtn.closest('.cart-item-new').find('form#delivery-form');
    } else {
        // default behavior: single form
        forms = jQuery('#delivery-form');
    }

    forms.each(function () {
        const form = jQuery(this)[0];
        const formData = new FormData(form);
        let isValid = true;

        jQuery(form).find('.is-invalid').removeClass('is-invalid');
        jQuery(form).find('.invalid-feedback').remove();

        // validation
        jQuery(form).find('input[required]').each(function () {
            const input = jQuery(this);
            if (!input.val().trim()) {
                isValid = false;
                input.addClass('is-invalid');
                if (!input.next('.invalid-feedback').length) {
                    input.after('<div class="invalid-feedback" style="margin-left: 8px;font-size: 13px;">This field is required.</div>');
                }
            }
        });

        if (!isValid) return;

        // prepare data
        let productId = formData.get('product_id');
        let cartItemId = formData.get('cart_item_id');
        let deliveries = {};

        for (let [key, value] of formData.entries()) {
            let match = key.match(/^([a-zA-Z_-]+)-(\d+)$/);
            if (match) {
                const field = match[1].replace(/-/g, '_');
                const index = match[2];

                if (!deliveries[index]) {
                    deliveries[index] = {
                        product_id: productId,
                        cart_item_id: cartItemId
                    };
                }

                deliveries[index][field] = value;
            }
        }

        const deliveryArray = Object.values(deliveries);

        // submit each form via AJAX
        jQuery.ajax({
            url: asset + 'save-cart-item-addresses',
            method: 'POST',
            data: JSON.stringify({ deliveries: deliveryArray }),
            headers: { 'X-CSRF-TOKEN': token },
            contentType: 'application/json',
            success: function (res) {
                const responseContainer = jQuery(form).find('.response');
                if (res.status === 'success') {
                    responseContainer.html('<p class="my-2" style="color:#2D3C0A;">' + res.message + '</p>').addClass('active');

                    setTimeout(() => {
                        const modal = jQuery(form).closest('#product-delivery-modal');
                        if (modal.length) {
                            const bsModal = bootstrap.Modal.getInstance(modal[0]);
                                            if (bsModal) {
    bsModal.hide();
    setTimeout(() => window.location.reload(), 2000); // wait ~0.3s
}
                        }
                        
                    }, 2000);
                } else {
                    responseContainer.html('<p class="my-2 text-danger">' + res.message + '</p>').addClass('active');
                }
            },
            error: function (err) {
                console.error('Error:', err);
                jQuery(form).find('.response')
                    .html('<p class="my-2 text-danger">Request failed. Please try again later.</p>')
                    .addClass('active');
            }
        });
    });
});




jQuery(document).on('click', '.view-addresses-btn', function () {
    const addresses = JSON.parse(jQuery(this).attr('data-addresses') || '[]');
    const tbody = jQuery('#addressTableBody');
    tbody.empty();

    if (addresses.length === 0) {
        tbody.append('<tr><td colspan="6" class="text-center">No addresses found.</td></tr>');
        return;
    }
    addresses.forEach(address => {
        tbody.append(`
            <tr>
                <td>${address.label}</td>
                <td>${address.name}</td>
                <td>${address.phone}</td>
                <td>${address.address}</td>
                <td>${address.delivery_date}</td>
                <td>${address.delivery_time}</td>
            </tr>
        `);
    });
});

document.querySelectorAll('#WalletType .dropdown_select').forEach(function (dropdown) {
    dropdown.addEventListener('click', function () {
        const type = jQuery(this).attr('value');
        fetch(asset + "wallet-history/filter", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ type: type })
        })
            .then(res => res.json())
            .then(data => {
                document.getElementById('wallet-history-table').innerHTML = data.view;
            })
            .catch(err => console.error(err));
    });
});
function selectVoucher(code) {
    document.getElementById('voucher-code-input').value = code;
    const modal = bootstrap.Modal.getInstance(document.getElementById('view-vouchers-modal'));
    modal.hide();
}

function handleSameAsAbove(element) {

    const $element = jQuery(element);
    const targetIndex = $element.attr('data-target');
    const previousIndex = parseInt(targetIndex) - 1;


    if (previousIndex < 1) {
        console.warn('No previous delivery info to copy from');
        return;
    }

    const cartItem = $element.closest('.cart-item-new');
    const isCartItemScope = cartItem.length > 0;
    const $scope = isCartItemScope ? cartItem : jQuery('#product-delivery-modal');
        $scope.find(`.addressbook-dropdown-${targetIndex}`).remove();

    const previousName = $scope.find(`input[name="name-${previousIndex}"]`).val();
    const previousPhone = $scope.find(`input[name="phone-${previousIndex}"]`).val();
    const previousAddress = $scope.find(`input[name="address-${previousIndex}"]`).val();
    const previousDeliveryDate = $scope.find(`input[name="delivery-date-${previousIndex}"]`).val();
    const previousTimeSlot = $scope.find(`input[name="time-slot-${previousIndex}"]`).val();


    if (!previousName && !previousPhone && !previousAddress) {

        const messageArea = jQuery('<div class="delivery-message-area"></div>').css({
            margin: '8px 0',
            padding: '8px 12px',
            borderRadius: '6px',
            background: '#fff3cd',
            color: '#856404',
            fontSize: '14px',
            border: '1px solid #ffeeba'
        }).text('Please fill out the previous delivery information first.');

        $scope.find('.delivery-message-area').remove();
        if (isCartItemScope) {
            $element.closest('.delivery-info').prepend(messageArea);
        } else {
            $scope.find('.modal-content').prepend(messageArea);
        }

        setTimeout(() => {
            messageArea.fadeOut(400, () => messageArea.remove());
        }, 2000);
        return;
    }

    $scope.find(`input[name="name-${targetIndex}"]`).val(previousName).trigger('change');
    $scope.find(`input[name="phone-${targetIndex}"]`).val(previousPhone).trigger('change');
    $scope.find(`input[name="address-${targetIndex}"]`).val(previousAddress).trigger('change');
    $scope.find(`input[name="delivery-date-${targetIndex}"]`).val(previousDeliveryDate).trigger('change');
    $scope.find(`input[name="time-slot-${targetIndex}"]`).val(previousTimeSlot).trigger('change');

    const deliveryDateInput = $scope.find(`input[name="delivery-date-${targetIndex}"]`);
    if (deliveryDateInput.length && deliveryDateInput[0]._flatpickr) {
        deliveryDateInput[0]._flatpickr.setDate(previousDeliveryDate);
    }

    const previousTimeSlotButton = $scope.find(`input[name="time-slot-${previousIndex}"]`)
        .closest('.delivery-info')
        .find('.open-menu2').last();
    const previousTimeSlotText = previousTimeSlotButton.text().replace(/\s*<svg[\s\S]*?<\/svg>\s*/gi, '').trim();

    const currentTimeSlotButton = $scope.find(`input[name="time-slot-${targetIndex}"]`)
        .closest('.delivery-info')
        .find('.open-menu2').last();

    if (previousTimeSlot && previousTimeSlotText && previousTimeSlotText !== 'Select Time Slot') {
        currentTimeSlotButton.html(previousTimeSlotText +
            '<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">' +
            '<path d="M1 1L7 7L13 1" stroke="black"></path></svg>');
    }

}



document.addEventListener('change', function (e) {
    const radio = e.target.closest('input[type="radio"][name^="select-type-"]');
    if (!radio) return;

    const value = radio.value;
    const targetIndex = radio.getAttribute('data-target') || radio.name.split("-").pop();

    const cartItem = radio.closest('.cart-item-new');
    const $scope = cartItem ? jQuery(cartItem) : jQuery('#product-delivery-modal');

    if (value === 'manual') {

        $scope.find(`input[name="name-${targetIndex}"]`).val('').trigger('change');
        $scope.find(`input[name="phone-${targetIndex}"]`).val('').trigger('change');
        $scope.find(`input[name="address-${targetIndex}"]`).val('').trigger('change');
        $scope.find(`input[name="delivery-date-${targetIndex}"]`).val('').trigger('change');
        $scope.find(`input[name="time-slot-${targetIndex}"]`).val('').trigger('change');
        $scope.find(`.addressbook-dropdown-${targetIndex}`).remove();
        return;
    }

    if (value === 'same-as-above') {
        handleSameAsAbove(radio);
        return;
    }

    if (value === 'addressbook') {

        const $deliveryBlock = $(radio).closest('.delivery-info');
        const isCartItemScope = $deliveryBlock.length > 0;

        $deliveryBlock.find(`.addressbook-dropdown-${targetIndex}`).remove();

        $.ajax({
            url: asset + "get-addresses",
            method: "GET",
            data: { is_ajax: true },
            dataType: "json",
            success: function (response) {
                if (!response || response.length === 0) {
                    const messageArea = jQuery('<div class="delivery-message-area"></div>').css({
                        margin: '8px 0',
                        padding: '8px 12px',
                        borderRadius: '6px',
                        background: '#fff3cd',
                        color: '#856404',
                        fontSize: '14px',
                        border: '1px solid #ffeeba'
                    }).text('You don’t have any saved address');
 if (isCartItemScope) {
            $deliveryBlock.prepend(messageArea);
        }else{
            $scope.find('.delivery-message-area').remove();
            $scope.prepend(messageArea);
        }

                    setTimeout(() => {
                        messageArea.fadeOut(400, () => messageArea.remove());
                    }, 2000);

                    return;
                }

                let optionsHtml = "";
                Object.values(response).forEach(addr => {
                    optionsHtml += `
                        <li>
                            <a href="javascript:;" 
                               class="dropdown_select addressbook-option" 
                               data-target="${targetIndex}" 
                               data-name="${addr.firstname}" 
                               data-phone="${addr.phone}" 
                               data-address="${addr.address}">
                                ${addr.firstname} | ${addr.address} | ${addr.label}
                            </a>
                        </li>`;
                });

                const dropdownHtml = `
                    <div class="col-md-12 addressbook-dropdown-${targetIndex}">
                        <div class="careerFilter">
                            <div class="form-group ct-slct">
                                <label class="mb-2">Choose Address</label>
                                <div class="child_option position-relative">
                                    <button class="form-control text-start w-100 d-flex align-items-center justify-content-between open-menu2" type="button">
                                        Select Address
                                        <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L7 7L13 1" stroke="black"></path>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu2 dropdown-menu-right" style="display: none;">
                                        <ul class="careerFilterInr">
                                            ${optionsHtml}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

                $deliveryBlock.find(".row.g-2 > .col-sm-4").first().before(dropdownHtml);
            }
        });
    }
}, true);




document.addEventListener('click', function (e) {
    if (e.target.classList.contains('addressbook-option')) {
        e.preventDefault();

        const option = e.target;
        const targetIndex = option.dataset.target;

        // Grab data attributes
        const selectedName = option.dataset.name || "";
        const selectedPhone = option.dataset.phone || "";
        const selectedAddress = option.dataset.address || "";

        const cartItem = option.closest('.cart-item-new');

        if (cartItem) {
            const nameInput = cartItem.querySelector(`input[name="name-${targetIndex}"]`);
            const phoneInput = cartItem.querySelector(`input[name="phone-${targetIndex}"]`);
            const addressInput = cartItem.querySelector(`input[name="address-${targetIndex}"]`);

            if (nameInput) nameInput.value = selectedName;
            if (phoneInput) phoneInput.value = selectedPhone;
            if (addressInput) addressInput.value = selectedAddress;

        } else {
            const modal = document.querySelector('#product-delivery-modal');
            modal.querySelector(`input[name="name-${targetIndex}"]`).value = selectedName;
            modal.querySelector(`input[name="phone-${targetIndex}"]`).value = selectedPhone;
            modal.querySelector(`input[name="address-${targetIndex}"]`).value = selectedAddress;
        }

        const childOption = option.closest(".child_option");
        if (option.closest(".dropdown-menu2")) {
            option.closest(".dropdown-menu2").style.display = "none";
        }
        if (childOption) {
            childOption.querySelector("button").textContent = `${selectedName} | ${selectedAddress}`;
        }
    }
}, true);


$(document).ready(function () {
    $('#viewAddressesModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);

        const data = {
            image: button.data('image'),
            product_id: button.data('product_id'),
            cart_item_id: button.data('cart_item_id'),
            title: button.data('title'),
            price: button.data('price'),
            meta: button.data('meta'),
            qty: button.data('qty'),
            max_qty: button.data('max_qty'),
            addresses: button.data('addresses')
        };
        const addNewBtn = $(this).find('.btn[data-bs-target="#product-delivery-modal"]');

        addNewBtn.attr('data-image', data.image ?? '');
        addNewBtn.attr('data-product_id', data.product_id ?? '');
        addNewBtn.attr('data-cart_item_id', data.cart_item_id ?? '');
        addNewBtn.attr('data-title', data.title ?? '');
        addNewBtn.attr('data-price', data.price ?? '');
        addNewBtn.attr('data-meta', data.meta ?? '');
        addNewBtn.attr('data-qty', data.qty ?? '');
        addNewBtn.attr('data-max_qty', data.max_qty ?? '');
        addNewBtn.attr('data-addresses', JSON.stringify(data.addresses || []));
    });

});
jQuery(document).ready(function () {
    jQuery('.cart-item-new').each(function () {
        const item = jQuery(this);

        const product_id = item.data('product_id');
        const cart_item_id = item.data('cart_item_id');
        const qty = parseInt(item.data('qty'));
        const rawMeta = item.data('meta');

        let metaValuesText = '';
        let personalMessage = '';

        try {
            const displayMeta = rawMeta ? JSON.parse(rawMeta) : {};
            const values = [];

            for (const key in displayMeta) {
                const value = displayMeta[key]?.value;
                if (typeof value === 'object' && value?.value_title) {
                    values.push(value.value_title);
                } else if (typeof value === 'string') {
                    if (key === 'personal-message') {
                        personalMessage = value;
                    } else {
                        values.push(value);
                    }
                }
            }
            if (values.length) metaValuesText = `(${values.join(', ')})`;
        } catch (e) {
            console.warn('Invalid meta:', e);
        }

        const personalMessageHtml = personalMessage
            ? `<div class="mt-1 text-muted small">Personal Message: ${personalMessage}</div>`
            : '';

        let formHtml = `<div class="delivery-section mt-5">
            <h6 class="mb-2">Delivery Information</h6>
            <form class="small" id="delivery-form" data-product="${product_id}">`;

        for (let i = 1; i <= qty; i++) {
            const sameAsAboveOption = (i > 1) ? `
                <label class="form-check-label">
                    <input type="radio" 
                           class="form-check-input" 
                           name="select-type-${i}" 
                           value="same-as-above" 
                           data-target="${i}"> 
                    Same As Above
                </label>` : "";

            formHtml += `
                <div class="delivery-info mb-3 border rounded p-4 accounts-section">
                    <h6 class="mb-3">Delivery Info #${i}</h6>

                    <div class="col-sm-12 mb-3">
                        <label class="form-label d-block mb-2">Select Type</label>
                        <div class="d-flex gap-3">
                            <label class="form-check-label">
                                <input type="radio" 
                                    class="form-check-input" 
                                    name="select-type-${i}" 
                                    value="manual" 
                                    checked> 
                                Fill Manually
                            </label>
                            <label class="form-check-label">
                                <input type="radio" 
                                    class="form-check-input" 
                                    name="select-type-${i}" 
                                    value="addressbook"> 
                                Choose From Address Book
                            </label>
                            ${sameAsAboveOption}
                        </div>
                    </div>

                    <div class="row g-2">
                        <input type="hidden" name="label-${i}" value="${i}">
                        <input type="hidden" name="cart_item_id-${i}" value="${cart_item_id}">
                        <input type="hidden" name="product_id-${i}" value="${product_id}">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label">Recipient's Name</label>
                                <input type="text" class="form-control form-control-sm" name="name-${i}" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label">Phone</label>
                                <input type="number" class="form-control form-control-sm" name="phone-${i}" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control form-control-sm" name="address-${i}" required>
                            </div>
                        </div>

                        <div class="col-12 time-slots">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input 
                                            name="delivery-date-${i}" 
                                            class="flatpickr delivery-date form-control" 
                                            type="text" required
                                            data-validate-slots="${i}"
                                            value="${new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })}"
                                            placeholder="Delivery Date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="slots-${i}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

jQuery.ajax({
    url: asset + 'saved-cartitem-addresses',
    method: 'POST',
    data: {
        cart_item_id: cart_item_id,
        product_id: product_id,
        label: i
    },
    headers: { 'X-CSRF-TOKEN': token },
success: function (res) {
    const scope = item.find(`.delivery-info input[name="label-${i}"]`).closest('.delivery-info');
    const dateInput = scope.find(`input[name="delivery-date-${i}"]`);
    if (res && res.success && res.data) {
        const data = res.data;

        scope.find(`input[name="name-${i}"]`).val(data.name || '');
        scope.find(`input[name="phone-${i}"]`).val(data.phone || '');
        scope.find(`input[name="address-${i}"]`).val(data.address || '');

        if (data.delivery_date) {
            if (dateInput[0]._flatpickr) {
                dateInput[0]._flatpickr.setDate(data.delivery_date, true);
            } else {
                dateInput.val(data.delivery_date);
            }
        } else {

        }

        if (data.delivery_time) {
dateInput.one('change.slotsLoaded', function () {
    setTimeout(() => {
        const slotLinks = scope.find(`.slots-${i}`).find('.change-slot');

        const match = slotLinks.filter(function () {
            return $(this).attr('value') === data.delivery_time;
        });

if (match.length) {
    match.trigger('click');

    // close the dropdown as if the user finished selecting
    const childOption = match.closest('.child_option');
    childOption.find('.open-menu2').removeClass('active');
    childOption.find('.dropdown-menu2').hide();
}

    }, 1000);
});


            dateInput.trigger('change');
        }

        if (data.select_type) {
            scope.find(`input[name="select-type-${i}"][value="${data.select_type}"]`)
                .prop('checked', true)
                .trigger('change');
        }
    }else{
       dateInput.trigger('change'); 
    }
}

});


        }

        formHtml += `
            <div class="text-end pt-2 d-none">
                <button type="button" class="btn btn-sm d-none delivery-form-submit">Submit</button>
            </div>
            </form>
        </div>`;

        item.append(formHtml);

        // Init datepickers
        jQuery('.flatpickr').each(function () {
            if (this._flatpickr) this._flatpickr.destroy();
        });
        flatpickr(".flatpickr", {
            dateFormat: "d M, Y",
            minDate: "today"
        });
    });
});



