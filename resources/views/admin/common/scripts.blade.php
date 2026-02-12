
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/sc-2.1.1/datatables.min.js"></script>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="{!! asset('admin/js/jquery.validate.js') !!}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{!! asset('admin/plugins/datepicker/bootstrap-datepicker.js') !!}"></script>
<script src="{!! asset('admin/plugins/colorpicker/bootstrap-colorpicker.min.js') !!}"></script>
<script src="{!! asset('admin/plugins/timepicker/bootstrap-timepicker.min.js') !!}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{!! asset('admin/dist/js/app.min.js') !!}"></script>
<script src="{{url('admin/js/clipboard.min.js')}}"></script>
<script src="{{url('admin/dist/apex/apexcharts.min.js')}}"></script>
<script src="{!! asset('admin/js/demo.js') !!}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- For CSV and PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<style>
	div.dataTables_processing>div:last-child>div{
		background: #6c7d36 !important;
	}
</style>
<script>
document.getElementById('selectAll').addEventListener('click', function() {
    const checkboxes = document.querySelectorAll('.form-checkbox');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = true;
    });
});

document.getElementById('unselectAll').addEventListener('click', function() {
    const checkboxes = document.querySelectorAll('.form-checkbox');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = false;
    });
});

    $(document).on('click', '.remove-product-item', function () {
        $(this).closest('.product-item').remove();
    });
    $(document).on('click', '.remove-repetitive', function () {
    $(this).closest('.repetitive_content').remove();
});

</script>
<style>
	.dt-buttons{
		margin-bottom: 10px !important;
	}
	/* Target only the th that contains a .select-all input */
th:has(.select-all)::before,
th:has(.select-all)::after {
    display: none !important;
    content: none !important;
}

</style>
{{-- <script>
document.addEventListener('DOMContentLoaded', function () {
	console.log('inside this:');
    // Get all the variant blocks
    const variantBlocks = document.querySelectorAll('.variations-append');

    variantBlocks.forEach(block => {
        const prodInput = block.querySelector('.prod');
        const saleInput = block.querySelector('.sale');

        function updateSaleMax() {
            const prodPrice = parseFloat(prodInput.value);
            if (!isNaN(prodPrice)) {
				console.log('price comes here:');
				console.log(prodPrice);
                saleInput.max = prodPrice - 1;
            }
        }

        // Set initial max
		console.log('updating intial max attr');
        updateSaleMax();

        // Update max when prod_price changes
        prodInput.addEventListener('input', updateSaleMax);
    });
});
</script> --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    const requiredFields = document.querySelectorAll(".required");

    requiredFields.forEach(field => {
        field.addEventListener("blur", () => validateField(field));
    });

    document.querySelectorAll("form").forEach(form => {
        form.addEventListener("submit", function (e) {
            let hasError = false;
            let firstInvalid = null;

            const fields = form.querySelectorAll(".required");

            fields.forEach(field => {
                if (!validateField(field)) {
                    hasError = true;

                    if (!firstInvalid) {
                        firstInvalid = field;
                    }
                }
            });

            if (hasError) {
                e.preventDefault();

                if (firstInvalid) {
                    // Switch to the tab containing the first invalid field
                    const tabContent = firstInvalid.closest(".tab");
                    if (tabContent) {
                        // Remove active from all tabs
                        document.querySelectorAll(".tabs-nav li").forEach(li => li.classList.remove("active"));
                        document.querySelectorAll(".tabs-content .tab").forEach(tab => tab.classList.remove("active"));

                        // Activate the tab with the first invalid field
                        tabContent.classList.add("active");
                        const tabId = "#" + tabContent.id;
                        const tabNav = document.querySelector(`.tabs-nav a[data-tab="${tabId}"]`);
                        if (tabNav) tabNav.closest("li").classList.add("active");
                    }

                    // Scroll to the first invalid field
                    scrollToField(firstInvalid);
                }
            }
        });
    });

});
</script>


<script>
function toggleLanguageFields(langValue) {
    console.log('Toggling language fields for:', langValue);

    const langEn = document.querySelector('.lang-en');
    const langAr = document.querySelector('.lang-ar');

    if (langValue === '2') {
        if (langEn) langEn.style.display = 'none';
        if (langAr) langAr.style.display = 'block';

        document.querySelectorAll('.var_prod_title_en').forEach(el => {
            el.style.display = 'none';
        });
        document.querySelectorAll('.var_prod_title_ar').forEach(el => {
            el.style.display = 'block';
        });
    } else {
        if (langEn) langEn.style.display = 'block';
        if (langAr) langAr.style.display = 'none';

        document.querySelectorAll('.var_prod_title_en').forEach(el => {
            el.style.display = 'block';
        });
        document.querySelectorAll('.var_prod_title_ar').forEach(el => {
            el.style.display = 'none';
        });
    }
}

</script>

        <script>

            $(document).ready(function () {
            var page = 2;

            function loadMoreImages() {
                $.ajax({
                    url: "{{url('admin/media/load_more')}}",
                    type: 'GET',
                    data: { page: page },
                    success: function (response) {
                        if (response != '') {
                          
                            $('#media-gallery').append(response);

                            page++;
                        } else {

                            $('.load_more').hide();
                        }
                    },
                    error: function (error) {
                        console.error('Error loading more images:', error);
                    },
                });
            }

            $('.load_more').on('click', function () {
                loadMoreImages();
            });
        });

        </script>
<style>
	.cke_notifications_area{display: none !important}
</style>
<script type="text/javascript">
	    jQuery('#customersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('admin/customers/customers-ajax') }}",
            type: 'GET',
        },
        columns: [
			        { data: 'select', orderable: false, searchable: false },

            { data: 'id', name: 'id' },
            { data: 'full_name', name: 'full_name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'action', orderable: false, searchable: false }
        ],
    });
		    jQuery('#vendorsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('admin/vendors/ajax') }}",
            type: 'GET',
			error: function(xhr) {
            if (xhr.status === 401 || xhr.status === 403) {
                window.location = "{{ asset('admin/login') }}";
            }
        }
        },
        columns: [
			        { data: 'select', orderable: false, searchable: false },

            { data: 'id', name: 'id' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'status', name: 'status' },
            { data: 'action', orderable: false, searchable: false }
        ],
    });
	jQuery('#abandonedCart').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/abandonedcart/ajax') }}",
            columns: [
                { data: 'cart_ID', name: 'cart_ID' },
                { data: 'customer_name', name: 'customer_name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'cart_count', name: 'cart_count' },
                { data: 'cart_total', name: 'cart_total' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
$('#customersWallet').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ url('admin/customer-wallet-ajax') }}",
        type: 'GET',
    },
    columns: [
        { data: 'id', name: 'id' },
        { data: 'user_email', name: 'user_email' },
        { data: 'type', name: 'type' },
        { data: 'status', name: 'status' },
        { data: 'points', name: 'points' },
        { data: 'comment', name: 'comment' },
        { data: 'date', name: 'date' },
        { data: 'action', orderable: false, searchable: false }
    ]
});


const tableEventInquiries = $('#eventInquiries').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ url('admin/event-inquiry-ajax') }}",
        type: "GET"
    },
columns: [
        { data: 'select', orderable: false, searchable: false },

	
    { data: 'serial', name: 'serial', orderable: false, searchable: false },
    { data: 'name', name: 'name' },
    { data: 'email', name: 'email' },
    { data: 'event', name: 'event' },
    { data: 'received_date', name: 'created_at' },
    { data: 'event_date', name: 'event_date' },
	
		// 🔥 Add hidden export columns
		{ data: 'phone', visible: false },
		{ data: 'guest_count', visible: false },
		{ data: 'message', visible: false },
    { data: 'action', orderable: false, searchable: false },
],

    order: [[5, 'desc']],  // 'received_date' column index shifted to 5 because of checkbox
dom: 'Blfrtip',
    buttons: [
        {
            extend: 'csv',
            filename: 'Event_Inquiries',
            text: 'Download CSV',
exportOptions: {
    columns: [1, 2, 3, 4, 5, 6,7 ,8, 9] // 8 = phone, 9 = guest_count, 10 = message
},


            className: 'custom-btn'
        },
        {
            extend: 'pdf',
            title: 'Event Inquiries',
            filename: 'Event_Inquiries',
            text: 'Download PDF',
exportOptions: {
    columns: [1, 2, 3, 4, 5, 6,7 ,8, 9] // 8 = phone, 9 = guest_count, 10 = message
},


            className: 'custom-btn'
        }
    ]
});



	    jQuery('#inventoryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('admin/product/inventory/inventory-ajax') }}",
            type: 'GET'
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'stock', name: 'stock' },
            { data: 'purchase_price', name: 'purchase_price' },
            { data: 'sell_price', name: 'sell_price' },
            { data: 'author', name: 'author' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
    });
	        //currencies Report
        jQuery('#currenciesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
            url: "{{ asset('admin/currencies/display-ajax') }}", // Your new route
            type: 'GET'
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
            { data: 'code', name: 'code' },
            { data: 'symbol', name: 'symbol' },
            { data: 'placement', name: 'placement' },
            { data: 'decimal_places', name: 'decimal_places' },
            { data: 'value', name: 'value' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],

    });
	let couponsTable = jQuery('#couponsTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ url('admin/coupons/coupons-ajax') }}",
        type: 'GET',

    },
    columns: [
        {
            data: 'select',
            orderable: false,
            searchable: false
        },
        { data: 'coupon_ID', name: 'coupon_ID' },
        { data: 'coupon_code', name: 'coupon_code' },
        { data: 'discount_type', name: 'discount_type' },
        { data: 'discount_amount', name: 'discount_amount' },
        { data: 'expiry_date', name: 'expiry_date' },
        {
            data: 'action',
            orderable: false,
            searchable: false
        }
    ]
});
 const tableContact = $('#contactInquiries').DataTable({
    processing: true,
    serverSide: true,
    lengthChange: true,
    ajax: {
      url: "{{ url('admin/contact-form-ajax') }}",
      type: "GET",
	  error: function(xhr) {
            if (xhr.status === 401 || xhr.status === 403) {
                window.location = "{{ asset('admin/login') }}";
            }
        }
    },
    columns: [
      { data: 'select', orderable: false, searchable: false },
      { data: 'serial', name: 'serial', orderable: false, searchable: false },
      { data: 'name', name: 'name' },
      { data: 'email', name: 'email' },
      { data: 'subject', name: 'subject' },
      { data: 'message', name: 'message' },
      @if(Auth::check() && Auth::user()->role_id != 4) 
        { data: 'support_category', name: 'support_category' },
      @endif
      { data: 'received_date', name: 'received_date' },
      { data: 'action', orderable: false, searchable: false }
    ],
    order: [[6, 'desc']],
    dom: 'Blfrtip',

    buttons: [
      {
        extend: 'csv',
        filename: 'Contact Form',
        text: 'Download CSV',
        exportOptions: {
          columns: [
            1, 2, 3, 4, 5, 6, 
                                                @if(Auth::check() && Auth::user()->role_id != 4)
              7,
            @endif
          ]
        },
        className: 'custom-btn'
      },
      {
        extend: 'pdf',
        title: 'Contact Form Inquiries',
        filename: 'Contact Form',
        text: 'Download PDF',
        exportOptions: {
          columns: [
            1, 2, 3, 4, 5, 6,
                                                @if(Auth::check() && Auth::user()->role_id != 4)
              7,
            @endif
          ]
        },
        className: 'custom-btn'
      }
    ]
  });



// $('#perPageSelect').on('change', function () {
//     tableContact.page.len($(this).val()).draw();
// });
        let reviewsTable = jQuery('#reviewsTable').DataTable({
        processing: true,
        serverSide: true,
        lengthChange: true, // hide default dropdown
        // pageLength: parseInt($('#perPageSelect').val()),
        ajax: {
            url: "{{ url('admin/reviews-ajax') }}",
            type: 'GET',
			error: function(xhr) {
            if (xhr.status === 401 || xhr.status === 403) {
                window.location = "{{ asset('admin/login') }}";
            }
        },
            data: function (d) {
                d.length = $('#perPageSelect').val(); // pass custom per-page value
            }
        },
        columns: [
            {
                data: 'select',
                orderable: false,
                searchable: false
            },
            { data: 'review_ID', name: 'review_ID' },
            { data: 'product_title', name: 'product_title' },
            { data: 'customer_email', name: 'customer_email' },
            { data: 'review', name: 'review' },
            { data: 'status', name: 'status' },
            {
                data: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

    // $('#perPageSelect').on('change', function () {
    //     reviewsTable.page.len(parseInt($(this).val())).draw();
    // });
	        jQuery('#salesReport').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: true,
            ajax: {
                url: "{{ asset('admin/reports/sales-report-ajax') }}", 
                type: 'GET',
				error: function(xhr) {
            if (xhr.status === 401 || xhr.status === 403) {
                window.location = "{{ asset('admin/login') }}";
            }
        }
            },
            columns: [
             { data: 'ID', name: 'ID' },
             { data: 'customer_email', name: 'customer_email' },
             { data: 'total', name: 'total' },
             { data: 'date', name: 'date' }


         ]
     });
    const revenueChartEl = document.querySelector("#revenue-chart");
    const chartTypeSelect = document.querySelector("#chartType");

    // Get initial data based on select value (e.g. "month", "monthly", "yearly")
    function getChartData(type) {
        const raw = revenueChartEl.getAttribute(`data-mos-${type}`);
        return raw ? JSON.parse(raw) : { keys: [], values: [] };
    }

    // Load initial data
    let data = getChartData(chartTypeSelect.value);

    // Line/area chart colors
    let defaultColors = ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"];
    let dataColors = revenueChartEl.dataset.colors;
    let chartColors = dataColors ? dataColors.split(",") : defaultColors;

    // Line chart config
    let revenueChartOptions = {
        series: [{
            name: "Orders",
            type: "area",
            data: data.values
        }],
        chart: {
            height: 300,
            type: "line",
            toolbar: { show: false }
        },
        stroke: {
            dashArray: [0],
            width: [2],
            curve: "smooth"
        },
        fill: {
            opacity: [.1],
            type: ["solid"]
        },
        markers: {
            size: [0],
            strokeWidth: 2,
            hover: { size: 4 }
        },
        xaxis: {
            categories: data.keys,
            axisTicks: { show: false },
            axisBorder: { show: false }
        },
        yaxis: {
            min: 0,
            labels: {
                formatter: (val) => val,
                offsetX: -15
            },
            axisBorder: { show: false }
        },
        grid: {
            show: true,
            xaxis: { lines: { show: false } },
            yaxis: { lines: { show: true } },
            padding: { top: 0, right: -15, bottom: 15, left: -15 }
        },
        legend: {
            show: true,
            horizontalAlign: "center",
            offsetX: 0,
            offsetY: -5,
            markers: { width: 9, height: 9, radius: 6 },
            itemMargin: { horizontal: 10, vertical: 0 }
        },
        plotOptions: {
            bar: {
                columnWidth: "50%",
                barHeight: "70%",
                borderRadius: 3
            }
        },
        colors: chartColors,
        tooltip: {
            shared: true,
            y: [{
                formatter: (o) => o ?? o
            }]
        }
    };

    let revenueChart = new ApexCharts(revenueChartEl, revenueChartOptions);
    revenueChart.render();

    // 🔄 Change chart data when select changes
    chartTypeSelect.addEventListener("change", function () {
        let newData = getChartData(this.value);
        revenueChart.updateOptions({
            xaxis: { categories: newData.keys },
            series: [{ name: "Orders", data: newData.values }]
        });
    });

    // 🔘 Radial bar chart setup
    const radialData = $("#multiple-radialbar").data("users") || {};
    const radialColors = $("#multiple-radialbar").data("colors")?.split(",") || ["#6C757D", "#FFBC00", "#727CF5", "#0ACF97"];

    let radialSeries = [], radialLabels = [];

    for (let key in radialData) {
        radialSeries.push(radialData[key].total);
        radialLabels.push(key);
    }

    let radialChartOptions = {
        chart: {
            height: 770,
            type: "radialBar"
        },
        plotOptions: {
            circle: {
                dataLabels: {
                    showOn: "hover"
                }
            },
            radialBar: {
                dataLabels: {
                    name: { show: false },
                    value: { show: true }
                }
            }
        },
        stroke: {
            lineCap: "round"
        },
        colors: radialColors,
        series: radialSeries,
        labels: radialLabels,
        responsive: [{
            breakpoint: 380,
            options: { chart: { height: 260 } }
        }]
    };

    const radialChart = new ApexCharts(document.querySelector("#multiple-radialbar"), radialChartOptions);
    radialChart.render();
</script>

<script type="text/javascript">
        jQuery('#outStockTable').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: true,
            ajax: {
                url: "{{ asset('admin/reports/out-stock-ajax') }}",
                type: 'GET',
				error: function(xhr) {
            if (xhr.status === 401 || xhr.status === 403) {
                window.location = "{{ asset('admin/login') }}";
            }
        }
            },
            columns: [
                { data: 'ID', name: 'ID' },
                {
                    data: 'prod_image',
                    name: 'prod_image',
                    render: function (data) {
                        return `<img src="{{asset('')}}/${data}" width="50" height="50" />`;
                    }
                },
                { data: 'prod_title', name: 'prod_title' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
                
            ]
        });
        // jQuery('#outStockTable').removeClass('table-bordered table-striped').wrap('<div class="table-wrap"></div>')
    
        jQuery('#lowStockTable').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: true,
            
            ajax: {
                url: "{{ asset('admin/reports/low-stock-ajax') }}",
                type: 'GET',
				error: function(xhr) {
            if (xhr.status === 401 || xhr.status === 403) {
                window.location = "{{ asset('admin/login') }}";
            }
        }
            },
            columns: [
                { data: 'ID', name: 'ID' },
                {
                    data: 'prod_image',
                    name: 'prod_image',
                    render: function (data) {
                        return `<img src="{{asset('')}}/${data}" width="50" height="50" />`;
                    }
                },
                { data: 'prod_title', name: 'prod_title' },
                { data: 'prod_quantity', name: 'prod_quantity' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
                
            ]
        });

		        jQuery('#customerOrderTotal').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ asset('admin/reports/customers-total-ajax') }}", 
                type: 'GET',
				error: function(xhr) {
            if (xhr.status === 401 || xhr.status === 403) {
                window.location = "{{ asset('admin/login') }}";
            }
        }
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'order_count', name: 'order_count' },
                { data: 'total', name: 'total' },


            ]
        });
		   var table = $('#ordersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('admin/orders/orders-ajax') }}",
            type: 'GET',
			error: function(xhr) {
            if (xhr.status === 401 || xhr.status === 403) {
                window.location = "{{ asset('admin/login') }}";
            }
        }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'email', name: 'email' },
            { data: 'created_at', name: 'created_at' },
            { data: 'order_status', name: 'order_status' },
            { data: 'order_total', name: 'order_total' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
    $('#perPageSelect').on('change', function () {
        table.page.len($(this).val()).draw();
    });
		// OSAMA

	$(document).ready(function() {

		jQuery('.sidebar-toggle').click(function() {

			jQuery('.logo1,.logo2').toggle()
		})

		jQuery('body').delegate('.careerFilterInr li a','click',function() {

			jQuery(this).parents('.child_option').find('button')[0].childNodes[0].data = jQuery(this).text();

			let val = jQuery(this).attr('value')

			val == '' || val == undefined || val == null ? val == jQuery(this).text() : ''

			jQuery(this).parents('.child_option').find('.inputhide').val(val)
			jQuery(this).parents('.ct-slct').find('.inputhide').val(val)

		});

		jQuery('body').delegate(".careerFilter .child_option",'click',function(e){

			e.stopPropagation();

			var abc = $(this).find(".open-menu2").hasClass('active');

			if (abc == true) {

				$(this).find(".dropdown-menu2").slideUp("fast");

				$(".open-menu2").removeClass('active');

			}

			else{

				$(".dropdown-menu2").slideUp("fast");

				$(this).find(".dropdown-menu2").slideDown("fast");

				$(".open-menu2").removeClass('active');

				$(this).find(".open-menu2").addClass('active');

			}

		});

		jQuery(".coupon").flatpickr({minDate:'today'});
		jQuery(".dob").flatpickr({maxDate:'today'});

		jQuery(".flatpickr").flatpickr();

		jQuery('.value_type').change(function() {

			if( jQuery(this).val() == 'image' ){

				jQuery('.image_div').show()
			}else{

				jQuery('.image_div').hide()
			}

		})

		// Charts

		//Sales This Month

		jQuery('.analytics').each(function() {

			let attr = jQuery(this).attr('id')

			let ctx = document.getElementById(attr);

			let data = '';

			let datatake = {};

			if( ctx != undefined ){

				data = jQuery(this).attr('chart-data')

				data = JSON.parse(data)

				console.log(data);

				Highcharts.chart(attr, {
					chart: {
						type: 'column',
						renderTo: ctx
					},
					title: {
						text: 'Orders'
					},
					xAxis: {
						categories: data.keys,
						crosshair: true
					},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
						'<td style="padding:0"><b>{point.y:.1f} orders</b></td></tr>',
						footerFormat: '</table>',
						shared: true,
						useHTML: true
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
					series: [{
						name: 'Orders',
						data: data.values

					}]
				});

			}
		})

		function replaceGlobally(original, searchTxt, replaceTxt){

			const regex = new RegExp(searchTxt, 'g');

			return original.replace(regex, replaceTxt) ;
		}

		let selectcheck = jQuery('.select2')

		if( selectcheck.length != 0 ){
			
			selectcheck.select2();

		}

		let ajaxurl = '{{asset("admin/template")}}';

		let ajaxfieldurl = '{{asset("admin/template/fields")}}';

		//TINMYMCE EDITOR
		jQuery('.quilleditor').each(function() {
			CKEDITOR.replace(this);
		});
		
		//Template

		jQuery('#page_type').change(function() {

			let file = jQuery(this).val();

			if( file == 'default' ){

				jQuery('.content-insert').html('');
			}
			else{

				jQuery.ajax({

					type : 'POST',

					url  : ajaxurl,

					data : {direction : file },

					headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

					success:function(data){

						jQuery('.content-insert').html(data);

						let check = jQuery('.quilleditor')

						if( check.length != 0 ){

							jQuery('.quilleditor').each(function() {
								CKEDITOR.replace(this);
							});

						}
					}

				});
			}

		})

			//AUTO SLUG

		jQuery('.pagetitle').blur(function() {

			let slug = jQuery(this).val().toLowerCase()

slug = slug.replace(/[^a-zA-Z0-9 ]/g, "");

			slug = slug.split(' ');

			let actual;

			let concat = '';

			for( i=0 ; i < slug.length; i++ ){

				if( i < ( (slug.length-1) ) ){ concat = '-'; }

				else{ concat = '';  }

				actual += slug[i]+concat

			}

			actual =	actual.replace('undefined','');

			for(i=0; i < 11 ; i++){

				actual =	actual.replace(',','');

				actual =	actual.replace('.','');

				actual =	actual.replace('---','-');

				actual =	actual.replace('--','-');

			}

			jQuery('input[name="slug"]').val(actual)
			
			jQuery('.slug').val(actual)

		})


		//IMAGE UPLOADER CUSTOM


		//Modal Open Function

		let popupelem;

		jQuery('body').delegate('.uploader' , 'click' , function(e) {

			e.preventDefault();

			if($(this).hasClass('listing')){
				$('#refresh').hide();
				$('#load-gallery').hide();
			}
			else{
				$('#refresh').show();
				$('#load-gallery').show();
			}

			jQuery('#imgselect .imageSelectWrap').addClass('loader');

			jQuery('.imguploader').show();

			jQuery('.imguploader').addClass('show');

			let dis = jQuery(this);

			let type = jQuery(this).data('type') ? jQuery(this).data('type') : '' 

			let val = jQuery(this).siblings('input').val() ? jQuery(this).siblings('input').val() : ''
			
			let load = 80

			jQuery.ajax({

				type: 'POST',

				url: '{{asset("admin/media/gallery")}}',

				data:{type:type,val:val,load:load},

				headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

				success : function(response) {

					response = JSON.parse(response)

					jQuery('.imguploader .imgesWrap').html(response.images)

					if( !dis.hasClass('detail') ){

						jQuery('.imguploader #imginfo').html(response.imageinfo)

					}

					jQuery('.modal-footer .insert_image').attr('data-url',response.urls);

					jQuery('.modal-footer .insert_image').attr('data-images',response.ids);

					if( JSON.parse(response.ids).length > 0 ){

						jQuery('.insert_image').removeAttr('disabled');

					}

					let images = jQuery('.uploaded_image img')

					images.on('load',function() {

						jQuery(this).parents('.uploaded_image').removeClass('blurred')

					})

					setTimeout(function() {
						jQuery('#imgselect .imageSelectWrap').removeClass('loader');

					},500)

				}
			})

			if( jQuery(this).hasClass('listing') ){
				
				jQuery('.imguploader .imgesWrap').attr('data-type' , 'multiple')

				jQuery('a[data-tab="#imgselect"]').parents('li').addClass('d-none');

				jQuery('a[data-tab="#imgupload"]').click();

				jQuery('.modal-footer .insert_image ').addClass('d-none')

			}
			else if( jQuery(this).hasClass('detail') ){
				
				jQuery('.imguploader .imgesWrap').attr('data-type','multiple')

				jQuery('a[data-tab="#imgselect"]').click();

				jQuery('.imguploader .imageInfo').html( jQuery(this).siblings('imageinfo').html() )

				jQuery('.modal-footer .insert_image ').addClass('d-none')

			}
			else{

				popupelem = jQuery(this);

				jQuery('.imguploader .imgesWrap').attr('data-type' , jQuery(this).data('type'))

				jQuery('a[data-tab="#imgselect"]').click();

			}

		})

		//Images Load More

		jQuery('body').delegate('#load-gallery' , 'click' , function(e) {

			jQuery('#imgselect .imageSelectWrap').addClass('loader');

			let load = parseInt( jQuery(this).attr('data-load') )

			let type = jQuery('#imgselect .imgesWrap').data('type') == 'multiple' ? true : false  

			let val = jQuery('.insert_image').data('images')

			jQuery(this).attr('data-load',( load  + 10 ))

			jQuery.ajax({

				type: 'POST',

				url: '{{asset("admin/media/loadmore")}}',

				data:{load:load,images:val,gallery:type},

				headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

				success : function(response) {

					response = JSON.parse(response)

					jQuery('.imguploader .imgesWrap').append(response.images)
					
					let images = jQuery('.uploaded_image img')

					images.on('load',function() {

						jQuery(this).parents('.uploaded_image').removeClass('blurred')

					})

					setTimeout(function() {
						jQuery('#imgselect .imageSelectWrap').removeClass('loader');

					},500)

				}
			})
		})


		// Image Modal Refresh

		jQuery('body').on('keyup','.search_img', function() {
			// alert('a');
			var search_img=jQuery(this).val();
			jQuery('#imgselect .imageSelectWrap').addClass('loader');

			jQuery.ajax({

				type: 'POST',

				url: '{{asset("admin/media/refresh")}}',

				data:{type:jQuery('#imgselect .imgesWrap').data('type'),search_img:search_img},

				headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

				success : function(response) {

					response = JSON.parse(response)

					jQuery('.imguploader .imgesWrap').html(response.images)

					jQuery('.imguploader #imginfo').html(response.imageinfo)

					jQuery('.modal-footer .insert_image').attr('data-url','');

					jQuery('.modal-footer .insert_image').attr('data-images','');
					
					let images = jQuery('.uploaded_image img')

					images.on('load',function() {

						jQuery(this).parents('.uploaded_image').removeClass('blurred')

					})


					setTimeout(function() {
						jQuery('#imgselect .imageSelectWrap').removeClass('loader');

					},500)

				}
			})
		});
		jQuery('body').delegate('#refresh' , 'click' , function() {
			
			jQuery('#imgselect .imageSelectWrap').addClass('loader');

			jQuery.ajax({

				type: 'POST',

				url: '{{asset("admin/media/refresh")}}',

				data:{type:jQuery('#imgselect .imgesWrap').data('type')},

				headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

				success : function(response) {

					response = JSON.parse(response)

					jQuery('.imguploader .imgesWrap').html(response.images)

					jQuery('.imguploader #imginfo').html(response.imageinfo)

					jQuery('.modal-footer .insert_image').attr('data-url','');

					jQuery('.modal-footer .insert_image').attr('data-images','');
					
					let images = jQuery('.uploaded_image img')

					images.on('load',function() {

						jQuery(this).parents('.uploaded_image').removeClass('blurred')

					})

					setTimeout(function() {
						jQuery('#imgselect .imageSelectWrap').removeClass('loader');

					},500)

				}
			})

		})


		//Modal Close Function

		jQuery('.btn-close,.close-custom').click(function() {

			jQuery('.modal').hide();

			jQuery('.modal').removeClass('show');

			jQuery('.uploaded_image').removeClass('selected');

			jQuery('.insert_image').attr('data-images','');

			jQuery('.tab-nav').removeClass('d-none')

			jQuery('.modal-footer .insert_image ').removeClass('d-none')

		})

		jQuery('body').delegate('.alt-form input','blur', function() {

			let dis = jQuery(this)

			let text = jQuery(this).val()
			
			let id = jQuery(this).attr('id')

			jQuery.ajax({

				type: 'POST',

				url: '{{asset("admin/media/updatealt")}}',

				data:{val:text,id:id},

				headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

				success : function(response) {

					dis.after('<svg class="tick" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 101.6"><defs><style>.cls-1{fill:#10a64a;}</style></defs><title>tick-green</title><path class="cls-1" d="M4.67,67.27c-14.45-15.53,7.77-38.7,23.81-24C34.13,48.4,42.32,55.9,48,61L93.69,5.3c15.33-15.86,39.53,7.42,24.4,23.36L61.14,96.29a17,17,0,0,1-12.31,5.31h-.2a16.24,16.24,0,0,1-11-4.26c-9.49-8.8-23.09-21.71-32.91-30v0Z"/></svg>')

					setTimeout(function() { dis.siblings('svg').remove() },2000)

				}
			})

		})

		// Drag And Drop Image Uploader


		//Detect Files
		jQuery(".imguploader").on('dragenter', function(e) {

			jQuery(".getfiles").addClass("active");

		});


		jQuery(".getfiles").on('dragenter', function() {

			jQuery(".getfiles").addClass("active");

		});

		jQuery(".getfiles").on('dragleave', function() {

			jQuery(".getfiles").removeClass("active");

		});


			//Ajax On Image Drop

		jQuery(".getfiles").on('drop', function(e) {

			jQuery('.uploaded_image').removeClass('selected');

			e.preventDefault();

			e.stopPropagation();

			if( e.originalEvent.dataTransfer ){

				if( e.originalEvent.dataTransfer.files.length ) {
					let dFiles = e.originalEvent.dataTransfer.files;

					upload_image(dFiles)

					jQuery('.insert_image').removeAttr('disabled');

				}

			}

			jQuery(".getfiles").removeClass("active");

			return false;

		});

		jQuery(".getfiles").on('dragover', function(e) {

			e.preventDefault();

		});


		// Drag And Drop End


		//Upload On File Select

		jQuery('#image_selector').change(function() {

			let  files = jQuery(this);

			files = files[0].files

			upload_image(files)

			jQuery('.insert_image').removeAttr('disabled');
		})

		//Image Upload Ajax

		function upload_image(files){

			jQuery('#imgselect .imageSelectWrap').addClass('loader');

			let actual = new FormData()

			let uploaderType = jQuery('.imgesWrap').attr('data-type');

			let ids = paths = [] ;

			let prevImgs = jQuery('.insert_image').data('images')

			let prevUrls = jQuery('.insert_image').data('url')

			prevImgs != '' ? prevImgs = JSON.parse(prevImgs) : prevImgs = []
			
			// prevUrls != '' ? prevUrls = JSON.parse(prevUrls) : prevUrls = []

			let j = 0 

			let selectedImgs = '';

			for (i = 0;  i < files.length; i++) {

				jQuery('.insert_image').removeAttr('disabled');
				
				actual.append('file',files[i])

				jQuery.ajax({

					type: 'POST',

					url: '{{asset("admin/media/uploadimage")}}',

					data : actual,

					headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

					contentType: false,

					processData: false,

					success:function(response) {

						let img = JSON.parse(response)

						jQuery('a[data-tab="#imgselect"]').click();

						jQuery('.imgesWrap').prepend(img.html);

						if(  uploaderType == 'multiple' ){

							prevImgs.push(img.id)
							
							prevUrls.push(img.path)

						}
						else{

							prevImgs = [img.id]

							prevUrls = [img.path]

						}

						console.log(prevImgs)
						
						jQuery('.insert_image ').attr('data-images', JSON.stringify(prevImgs) );

						jQuery('.insert_image ').attr('data-url', JSON.stringify(prevUrls) );

						selectedImgs = jQuery('.uploaded_image.selected');

						jQuery('.uploaded_image.selected').removeClass('selected')

						selectedImgs.each(function() {

							jQuery(this).click()

						})
if (window.location.pathname.endsWith('/admin/media/add')) {
							setTimeout(function() {
								window.location.reload();
							}, 200);
						}
					}

				})

				if( i >= files.length || i == (files.length - 1) ){

					let images = jQuery('.uploaded_image img')

					images.on('load',function() {

						jQuery(this).parents('.uploaded_image').removeClass('blurred')

					})

					setTimeout(function() {
						jQuery('#imgselect .imageSelectWrap').removeClass('loader');

					},500)

				}

			}



		}


		//Image Select

		jQuery('body').delegate('.uploaded_image' , 'click' , function() {

			let uploaderType = jQuery('.imgesWrap').attr('data-type')

			let imgUrl = String( jQuery(this).find('img').attr('src') )

			let currentId = String( jQuery(this).data('imageid') )

			let prevUrls = jQuery('.insert_image').attr('data-url')

			let prevImgs = jQuery('.insert_image').attr('data-images')

			//For Image Galleries

			if(  uploaderType == 'multiple' ){

				prevUrls != '' ? prevUrls = JSON.parse(prevUrls) : prevUrls = [] 

				prevImgs != '' ? prevImgs = JSON.parse(prevImgs) : prevImgs = []

				if( jQuery(this).hasClass('selected') ){

					jQuery(this).removeClass('selected')

					prevImgs.splice(prevImgs.indexOf(currentId),1)

					prevUrls.splice(prevUrls.indexOf(imgUrl),1)

					jQuery('.imageSelectWrap #imginfo .imageInfo[data-deleteid="'+ jQuery(this).data('imageid') +'"]').remove()


				}else{

					prevImgs.push(currentId)

					prevUrls.push(imgUrl)

					jQuery(this).addClass('selected');

					jQuery('.imageSelectWrap #imginfo').prepend(jQuery(this).find('imageinfo').html())

				}


			}
			else{

				jQuery('.uploaded_image').removeClass('selected');

				jQuery(this).addClass('selected');

				prevImgs = [currentId]

				prevUrls = [imgUrl]

				jQuery('.imageSelectWrap #imginfo').html(jQuery(this).find('imageinfo').html())

			}

			jQuery('.insert_image').attr('data-images', JSON.stringify( prevImgs ) );

			jQuery('.insert_image').attr('data-url', JSON.stringify( prevUrls ) );

			let selectedImgs =  jQuery('.uploaded_image.selected');

			if( selectedImgs.length == 0 ){ jQuery('.insert_image').attr('disabled','true');}

			else{ jQuery('.insert_image').removeAttr('disabled');}


		})


		//Images and id append to field
		jQuery('body').delegate('.insert_image' , 'click', function() {

			let ids = JSON.parse(jQuery(this).attr('data-images'));

			let url = JSON.parse(jQuery(this).attr('data-url'));

			let str = []

			for(var b in ids)
				str.push(ids[b]);
			
			jQuery('.uploaded_image').removeClass('selected');

			popupelem.siblings('input').val(str.toString());

			if( url.length > 1 ){

				console.log('worksing')

				let checkrow = popupelem.siblings('#images');

				let imghtml = '';

				if( checkrow.length === 0 ){

					popupelem.after('<div class="row" id="images"></div>')
				}

				let col = Math.round(12 / url.length )

				col < 2 ? col = 2 : ''

				for(var i in url){

					if( url[i] != '' && url[i] != null ){

						imghtml+= '<div class="col-md-'+col+'"><img src="'+ url[i] +'" class="w-100 p-0 h-100"></div>';

					}

				}

				popupelem.siblings('#images').html(imghtml)

			}
			else{

				popupelem.siblings('video').find('source').attr('src',url[0]);

				popupelem.siblings('img').removeClass('d-none').attr('src',url[0]);

			}

			popupelem.parents('.featuredWrap').addClass('featured');

			jQuery(this).attr('data-images','');

			jQuery(this).attr('data-url','');

			jQuery('.imguploader').hide().removeClass('show')

		});


		// Gallery Remove Image

		jQuery('body').delegate('.gallery-image-remove' , 'click' , function() {

			let id = String(jQuery(this).data('id'))

			let url = String(jQuery(this).siblings('img').attr('src'))

			let images = jQuery('.modal-footer .insert_image').data('images')

			let urls = jQuery('.modal-footer .insert_image').data('url')

			jQuery(this).parents('.imageInfo').remove()

			jQuery('.uploaded_image.selected[data-imageid="'+id+'"]').removeClass('selected')

			images.splice(images.indexOf(id),1)
			
			urls.splice(urls.indexOf(url),1)

			jQuery('.modal-footer .insert_image').attr( 'data-images',JSON.stringify(images) ) 

		})


		// Modal Close
		jQuery('body').delegate('.close-modal-global' , 'click' , function() {

			jQuery('.modal').hide();

			jQuery('.modal').removeClass('show');

			jQuery('.tab-nav').removeClass('d-none')

			jQuery('.modal-footer .insert_image ').removeClass('d-none')

		})


			//Tabs Function
		jQuery('body').delegate('.tabs-nav .tab-link' , 'click' , function(){

			let tab = jQuery(this).data('tab');

			check = jQuery(this).hasClass('modal-link')

			if( check ){

				jQuery('.imguploader .tab-nav').removeClass('active');

				jQuery(this).parents('li').addClass('active');

				jQuery('.imguploader .tab').removeClass('active');

				jQuery(tab).addClass('active');


			}
			else{

				jQuery('.tab-nav').removeClass('active');

				jQuery(this).parents('li').addClass('active');

				jQuery('.tab').removeClass('active');

				jQuery(tab).addClass('active');

			}

		});

			//Tabs Function
		jQuery('.user-menu').click(function() {

			jQuery('.dropdown-menu').toggle();

		})


		// Category Select2

		jQuery('#parent_ID').each(function() {

			let url

			jQuery(this).hasClass('deals') ? url = '<?=asset('admin/deals/ajax')?>' : url = '<?=asset('admin/category/ajax')?>'

			jQuery(this).select2({

				ajax: {

					url: url,

					dataType: 'json',

					type:'post',

					headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')  },

					data: function (params) {

						var query = {

							search: params.term,

							type: 'user_search',

						}

						return query;

					},

					processResults: function (data) {

						return {

							results: data

						};

					}

				},

				placeholder: 'Parent Category',

				minimumInputLength: 1,

			})

		})

			//Taxonomy Ajax Functions

		jQuery('.js-form').on('submit', function(e) {

    e.preventDefault();

    const form = jQuery(this);
    const url = form.attr('action');
    const token = form.find('input[name="_token"]').val();
    const data = new FormData(form[0]);

    // Validation
    let hasError = false;
    let firstInvalid = null;

    form.find(".required").each(function() {
        if (!validateField(this)) {
            hasError = true;
            if (!firstInvalid) firstInvalid = this;
        }
    });

    if (hasError) {
        scrollToField(firstInvalid);
        return;
    }

    form.find("button[type=submit]").attr('disabled', true);

    jQuery.ajax({
        type: 'POST',
        url: url,
        headers: { 'X-CSRF-TOKEN': token },
        data: data,
        cache: false,
        processData: false,
        contentType: false,

        success: function(response) {

            if (url.includes('/admin/category/create') || url.includes('/admin/taxonomy/create')) {
                window.location.reload();
                return;
            }

            jQuery('.replace-table').html(response);

            // Reset form fields
            form[0].reset();

            // Reset Select2 properly
            $('.select2').val(null).trigger('change');

            // Reset images
            jQuery('.featuredWrap img').addClass('d-none');
            jQuery('.featuredWrap').removeClass('featured');

            // Re-init DataTable
            if ($.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().destroy();
            }
            $('#example1').DataTable({ order: [], paging: false, info: false });

            form.find('button').prop('disabled', false);
        },

        error: function() {
            form.find('button').prop('disabled', false);
        }
    });

});


		jQuery('body').delegate('.show-children','click',function() {

			let id = jQuery(this).attr('data-id')

			let parent = jQuery(this).attr('data-parent')

			jQuery.ajax({
				
				url: '<?=asset('admin/category/showchildren/')?>/'+id+'/'+parent,
				
				type: 'POST',

				headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

				success:function(response) {

					jQuery('.replace-table').html(response)

					jQuery('#example1').DataTable({order: [],"bPaginate": false,bInfo:false});

				}
			})

		})



		//////////////////// DEVELOPER JS \\

		// FIELDS APPEND

		jQuery('body').delegate('.field-list li' , 'click' ,function() {

			jQuery('.section-box form').addClass('collapsed');

			let condition = jQuery(this).hasClass('repetative')

			let field = jQuery(this).attr('type')

			let count = jQuery(this).parents('.field-list').attr('data-count')

			if(field == 'repetitive'){

				jQuery('.field-list li').addClass('repetative')

				jQuery('.reset_repetative').removeClass('d-none')
			}

			jQuery.ajax({
				
				type : 'POST',
				
				url : ajaxfieldurl,

				data:{data: [field , count] },

				headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

				success:function(response){

					response = JSON.parse(response)

					jQuery('.field-list').attr('data-count',response.count)

					jQuery('.fields-view').append(response.view)
					
					if( field == 'section' ){

						jQuery('.fields-array').append(response.data)

					}else if(condition){

						jQuery('.fields-array .repetitive').last().append(response.data)

					}
					else{

						jQuery('.fields-array ul').last().append(response.data)

					}


				}


			})

		})

		jQuery('#reset').click(function(){

			jQuery('.field-list li').removeClass('repetative')

			jQuery('.reset_repetative').addClass('d-none')

		})

		// ACCORIDON
		jQuery('body').delegate('.section-title' , 'click' , function() {

			jQuery('.section-box form').addClass('collapsed');

			let check = jQuery(this).siblings('form');

			check.removeClass('collapsed')

		})


		// PARSING VALUES TO MAKE AN ARRAY

		jQuery('body').delegate('.section-box input' , 'blur' , function() {

			let dir = jQuery(this).parents('form').attr('data-id')

			let key = jQuery(this).attr('name')

			let val = jQuery(this).val()

			jQuery(dir).attr(key,val)

			console.log(dir,key,val)

		})


		// SAVE TEMPLATE

		jQuery('body').delegate('#savetemplate' , 'click'  , function() {

			let template = { template : jQuery('#templatename').val()  }

			if( jQuery(this).hasClass('update') ){

				url = ajaxfieldurl+'/update';

				template['id'] = jQuery('#templateid').val();
			}
			else {

				url = ajaxfieldurl+'/save';
			}

			let sections = []

			let fields = {}

			let subfields = {}

			let dis,check

			let i=0

			jQuery('.fields-array ul').each(function() {

				dis = jQuery(this)

				sections.push({ title : dis[0].title , key : dis.attr('key') , data : {} })

				let j = 0

				dis.find('li').each(function() {
					
					check = jQuery(this).find('li');

					check2 = jQuery(this).parents('li');

					fields = {}

					subfields = {}

					if ( check2.length == 0 ) {

						let attr = jQuery(this)[0].attributes;

						for(const ve in attr){

							if(ve != 0 ){

								fields[attr[ve].name] = attr[ve].value
							}

						}
let fieldKey = jQuery(this).attr('key');

let form = jQuery('.fields-view').find('form[data-id="#' + fieldKey + '"]');
let isRequired = 0;

if (form.length) {
    isRequired = parseInt(form.find('[name="is_required"]').val() || 0);
}

fields['is_required'] = isRequired;



						sections[i].data[j] = fields
console.log('all fields cpmes here');
						console.log(fields);
					}

					if(check.length != 0){

						fields['subfields'] = {}

						let p = 0;

						jQuery(this).find('li').each(function(){

							let subattr = jQuery(this)[0].attributes;

							for(const ves in subattr){

								subfields[subattr[ves].name] = subattr[ves].value

							}

							sections[i].data[j]['subfields'][p]=subfields

							subfields = {}

							p++

						})
					}

					j++

				})

				i++;

			})


			template['section_data'] = sections

			template['type'] = jQuery('#templatetype').val()
			
			console.log(template)

			jQuery.ajax({

				type:'POST',

				url: url,

				data:{data:template},

				headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

				success:function(response){

					console.log(response);

				}

			})
		})

		// Select All

jQuery('body').on('click', '.select-all', function () {

			jQuery('.row-select').click()

		})

		jQuery('body').delegate('.delete','click', function() {

			let parent = jQuery(this).parents('.deletable');

			let remove = parent.find('form').attr('data-id')
			
			jQuery(remove).remove()

			parent.remove()
		}) 

		jQuery('body').delegate('.repeat-product-item','click',function() {

			let append = jQuery('#product-item-html').html()

			jQuery('.product-items').append(append)

jQuery('.product-items').find('.product-item').each(function () {
    dis = jQuery(this);

    if (!dis.find('select').hasClass('select2')) {

        dis.find('select').addClass('select2');
        dis.find('.product').attr('name', 'product[]');
        dis.find('.variation').attr('name', 'variation[]');

        // Product change
        dis.find('.product').select2({
            'placeholder': 'Select Product'
        }).on("change", function (e) {
            jQuery.ajax({
                type: 'POST',
                url: '{{asset("admin/product/getvariations")}}',
                data: { id: jQuery(this).val() },
                headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    const variationSelect = dis.find('.variation');
                    variationSelect.html(response).select2({});

                    // If variation exists, set the first option as selected
                    if (variationSelect.find('option').length > 0) {
                        variationSelect.prop('selectedIndex', 0).trigger('change');
                    } else {
                        updateStock(dis); // fallback to product stock
                    }
                }
            });
        });

        // 🆕 Variation change (priority)
        dis.find('.variation').on('change', function () {
            updateStock(dis);
        });

        jQuery(this).find('input').attr('name', 'quantity[]');
    }
});

// Helper function to update stock
function updateStock(dis) {
    const variationSelect = dis.find('.variation');
    const productSelect = dis.find('.product');
    let stock = 0;

    if (variationSelect.find('option').length > 0 && variationSelect.val()) {
        const selectedOption = variationSelect.find('option:selected');
        stock = selectedOption.data('stock') ?? 0;
    } else {
        const productSelected = productSelect.find('option:selected');
        stock = productSelected.data('stock') ?? 0;
    }

    console.log('stock comes here:', stock);

    const quantityInput = dis.find('input[type="number"]');
    quantityInput
        .attr('max', stock)
        .attr('min', 1)
        .attr('required', true);
}


		})
	

		jQuery('body').delegate('.repeat','click',function() {

			let dir = jQuery(this).attr('data-direction')

			let parent = jQuery(this).parents('.repetitive_parent')

			let append = parent.find('.repetitive_content').first().html()

			let name = jQuery(this).attr('data-initial')

			if( parent.find('.quilleditor').length != 0 ){
				
				jQuery(this).append('<div id="quill-edit" class="d-none">'+append+'</div>')

				jQuery(this).find('#quill-edit .tox.tox-tinymce').remove()

				append = jQuery(this).find('#quill-edit').html()
			}

			parent.append('<div class="repetitive_content">'+append+'</div>')
			
			if( parent.find('.quilleditor').length != 0 ){

				let id = 'tiny'+parent.find('.quilleditor').length

				parent.find('.quilleditor').last().attr('id',id)

				options = {
					selector:'#'+id,
					width:'auto',
					plugins: [
						'advlist','code', 'autolink', 'lists', 'link', 'charmap', 'preview',
						'anchor', 'searchreplace', 'visualblocks', 'fullscreen',
						'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount',
						'image', 'link', 'media' ,'template' ,'codesample', 'table', 'charmap', 
						'pagebreak', 'nonbreaking', 'anchor','advlist', 'lists', 'wordcount',
						'help' , 'emoticons'
					],
					toolbar: 'undo redo | blocks | bold italic backcolor forecolor | ' +
					'alignleft aligncenter alignright alignjustify | ' +
					'bullist numlist | help | code | image | editimage | imageoptions',
				};

				tinyMCE.init(options)

				setTimeout( function() {
					parent.find('.tox.tox-tinymce').last().show().attr('style','visibility: hidden; width: auto; height: 400px;')
				},1000)
			}

		})

		// DEVELOPER JS \\\\\\\\\\\\\\\\\\\\\


		// Language

jQuery('#change_lang').change(function() {
    let url = jQuery(this).data('url');
    let id = jQuery(this).data('id');
    let lang = jQuery(this).val();

    let data = { lang: lang };

    if (id != undefined && id != '') {
        data['id'] = id;
    }

    jQuery.ajax({
        type: 'POST',
        url: url,
        data: data,
        headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },
        success: function(response) {
            jQuery('#languageWrap').html(response);

            jQuery('#languageWrap').find('.select2').select2();

            jQuery('.quilleditor').each(function() {
                CKEDITOR.replace(this);
            });

            jQuery(".flatpickr").flatpickr();

            console.log('wokring');


            const prodType = "<?= isset($data['product']['prod_type']) ? $data['product']['prod_type'] : '' ?>";
            const productId = <?= isset($data['product']['ID']) ? (int)$data['product']['ID'] : 0 ?>;

            if (prodType === 'variable') {
                loadVariation(productId);
            }

        }
    });
});



		//Menus Delete

		jQuery('body').delegate('.delete-menu' , 'click' , function() {

			jQuery('#deleteproductmodal').addClass('show').show().find('#products_id').val(jQuery(this).attr('products_id'));

		})


		// Media Functions


		// Select All

    jQuery('.select-unselect-images').on('click', function() {
        if (jQuery(this).hasClass('select')) {
            jQuery('#media-gallery figure').addClass('selected');
        } else {
            jQuery('#media-gallery figure').removeClass('selected');
        }
    });

    jQuery('#media-gallery').on('click', 'figure', function() {
        jQuery(this).toggleClass('selected');
    });
		// Images Delete
		jQuery('#delete-images').click(function(e) {
			e.preventDefault();

			let count = jQuery('#media-gallery .selected').length;

			if (count > 0) {
				jQuery('#confirmDeleteModal').modal('show');
			}
		});
jQuery('#confirmDeleteBtn').click(function() {
				let img;

				let count = jQuery('#media-gallery .selected').length;

				let i = 0;
jQuery('#media-gallery .selected').each(function() {	

    const mediaEl = jQuery(this).find('img, video');
	console.log('media el comes here:');
	console.log(mediaEl);
    const img = mediaEl.attr('image_id');
	console.log('image_id comes here:');
console.log(img);
    jQuery(this).parents('.col-md-2').remove();

    if (img) {
        jQuery.ajax({
            type : 'POST',
            url : '{{asset("admin/media/delete")}}',
            data: { id: img },
            headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },
            success: function(response){
                window.location.reload();
            }
        });
    }
});
		});




		//Drag To ReOrder

		const draggbles = document.querySelectorAll(".shallow-draggable")
		const containers = document.querySelectorAll(".draggable-container")

		draggbles.forEach((draggble) => {

  			//for start dragging costing opacity
			
			draggble.addEventListener("dragstart", () => {
				draggble.classList.add("dragging")

			})


		//for end the dragging opacity costing
			draggble.addEventListener("dragend", () => {
				draggble.classList.remove("dragging")

				let elemas = jQuery(draggble).parents('.draggable-container').find('.shallow-draggable');

				let j = elemas.first().attr('start');

				let data = {}
				
				let type = elemas.first().attr('type') 
				
				data[type] = []

				elemas.each(function() {

					jQuery(this).attr('sort-order',j)

					data[type].push({id:jQuery(this).attr('id'),order:j})

					j++;
				})

				jQuery.ajax({

					type : 'POST',

					url : '{{asset("admin/sort-order/")}}/'+type,

					data: data,

					headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

					success:function(response){

					}

				})
			})
		})


		containers.forEach((container) => {
			
			container.addEventListener("dragover", function (e) {

				e.preventDefault()

				const afterElement = dragAfterElement(container, e.clientY)

				const dragging = document.querySelector(".dragging")

				if (afterElement == null) {

					container.appendChild(dragging)

				} else {

					container.insertBefore(dragging, afterElement)

				}

			})

		})

		function dragAfterElement(container, y) {

			const draggbleElements = [...container.querySelectorAll(".shallow-draggable:not(.dragging)")]

			return draggbleElements.reduce(

				(closest, child) => {

					const box = child.getBoundingClientRect()

					const offset = y - box.top - box.height / 2

					if (offset < 0 && offset > closest.offset) {

						return { offset: offset, element: child }

					} else {

						return closest

					}

				},

				{ offset: Number.NEGATIVE_INFINITY }

				).element

		}

		// Multi Delete

jQuery('body').on('click', '.row-select', function () {

			let dis = jQuery(this);
			
			let arr = []

			dis.toggleClass('selected')

			if(jQuery('.selected').length != 0){

				jQuery('input.selected').each(function() {


					arr.push(jQuery(this).data('id'))

				})

				jQuery('.multi-delete').show()

			}
			else{

				jQuery('.multi-delete').hide()
			}

			jQuery('#selected_rows').val( JSON.stringify(arr) );

		})


		jQuery('.delete-multiple-popup').click(function() {

			jQuery('.delete-modal').find('form').addClass('ajax')

		})

		jQuery('body').delegate('.delete-modal .ajax button','click' ,function(e) {

			e.preventDefault();

			let ids = jQuery('#selected_rows').val()

			let url = jQuery(this).parents('form').attr('action')

			ids = JSON.parse(ids)

			for(i in ids){

				jQuery.ajax({

					type:'POST',

					url : url,

					data : {id:ids[i]},

					headers : {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

					success:function(response) {

						console.log(response)

					}
				})

				jQuery('#row-'+ids[i]).fadeOut('slow');

			}

			jQuery('.btn-close').click();

			jQuery('.delete-multiple-popup').hide();

			jQuery('.delete-modal form').removeClass('ajax')

			setTimeout(function() {window.location.href = window.location.href },1500)
		})


		//Dashboard Inqury List


		jQuery('.submission-tab').click(function() {

			let go = jQuery(this).attr('data-tab')

			jQuery('.job-tab').hide();

			jQuery(go).show();
		})



		// Export to Excel Fucntion

		jQuery('#export').click(function() {

			let data = jQuery('.report')

			let name = jQuery('.box-title').text()
			
			data = data[0]

			let excelFile = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
			XLSX.write(excelFile, { bookType: 'xlsx', bookSST: true, type: 'base64' });

			XLSX.writeFile(excelFile, name + '.xlsx');

		})



		// jQuery('#example1').removeClass('table-bordered table-striped').wrap('<div class="table-wrap"></div>')

		// Menus Url Type

		jQuery('#url-type').change( function() {

			let id = jQuery(this).val()

			jQuery('.link').hide()

			let arr = ['url','page','category']

			jQuery('.'+arr[id]).show()

		} )



		// Product Select

		jQuery(".product-select").select2({

			ajax: {

				url: "<?=asset('admin/product/search')?>",

				dataType: 'json',

				type:'post',

				headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')  },

				data: function (params) {

					var query = {

						search: params.term,

						type: 'user_search',

					}

					return query;

				},

				processResults: function (data) {

					return {

						results: data

					};

				}

			},

			placeholder: 'Select Product',

			minimumInputLength: 1,

		});
		const sliderType =  $('select[name="mobile_slider_type"]').val()
		if(sliderType == 'product'){

			$('select[name="mobile_slider_category"]').parents('.form-group').addClass('d-none')
			$('select[name="mobile_slider_category"]').parents('.form-group').removeClass('field-validate')

			$('select[name="mobile_slider_products"]').parents('.form-group').removeClass('d-none')
			$('select[name="mobile_slider_products"]').parents('.form-group').addClass('field-validate')
		}else if(sliderType == "category"){
			$('select[name="mobile_slider_category"]').parents('.form-group').removeClass('d-none')
			$('select[name="mobile_slider_category"]').parents('.form-group').addClass('field-validate')

			$('select[name="mobile_slider_products"]').parents('.form-group').addClass('d-none')
			$('select[name="mobile_slider_products"]').parents('.form-group').removeClass('field-validate')
		}
		$(document).on('change','select[name="mobile_slider_type"]',function (e) {
            // body...
            // console.log($(this).val())
			if($(this).val() == 'product'){

				$('select[name="mobile_slider_category"]').parents('.form-group').addClass('d-none')
				$('select[name="mobile_slider_category"]').parents('.form-group').removeClass('field-validate')

				$('select[name="mobile_slider_products"]').parents('.form-group').removeClass('d-none')
				$('select[name="mobile_slider_products"]').parents('.form-group').addClass('field-validate')
			}else if($(this).val() == "category"){
				$('select[name="mobile_slider_category"]').parents('.form-group').removeClass('d-none')
				$('select[name="mobile_slider_category"]').parents('.form-group').addClass('field-validate')

				$('select[name="mobile_slider_products"]').parents('.form-group').addClass('d-none')
				$('select[name="mobile_slider_products"]').parents('.form-group').removeClass('field-validate')
			}
		})
		// PRODUCT PAGE //

		jQuery('body').delegate('.brands input','click',function() {

			jQuery('.brands input').prop('checked', false)
			jQuery(this).prop('checked', true)

		})

		jQuery('body').delegate('#attr-add',"click", function(e) {

			e.preventDefault();

			let parent = jQuery(this).parents('div.form')

			let data = {

				product_ID: parent.find('input[name="product_ID"]').val(),

				attribute_ID: parent.find('select[name="attribute_ID"]').val(),
			}

			jQuery.ajax({

				url : '<?=asset('admin/product/assign-attrs')?>',

				type: 'POST',

				data: data,

				headers : {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

				success:function(res) {

					refreshAttrs()

				}

			})
		})

		jQuery('body').delegate('#savevalues',"click", function(e) {

			e.preventDefault();

			let parent = jQuery(this).parents('div.valueform')

			let data = {
				product_ID: jQuery('input[name="ID"]').val(),
				attribute_ID: parent.find('input[name="attribute_ID"]').val(),
				values: parent.find('.values-field').val(),
			}

			jQuery.ajax({

				url : '<?=asset('admin/product/save-values')?>',

				type: 'POST',

				data: data,

				headers : {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

				success:function(res) {

					refreshAttrs()

				}

			})
		})

		jQuery('body').delegate('.remove-var','click',function(e) {

			e.preventDefault();

			let prod = jQuery('input[name="ID"]').val()

			let parent = jQuery(this).parents('.accordion.variation')

			let data = {id: jQuery('input[name="var_ID"]').val()}

			jQuery.ajax({

				url : '<?=asset('admin/product/removevar')?>',

				type: 'POST',

				data: data,

				headers : {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

				success:function(res) {

					parent.remove()

				}

			})

		})

		jQuery('body').delegate('#add-variation',"click", function(e) {

			e.preventDefault();

			let data = {id: jQuery('input[name="ID"]').val()}

			jQuery.ajax({

				url : '<?=asset('admin/product/add-variation')?>',

				type: 'POST',

				data: data,

				headers : {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

				success:function(res) {

					jQuery('.variations-append').append(res)

					jQuery('.var-attrs').select2({})
				}

			})
		})


		// jQuery('body').delegate('.regular','blur',function() {

		// 	jQuery(this).parents('.pdata').find('.sale').attr('max',jQuery(this).val())

		// 	if( jQuery(this).parents('.pdata').find('.sale').val() > jQuery(this).val() ){

		// 		jQuery(this).parents('.pdata').find('.sale').val(jQuery(this).val())
		// 	}

		// })

		jQuery('body').delegate('.sale','blur',function() {

			if(	jQuery(this).val() > jQuery(this).attr('max') ){

				jQuery(this).val(jQuery(this).attr('max'))

			}
		})

		jQuery('body').delegate('.update-variation',"click", function(e) {

			e.preventDefault();

			let dis = jQuery(this) 

			dis.attr('disabled','true')

			let prod = jQuery('input[name="ID"]').val()

			let parent = jQuery(this).parents('.variation')

			let id = parent.find('input[name="var_ID"]').val()

			let data = {}

			let attrs = parent.find('input[name="attrs"]').val()
			
			data['attrs'] = attrs

			attrs = attrs.split(',')

			if( id != '' || id != null ){

				data['update'] = id
			}

			for(i = 0; i < attrs.length; i++ ){

				data[attrs[i]] = parent.find('select[name="'+attrs[i]+'"]').val()
			}

			data['parent'] = jQuery('input[name="ID"]').val()
			data['parent_title'] = jQuery('input[name="prod_title"]').val()
    data['prod_title'] = parent.find('input[name="var_prod_title"]').val()
    data['prod_title_ar'] = parent.find('input[name="var_prod_title_ar"]').val()
			data['sku'] = parent.find('input[name="var_prod_sku"]').val()
			data['prod_price'] = parent.find('input[name="var_prod_price"]').val()
			data['sale_price'] = parent.find('input[name="var_sale_price"]').val()
			data['prod_quantity'] = parent.find('input[name="var_prod_quantity"]').val()
			data['prod_image'] = parent.find('input[name="var_prod_image"]').val()
			data['prod_images'] = parent.find('input[name="var_prod_images"]').val()
data['prod_short_description'] = parent.find('textarea[name="var_prod_short_description"]').val()?.trim() || '';
data['prod_description']       = parent.find('textarea[name="var_prod_description"]').val()?.trim() || '';
data['prod_features']          = parent.find('textarea[name="var_prod_features"]').val()?.trim() || '';
data['prod_short_description_ar'] = parent.find('textarea[name="var_prod_short_description_ar"]').val()?.trim() || '';
data['prod_description_ar']       = parent.find('textarea[name="var_prod_description_ar"]').val()?.trim() || '';
data['prod_features_ar']          = parent.find('textarea[name="var_prod_features_ar"]').val()?.trim() || '';
	
			jQuery.ajax({

				url : '<?=asset('admin/product/create-variation')?>',

				type: 'POST',

				data: data,

				headers : {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

				success:function(res) {

					if( res == '"Already Exists!"' ){

						alert('Variation Already Exists!');

					}
					res = JSON.parse(res)

					jQuery('.var-attrs').select2({})

					if( id == '' || id == null ){
						
						parent.append('<input type="hidden" name="var_ID" value="'+res.id+'">' )

					}
					dis.removeAttr('disabled')
				}

			})
		})
		<?php  if( isset( $data['product']['ID'] ) ) : ?>

			if( jQuery('#prod_type').val() == 'variable' ){
				console.log('loadvariaton workiing..');
				loadVariation(<?=$data['product']['ID']?>)
				
			}

		<?php endif;?>

		jQuery('#prod_type').change(function() {

			let id = jQuery('input[name="ID"]').val()

			if( jQuery(this).val() == 'variable' ){

				jQuery('.product-data').find('input').removeAttr('required')
				jQuery('.product-data').hide()

				loadVariation(id)

			}else{

				jQuery('#variations').html('')
			}

		})

function loadVariation(id) {

    jQuery.ajax({

        url: '<?= asset('admin/product/variable?id=') ?>' + id,

        type: 'GET',

        success: function(res) {

            if (res.includes('new')) {

                jQuery('form#product-form').submit()
            }

            jQuery('#variations').html(res).removeClass('d-none')

            initProdAttr()

            refreshAttrs()

            jQuery('.variation .select2').select2()
            @if(request()->get('var') != null)
					setTimeout(function(){
						var variationId = "{{ request()->get('var') }}";
				    	let $accordion = $("#var-" + variationId);
				    	$accordion.find(".heading").trigger("click");
				    	

						$("#profile-tab").tab("show");
				        $('html, body').animate({
				            scrollTop: $accordion.offset().top - 100 // adjust offset if you have fixed header
				        }, 600); // 600ms smooth scroll
				    }, 300);

					@endif
					let lang = jQuery('#change_lang').val();
					            toggleLanguageFields(lang);

        }

    })

}

		function refreshAttrs(){

			let id = jQuery('.assigned-attributes').attr('data-id')

			jQuery.ajax({

				url: '<?=asset('admin/product/get-attrs')?>',

				type: 'POST',

				data:{id:id},

				headers : {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

				success:function(res){

					jQuery('.assigned-attributes').html(res)

					initProdValues()
				}
			})

		}

		function initProdAttr(){

			jQuery("#attributes").select2({});

		}

		function initProdValues(){

			jQuery(".values-field").select2({});

		}

		 // Custom Accordions

		jQuery('body').delegate(".accordion .heading" , "click", function(e){

			e.stopPropagation();

			var abc = jQuery(this).hasClass('active');

			if (abc == true) {

				jQuery(this).siblings(".contents").slideUp("fast");

				jQuery(".heading").removeClass('active');

			}

			else{

				jQuery(".contents").slideUp("fast");

				jQuery(this).siblings(".contents").slideDown("fast");

				jQuery(".heading").removeClass('active');

				jQuery(this).addClass('active');

			}

		});

		// PRODUCT PAGE //


		// Document Ready Closing
	});


	// OSAMA \\


jQuery( document ).ready(function() {
	$('#loader').hide();	

	$('.order-table-list').DataTable();

	$('.discount_type').change(function(){
		console.log('includes product');
		console.log($(this).val());
		if($(this).val().includes('product')){
			$('.products_div').show();
		}
		else{
			$('.products_div').hide();
		}
	}).trigger('change');

});




function loadCustomerDetails(customerId) {

	jQuery.ajax({

		url: '<?=asset('admin/get-customer-details')?>',

		method: 'POST',

		data: {id: customerId },

		headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },

		success: function (response) {

			response = JSON.parse(response)

			jQuery('#customerModal .modal-body').html(response.html);

			jQuery('#customerModal').modal('show');
		}

	});
}


document.getElementById('analytics').addEventListener('click', function() {

	document.getElementById('order_graphs').scrollIntoView({ behavior: 'smooth' });

});

</script>
<script>
    $(document).on('click', '.viewEventDetails', function () {
        $('#modalName').text($(this).data('name'));
        $('#modalEmail').text($(this).data('email'));
        $('#modalEvent').text($(this).data('event'));
        $('#modalDate').text($(this).data('event-date'));
        $('#modalGuests').text($(this).data('guests'));
        $('#modalPhone').text($(this).data('phone'));
        $('#modalMessage').text($(this).data('message'));
        $('#modalCreated').text($(this).data('created'));

        $('#eventDetailModal').modal('show');
    });
</script>
<script>
    $(document).ready(function () {
        function updateReasonDropdowns() {
            const selectedStatus = $('#order_status').val().toLowerCase();

            $('#cancel-reason-wrapper').hide();
            $('#refund-reason-wrapper').hide();
            $('#cancel_reason_id').val('');
            $('#refund_reason_id').val('');

            if (selectedStatus == 'cancelled') {
                $('#cancel-reason-wrapper').show();
				$('#cancel_reason_id').attr('name', 'reason');
            } else if (selectedStatus == 'refunded') {
                $('#refund-reason-wrapper').show();
				$('#refund_reason_id').attr('name', 'reason');
            }else if(selectedStatus == 'refund requested'){
				$('#refund-reason-wrapper').show();
				$('#refund_reason_id').attr('name', 'reason');
			}else if(selectedStatus == 'cancel requested'){
				$('#cancel-reason-wrapper').show();
				$('#cancel_reason_id').attr('name', 'reason');
			}
        }

        $('#order_status').on('change', function () {
            updateReasonDropdowns();
        });
    });
	jQuery('#pagesTable').DataTable({
    processing: true,
    serverSide: true,
    lengthChange: true,
	order: [],
    ajax: {
        url: "{{ asset('admin/page/ajax') }}",
        type: 'GET',
		error: function(xhr) {
            if (xhr.status === 401 || xhr.status === 403) {
                window.location = "{{ asset('admin/login') }}";
            }
        }
    },
    columns: [
       { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
        { data: 'page_id', name: 'id' },
        { data: 'page_title', name: 'page_title' },
        { data: 'slug', name: 'slug' },
        { data: 'template', name: 'template' },
        {
            data: 'actions',
            name: 'actions',
            orderable: false,
            searchable: false,
            render: function (data, type, row) {
                return `
                    <a href="${row.edit_url}" class="badge bg-red"><i class="fa fa-edit"></i></a>
                    ${row.delete_url ? ` <a href="javascript:delete_popup('${row.delete_url}', ${row.page_id});" class="badge bg-red"><i class="fa fa-trash"></i></a>` : ''}
                `;
            }
        }
    ],
    order: [[0, 'asc']]
});
        $('#adminsTable').DataTable({
            processing: true,
            serverSide: true,
            
            ajax: '{{ url("admin/admins-ajax") }}',
            columns: [
                { data: 'select', orderable: false, searchable: false },
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'status', name: 'status' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
</script>
@if(isset($data) && isset($data['post_type']) && isset($data['post_type']['type']))
<script>
	
$(document).ready(function() {
    // let initialLength = parseInt($('#perPageSelect').val());

    let table = $('#Table{{ $data['post_type']['type'] }}').DataTable({
    processing: true,
    serverSide: true,
	order: [],
    // rowId: 'id', // gives <tr id="123">
    ajax: {
        url: '{{ url("admin/posts-ajax") }}',
		error: function(xhr) {
            if (xhr.status === 401 || xhr.status === 403) {
                window.location = "{{ asset('admin/login') }}";
            }
        },
        data: function(d) {
            d.post_type = '{{ $data['post_type']['type'] }}';
        }
    },
    columns: [
            { data: 'select', orderable: false, searchable: false },
            { data: 'id', name: 'id' },
            { 
                data: 'image', 
                orderable: false, 
                searchable: false, 
                render: function(data) {
                    return data
                        ? `<img src="${data}" width="50" height="50" style="object-fit: cover;">`
                        : '<span>No Image</span>';
                }
            },
            { data: 'title', name: 'title' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        createdRow: function (row, data) {
        // add attributes for later use
            $(row).attr("id", data.id);
            $(row).attr("type", "posts");
            $(row).addClass("shallow-draggable");
        },

    drawCallback: function(settings) {
         let $tbody = $('#Table{{ $data['post_type']['type'] }} tbody');

        // add classes
        $tbody.addClass('draggable-container');
        $tbody.find('tr').addClass('shallow-draggable');
        const draggbles = document.querySelectorAll("#Table{{ $data['post_type']['type'] }} tbody .shallow-draggable");
        const containers = document.querySelectorAll("#Table{{ $data['post_type']['type'] }} tbody.draggable-container");

        draggbles.forEach((draggable) => {
            draggable.setAttribute("draggable", "true"); // ensure it's draggable

            draggable.addEventListener("dragstart", () => {
                draggable.classList.add("dragging");
            });

            draggable.addEventListener("dragend", () => {
                draggable.classList.remove("dragging");

                let elemas = $(draggable).parents('.draggable-container').find('.shallow-draggable');
                let j = parseInt(elemas.first().attr('start')) || 1;
                let type = elemas.first().attr('type');

                let data = {};
                data[type] = [];

                elemas.each(function() {
                    $(this).attr('sort-order', j);
                    data[type].push({ id: $(this).attr('id'), order: j });
                    j++;
                });

                $.ajax({
                    type: 'POST',
                    url: '{{ url("admin/sort-order") }}/' + type,
                    data: data,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(response) {
                        console.log("Order saved", response);
                    }
                });
            });
        });

        containers.forEach((container) => {
            container.addEventListener("dragover", function (e) {
                e.preventDefault();
                const afterElement = dragAfterElement(container, e.clientY);
                const dragging = document.querySelector(".dragging");
                if (afterElement == null) {
                    container.appendChild(dragging);
                } else {
                    container.insertBefore(dragging, afterElement);
                }
            });
        });
    }
});

function dragAfterElement(container, y) {
    const draggableElements = [...container.querySelectorAll(".shallow-draggable:not(.dragging)")];
    return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        const offset = y - box.top - box.height / 2;
        if (offset < 0 && offset > closest.offset) {
            return { offset: offset, element: child };
        } else {
            return closest;
        }
    }, { offset: Number.NEGATIVE_INFINITY }).element;
}


    // $('#perPageSelect').on('change', function() {
    //     table.page.len(parseInt(this.value)).draw();
    // });

    // $('#Table{{ $data['post_type']['type'] }}').removeClass('table-bordered table-striped').wrap('<div class="table-wrap"></div>');
});

</script>

@endif
<script>
	$(document).ready(function() {
		$('.get_customer').on('change', function() {
			var userId = $(this).val();

			$.ajax({
				url: "<?= route('default-addresses') ?>",
				type: "GET",
				data: {
					user_id: userId,
					_token: $('meta[name="csrf-token"]').attr('content')
				},
				success: function(response) {
					console.log('response comes here:');
					console.log(response);
					if (response.success) {
						$('#firstname').val(response.billing_address[0].firstname);
						$('#lastname').val(response.billing_address[0].lastname);
						$('#country').val(response.billing_address[0].country);
						$('#city').val(response.billing_address[0].emirate);
						$('#address').val(response.billing_address[0].address);
						$('#phone').val(response.billing_address[0].phone);
						$('#email').val(response.billing_address[0].email);
						$('#address-details').val(response.billing_address[0]["address-details"]);
					} else {
						$('#firstname').val('');
						$('#lastname').val('');
						$('#country').val('');
						$('#address').val('');
						$('#city').val('');
						$('#phone').val('');
						$('#email').val('');
						$('#address-details').val('');
					}
				},
				error: function(xhr) {

				}
			});
		});

		$('.discount_type').change(function() {
			if ($(this).val().includes('product')) {
				$('.products_div').show();
			} else {
				$('.products_div').hide();
			}
		}).trigger('change');
	});

	function updateHiddenCategoryField() {
		var selected = $('input[name="category[]"]:checked').map(function() {
			return this.value;
		}).get();

		var categoryString = selected.join(',');

		$('.accordion.variation .contents .row input[name="category"]').val(categoryString)
	}

	$(document).ready(function() {
		setTimeout(updateHiddenCategoryField, 1000);

		$(document).on('change', '#product_create_form input[name="category[]"]', function() {
			updateHiddenCategoryField();
		});
	});
</script>

<script>
    function validateField(field) {

        removeOldError(field);

        let value = field.value.trim();

        if (field.classList.contains("quilleditor") && typeof CKEDITOR !== "undefined") {
            let instance = CKEDITOR.instances[field.name];
            if (instance) {
                value = instance.getData().trim();
            }
        }

        if (!value) {
            insertError(field, "This field is required.");
            return false;
        }

        return true;
    }


function insertError(field, message) {
    let error = document.createElement("div");
    error.classList.add("error-message");
    error.style.color = "red";
    error.textContent = message;

    // If the field has a "featured" button above it
    let featuredWrap = field.closest(".featuredWrap");
    if (featuredWrap) {
        // Insert error after the entire featuredWrap container
        featuredWrap.insertAdjacentElement("afterend", error);
    } else if (field.classList.contains("quilleditor")) {
        // Special handling for quill editors
        let editorWrapper = field.closest(".form-group").querySelector(".cke");
        if (editorWrapper) {
            editorWrapper.insertAdjacentElement("afterend", error);
        }
    } else {
        // Default: insert after the input field
        field.insertAdjacentElement("afterend", error);
    }

    setTimeout(() => {
        error.remove();
    }, 2000);
}



    function removeOldError(field) {
        if (field.nextElementSibling && field.nextElementSibling.classList.contains("error-message")) {
            field.nextElementSibling.remove();
        }

        let formGroup = field.closest(".form-group");
        if (formGroup) {
            let editorError = formGroup.querySelector(".error-message");
            if (editorError) editorError.remove();
        }
    }

    function scrollToField(field) {
        let target = field;
        if (field.classList.contains("quilleditor")) {
            let editorWrapper = field.closest(".form-group").querySelector(".cke");
            if (editorWrapper) target = editorWrapper;
        }

        target.scrollIntoView({
            behavior: "smooth",
            block: "center"
        });

        target.focus();
    }	
</script>