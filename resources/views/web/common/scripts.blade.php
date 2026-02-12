<input type="hidden" name="_token" value="IIh7xcTH6LjAxwRwjQ0lI4iABxKPR0rXGWf7UjlW">
<script src="<?= asset('assets/js/script.js') ?>"></script>
<!-- <script src="<?= asset('assets/js/script.min.js') ?>"></script> -->


<?php

if (isset($result['post_content'])) :

  $title = $result['post_content'];

elseif (isset($result['content']['pagetitle'])) :

  $title = $result['content']['pagetitle'];

else :

  $title = '';

endif;
?>
<script>
  let geopluginurl = ''

  let userip = '111.88.87.78'

  let pagetitle = 'Home'

  let register = '<?= isset($_GET['register']) ? $_GET['register'] : 'false' ?>'

  let login = '<?= isset($_GET['login']) ? $_GET['login'] : 'false' ?>'

  let asset = '<?= asset('') ?>'

  let token = jQuery('meta[name="csrf-token"]').attr('content')

  let loggedin = '<?= Auth::check() ? 1 : 0 ?>'

  let guest = '<?= Auth::check() ? 'true' : 'false' ?>'

  jQuery.ajax({

    type: 'POST',

    headers: {
      'X-CSRF-TOKEN': token
    },

    url: '{{asset("geoplugin")}}',

    data: {
      ip: '{{$_SERVER["REMOTE_ADDR"]}}',
      page: '{{$title}}'
    },

    success: function(response) {

      console.log(response)

    }

  })
</script>


<script defer src="<?= asset('admin/js/intlTelInput-jquery.min.js') ?>"></script>

@if (!request()->is('/'))

<script src="<?= asset('admin/js/select2.full.min.js') ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

<script type="text/javascript">
  const options = {}

  Fancybox.bind('[data-fancybox="gallery"]', options);

  $(document).ready(function() {

    $(document).on('click', function(e) {
      if (!$(e.target).closest('.notification-dropdown').length &&
        !$(e.target).closest('.bell_icon').length) {
        $('.notification-dropdown').hide();
      }
    });
  });
</script>

@endif

@stack('scripts')
<script>

function setupAddressForm() {
  const wrapper = document.getElementById('address-form-wrapper');
  console.log("Wrapper:", wrapper);

  if (!wrapper) {
    console.warn("No element with ID 'address-form-wrapper' found.");
    return;
  }

  const parentForm = wrapper.closest('form');
  console.log("Found parent form:", parentForm);

  if (!parentForm || parentForm.id === 'checkout_form') {
    console.log("Creating/Overriding address form...");

    const allContent = Array.from(wrapper.childNodes);
    console.log("All wrapper content:", allContent);

    let contentToKeep = [];
    
    allContent.forEach(node => {
      if (node.nodeType === Node.ELEMENT_NODE) {
        if (node.tagName === 'FORM' && node.id === 'address_form') {
          console.log("Found existing address form, extracting content");
          const formChildren = Array.from(node.childNodes).filter(child =>
            !(child.tagName === 'INPUT' && child.name === '_token')
          );
          contentToKeep.push(...formChildren);
        } else {
          contentToKeep.push(node);
        }
      } else if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() !== '') {
        contentToKeep.push(node);
      }
    });
    console.log("Content to keep:", contentToKeep);

    wrapper.innerHTML = '';

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ asset('account/update-address') }}';
    form.id = 'address_form';
    form.className = 'js-form validate has-response';

    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    form.appendChild(csrf);

    contentToKeep.forEach(content => {
      if (content.parentNode) {
        content.parentNode.removeChild(content);
      }
      form.appendChild(content);
    });

    // Add the form to wrapper
    wrapper.appendChild(form);

    console.log("New form created with content:", form);

    // Clone inputs to checkout form if it exists
    const checkoutForm = document.getElementById('checkout_form');
    if (checkoutForm) {
      console.log("Cloning address inputs as hidden fields into checkout_form.");

      // Remove previous clones
      checkoutForm.querySelectorAll('.cloned-address-input').forEach(el => el.remove());

      const addressInputs = form.querySelectorAll('input[name^="address["], select[name^="address["], textarea[name^="address["]');
      
      if (addressInputs.length > 0) {
        console.log("Found address inputs to clone:", addressInputs.length);
        addressInputs.forEach(input => {
          const hidden = document.createElement('input');
          hidden.type = 'hidden';
          hidden.name = input.name;
          hidden.value = input.value;
          hidden.classList.add('cloned-address-input');
          checkoutForm.appendChild(hidden);
          console.log(`Cloned input: ${input.name} = ${input.value}`);
        });
      } else {
        console.log("No address inputs found to clone");
      }
    } else {
      console.log("checkout_form not found, skipping cloning inputs.");
    }

  } else {
    console.log("Wrapper is inside a different form. Skipping form creation.");
  }
}

// Re-run when confirm address is clicked
document.body.addEventListener('click', function(e) {
  if (e.target && e.target.id === 'confirm-address') {
    console.log('#confirm-address clicked, running setupAddressForm()');
    setupAddressForm();
  }
});
function syncAddressInputs() {
    const addressForm = document.getElementById('address_form');
    const checkoutForm = document.getElementById('checkout_form');
    
    if (addressForm && checkoutForm) {
        const originalInputs = addressForm.querySelectorAll('input[name^="address["], select[name^="address["], textarea[name^="address["]');
        
        originalInputs.forEach(input => {
            const hiddenInput = checkoutForm.querySelector(`input[name="${input.name}"].cloned-address-input`);
            if (hiddenInput) {
                hiddenInput.value = input.value;
                console.log(`Synced ${input.name}: ${input.value}`);
            }
        });
    }
}
        let authloggedin = '<?= Auth::check() ? 'true' : 'false' ?>';

    jQuery('body').on('click', '#place_order', function (e) {
        if (!e._allowDefaultHandler) {
            e.preventDefault();
            e.stopImmediatePropagation();
            console.log('auth logged in comes here:');
            console.log(authloggedin);
            console.log('address-form-wrapper add-ressdeital ocm eshere:');
            console.log($('#address-form-wrapper #current-address .address-detail').length);
            if (authloggedin == 'false' || $('#address-form-wrapper #current-address .address-detail.active').length <= 0) {

              console.log('syncAddressInputs comes here:');
                if (typeof syncAddressInputs === 'function') {
                  syncAddressInputs();
                }


            }
                            setTimeout(() => {
                    const evt = jQuery.Event('click');
                    evt._allowDefaultHandler = true;
                    jQuery('#place_order').trigger(evt);
                }, 1000);
        }
    });



    if (authloggedin) {
        document.addEventListener('DOMContentLoaded', setupAddressForm);

    }
// Handle form submission
$('body').on('click', '#address_form button[type="submit"]', function(e) {
  e.preventDefault();
  console.log('SUBMIT BUTTON CLICK HANDLER TRIGGERED');

  let dis = $(this).closest('form.js-form');
  let data = new FormData(dis[0]);
  let pass = true;

  // Validate ct-slct fields
  dis.find('.ct-slct').each(function() {
    if ($(this).find('.inputhide').val() === '') {
      pass = false;
      $(this).find('button.form-control').css('border-color', 'red');
    } else {
      $(this).find('button.form-control').css('border-color', '');
    }
  });

  // Validate password confirmation if exists
  const password = dis.find('input[name="password"]').val();
  const confirmPassword = dis.find('input[name="confirmpassword"]').val();
  if (confirmPassword !== undefined && password !== undefined) {
    if (confirmPassword !== password) {
      pass = false;
      dis.find('input[name="confirmpassword"]').css('border-color', 'red');
      dis.find('.response').addClass('active').text('Passwords do not match!');
      setTimeout(() => dis.find('.response').removeClass('active'), 2000);
    } else {
      dis.find('input[name="confirmpassword"]').css('border-color', '');
    }
  }



  if (pass) {
    let url = dis.attr('action');
    console.log(data);
    $.ajax({
      url: url,
      type: 'POST',
      headers: {'X-CSRF-TOKEN': token},
      data: data,
      cache: false,
      processData: false,
      contentType: false,
      success: function(response) {
        response = JSON.parse(response);

        if (response.html !== undefined) {
          $('.add_form_address').html(response.html);
          $('.add-address').show();

          $('input[name="Phone"],input[name="phone"],input[name="number"],input[type="phone"],input[name="meta[vendor_phone]"]').intlTelInput({
            initialCountry: "ae",
            nationalMode: false,
            autoInsertDialCode: true,
            separateDialCode: true
          });

          $('#confirm-address').attr('disabled', 'true');
        }
        if (dis.hasClass('has-response')) {
          // console.log("Appening response.messaage to the response div");
          // console.log(response.message);
          // dis.find('.response').html('<p class="my-2">' + response.message + '</p>').addClass('active');
          const responseBox = dis.find('.response');
            if (responseBox.length) {
                responseBox.html('<p class="my-2">' + response.message + '</p>').addClass('active');
                setTimeout(() => {
                    responseBox.removeClass('active').empty();
                }, 3000);
            } 
        }
        setupAddressForm();

        if (dis.hasClass('forgot') && response.status !== "1") {
          $('.response').html('<p class="my-2">' + response.message + '</p>').addClass('active');
        }

        if (dis.hasClass('signin')) {
          if (response.message.includes('Successfully')) {
            localStorage.setItem('authenticated_giftkingdom', JSON.stringify({ id: data.get('email_phone') }));
          } else {
            localStorage.removeItem('authenticated_giftkingdom');
          }
        }

        if (response.redirect !== '') {
          window.location.href = response.redirect;
        } else if (response.loggedin !== undefined) {
          window.location.href = window.location.href;
        }



      },
      error: function(xhr) {
        console.error('AJAX error:', xhr);
      }
    });
  }
});
</script>

<script defer src="<?= asset('assets/js/custom.js') ?>"></script>
<style type="text/css">
  .flatpickr-current-month input.cur-year {
    display: none !important;
  }

  .year-dropdown {
    margin-left: -40px !important;
    appearance: menulist;
    background: transparent;
    border: none;
    border-radius: 0;
    box-sizing: border-box;
    color: inherit;
    cursor: pointer;
    font-size: inherit;
    font-family: inherit;
    font-weight: 300;
    height: auto;
    line-height: inherit;
    margin: -1px 0 0 0;
    outline: none;
    padding: 0 0 0 .5ch;
    position: relative;
    vertical-align: initial;
    -webkit-box-sizing: border-box;
    -webkit-appearance: menulist;
    -moz-appearance: menulist;
    width: auto;
  }

  #signup .invalid,
  #signup .valid {
    top: 25%;
  }

  .invalid,
  .valid {
    position: absolute;
    right: 2%;
    top: 50%;
    display: none;
  }

  .invalid.active,
  .valid.active {
    display: block;
  }

  .pac-container {
    z-index: 10000 !important;
  }

  #tradein .form {
    display: block;
  }

  .address-detail,
  .form {
    display: none;
  }

  .address-detail.active,
  .form.active {
    display: block;
  }

  .map-overlap {
    position: absolute;
    right: 20px;
    top: 8px;
    min-width: 0;
    border-radius: 10px;
    background: #fff;
    border: solid 2px #6d7d36;
    color: #6d7d36;
    padding: 0.6rem 1rem;
    display: flex;
    gap: 0.3rem;
    align-items: center;
  }

  .col-md-12.map-url {
    position: relative;
  }

  .addressess-select .wrap {
    cursor: pointer;
  }

  .wrap.selected.mb-3 {
    border: solid 2px #6d7d36;
  }

  a.already-wish path {
    stroke: #fff;
  }

  a.already-wish {
    background: #6d7d36;
  }

  .is-selected .fancybox__content {
    width: 100% !important;
    height: 100% !important;
  }
</style>
<script>
(function ($) {
  const $btn  = $('#notification-dropdown');
  if (!$btn.length) return;

  const $wrap = $btn.closest('.bell_icon');
  const $menu = $wrap.find('.dropdown-menu2');
  let sentOnce = false; // avoid spamming while open

  function sendMarkRead() {
    const notifications = [];
    $wrap.find('.notification-item').each(function () {
      const id = $(this).data('id');
      const type = $(this).data('type');
      if (id && type) notifications.push({ id, type });
    });
    if (!notifications.length) return;

    $.ajax({
      url: "{{ route('notifications.markRead') }}",
      type: "POST",
      data: {
        _token: "{{ csrf_token() }}",
        notifications: notifications
      },
      success: function (res) {
        // remove the red badge
        $('.notification-count').remove();
        // optionally mark UI as read
        $wrap.find('.notification-item').addClass('is-read');
        console.log(res?.message || 'Marked read');
      },
      error: function (err) {
        console.error(err);
      }
    });
  }

  function isOpen() {
    return (
      $btn.hasClass('active') ||
      $btn.hasClass('show') ||
      $btn.attr('aria-expanded') === 'true' ||
      $menu.hasClass('show') ||
      $menu.hasClass('active')
    );
  }

  function checkOpen() {
    if (isOpen()) {
      if (!sentOnce) {
        sentOnce = true;
        sendMarkRead();
      }
    } else {
      // reset when closed so it can fire again next time
      sentOnce = false;
    }
  }

  // observe class/aria changes on button & menu
  const targets = [$btn.get(0), $menu.get(0)].filter(Boolean);
  const observer = new MutationObserver(checkOpen);
  targets.forEach(t =>
    observer.observe(t, { attributes: true, attributeFilter: ['class', 'aria-expanded'] })
  );

  // tiny fallback: also check after click
  $btn.on('click', function () {
    setTimeout(checkOpen, 0);
  });

})(jQuery);

</script>
<script>
$(document).ready(function () {
// when dropdown is fully shown

    const form = $('#event_inquiry');
    const selectedItem = form.find('.dropdown_select.selected');
    if (selectedItem.length) {
        const selectedText = selectedItem.text().trim();
        const selectedValue = selectedItem.attr('value');

        const container = selectedItem.closest('.child_option');

        container.find('.open-menu2').html(
            selectedText +
            ' <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">' +
            '<path d="M1 1L6 6L11 1" stroke="#333333" stroke-width="2" stroke-linecap="round" /></svg>'
        );

        container.find('.inputhide').val(selectedValue);
    }

    form.on('click', '.dropdown_select', function () {
        const selectedText = $(this).text().trim();
        const selectedValue = $(this).attr('value');
        const container = $(this).closest('.child_option');

        container.find('.open-menu2').html(
            selectedText +
            ' <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">' +
            '<path d="M1 1L6 6L11 1" stroke="#333333" stroke-width="2" stroke-linecap="round" /></svg>'
        );

        container.find('.inputhide').val(selectedValue);

        container.find('.dropdown_select').removeClass('selected');
        $(this).addClass('selected');
    });
});
    const dropdownButton = document.getElementById('sortDropdown');
    const dropdownOptions = document.querySelectorAll('.dropdown-option');
    const sortDropdownMenu = document.querySelector('.sortDropdownMenu');
    dropdownOptions.forEach(option => {
        option.addEventListener('click', function () {
            const selectedText = this.getAttribute('data-label');
            const selectedValue = this.getAttribute('data-value');

            dropdownButton.innerHTML = `${selectedText}
                <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L6 6L11 1" stroke="#333333" stroke-width="2" stroke-linecap="round" />
                </svg>`;
            const input = document.getElementById(selectedValue);
            if (input) {
                input.checked = true;
                dropdownButton.classList.remove('active');
                sortDropdownMenu.style.display = 'none';

            }
        });
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("#reviewForm");
    const submitBtn = document.querySelector("#reviewSubmitBtn");

    const wrapProduct = document.querySelector(".wrap.d-flex.align-items-center.justify-content-between");
    const productInputs = document.querySelectorAll("input[name='object_rating']");
    const productError = document.createElement("div");
    productError.style.color = "red";
    productError.style.fontSize = "14px";
    productError.style.marginTop = "5px";
    productError.style.marginBottom = "15px";
    productError.textContent = "Please select a product rating.";
    productError.style.display = "none";
    wrapProduct.insertAdjacentElement("afterend", productError);

    const wrapDelivery = document.querySelector(".wrap.wrap-two.d-flex.align-items-center.justify-content-between");
    const deliveryInputs = document.querySelectorAll("input[name='delivery_rating']");
    const deliveryError = document.createElement("div");
    deliveryError.style.color = "red";
    deliveryError.style.fontSize = "14px";
    deliveryError.style.marginTop = "5px";
    deliveryError.style.marginBottom = "15px";
    deliveryError.textContent = "Please select a delivery service rating.";
    deliveryError.style.display = "none";
    wrapDelivery.insertAdjacentElement("afterend", deliveryError);

    submitBtn.addEventListener("click", function(e) {
        let valid = true;
        let firstErrorElement = null;

        let productSelected = [...productInputs].some(input => input.checked);
        if (!productSelected) {
            productError.style.display = "block";
            valid = false;
            if (!firstErrorElement) firstErrorElement = productError;
        } else {
            productError.style.display = "none";
        }

        let deliverySelected = [...deliveryInputs].some(input => input.checked);
        if (!deliverySelected) {
            deliveryError.style.display = "block";
            valid = false;
            if (!firstErrorElement) firstErrorElement = deliveryError;
        } else {
            deliveryError.style.display = "none";
        }

        if (!valid) {
            e.preventDefault();

            // Scroll to the first error element
            firstErrorElement.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    });
});
</script>




<!-- <script src="<?= asset('assets/js/custom.min.js') ?>"></script> -->