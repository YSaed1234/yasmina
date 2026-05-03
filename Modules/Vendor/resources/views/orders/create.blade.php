<x-vendor::layouts.master>
    <div class="mb-10">
        <a href="{{ route('vendor.orders.index') }}" class="text-primary font-bold text-sm flex items-center gap-2 mb-4 hover:gap-3 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Orders') }}
        </a>
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Create Manual Order') }}</h1>
        <p class="text-gray-500 mt-2">{{ __('Add an order received via social media or manually.') }}</p>
    </div>

    <form action="{{ route('vendor.orders.store') }}" method="POST" id="manualOrderForm">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Customer & Source -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Order Source Section -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center">1</span>
                        {{ __('Order Source') }}
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Source') }}</label>
                            <select name="source" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                                <option value="facebook">{{ __('facebook') }}</option>
                                <option value="whatsapp">{{ __('whatsapp') }}</option>
                                <option value="instagram">{{ __('instagram') }}</option>
                                <option value="manual" selected>{{ __('Manual') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Customer Details -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center">2</span>
                        {{ __('Customer Details') }}
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Customer Name') }}</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name') }}" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Phone') }}</label>
                            <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Shipping Address') }}</label>
                            <textarea name="customer_address" rows="3" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">{{ old('customer_address') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Items Selection -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center">3</span>
                        {{ __('Order Items') }}
                    </h3>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Search and Add Product') }}</label>
                        <select id="productSearchSelect" class="w-full"></select>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left" id="itemsTable">
                            <thead>
                                <tr class="text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">
                                    <th class="py-4">{{ __('Product') }}</th>
                                    <th class="py-4 w-32">{{ __('Price') }}</th>
                                    <th class="py-4 w-24 text-center">{{ __('Qty') }}</th>
                                    <th class="py-4 w-32 text-right">{{ __('Total') }}</th>
                                    <th class="py-4 w-16"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50" id="itemsBody">
                                <!-- Dynamic Rows -->
                            </tbody>
                        </table>
                    </div>
                    
                    <div id="noItemsMessage" class="py-10 text-center text-gray-400 font-medium">
                        {{ __('No items added yet.') }}
                    </div>
                </div>
            </div>

            <!-- Right Column: Financials & Action -->
            <div class="space-y-8">
                <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 sticky top-10">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">{{ __('Order Summary') }}</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between text-sm font-medium text-gray-500">
                            <span>{{ __('Subtotal') }}</span>
                            <span id="summarySubtotal">0.00</span>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Shipping Amount') }}</label>
                            <input type="number" step="0.01" name="shipping_amount" id="shipping_amount" value="0.00" 
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-4 focus:ring-primary/10 outline-none transition-all font-bold text-right">
                        </div>

                        <div class="pt-4 border-t border-gray-50 flex justify-between items-end">
                            <span class="text-sm font-bold text-gray-900 uppercase tracking-widest">{{ __('Grand Total') }}</span>
                            <span class="text-2xl font-black text-primary" id="summaryTotal">0.00</span>
                        </div>

                        <div class="pt-6">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Payment Status') }}</label>
                            <div class="flex gap-4">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="payment_status" value="pending" class="hidden peer" checked>
                                    <div class="text-center py-3 bg-gray-50 rounded-xl border-2 border-transparent peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition-all font-bold text-xs">
                                        {{ __('Pending') }}
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="payment_status" value="paid" class="hidden peer">
                                    <div class="text-center py-3 bg-gray-50 rounded-xl border-2 border-transparent peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-500 transition-all font-bold text-xs">
                                        {{ __('Paid') }}
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="pt-6">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Internal Notes') }}</label>
                            <textarea name="notes" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:ring-4 focus:ring-primary/10 outline-none transition-all text-sm"></textarea>
                        </div>

                        <button type="submit" class="w-full mt-6 py-4 bg-primary text-white rounded-2xl font-black uppercase tracking-widest hover:shadow-lg hover:shadow-primary/30 transition-all disabled:opacity-50 disabled:cursor-not-allowed" id="submitBtn" disabled>
                            {{ __('Create Order') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 60px;
            background-color: #F9FAFB;
            border: 1px solid #F3F4F6;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            padding: 0 1rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 15px;
        }
        .select2-dropdown {
            border-radius: 1rem;
            border: 1px solid #F3F4F6;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            let items = [];
            const shippingInput = $('#shipping_amount');
            const submitBtn = $('#submitBtn');

            // Initialize Select2 with AJAX
            $('#productSearchSelect').select2({
                placeholder: '{{ __("Search your products...") }}',
                minimumInputLength: 2,
                ajax: {
                    url: '{{ route("vendor.orders.search-products") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                },
                templateResult: formatProduct,
                templateSelection: formatProductSelection
            });

            function formatProduct(product) {
                if (product.loading) return product.text;
                
                var $container = $(
                    "<div class='select2-result-product flex items-center gap-3 p-1'>" +
                        "<div class='select2-result-product__image w-10 h-10 rounded overflow-hidden bg-gray-100'>" +
                            "<img src='" + (product.image || '/assets/placeholder.png') + "' class='w-full h-full object-cover' />" +
                        "</div>" +
                        "<div class='select2-result-product__meta min-w-0'>" +
                            "<div class='select2-result-product__title font-bold text-gray-900 truncate'></div>" +
                            "<div class='select2-result-product__price text-xs font-black text-primary'></div>" +
                        "</div>" +
                    "</div>"
                );

                $container.find(".select2-result-product__title").text(product.text);
                $container.find(".select2-result-product__price").html(product.price_html);

                return $container;
            }

            function formatProductSelection(product) {
                return product.text || '{{ __("Select Product") }}';
            }

            $('#productSearchSelect').on('select2:select', function (e) {
                const product = e.params.data;
                addItem(product);
                $(this).val(null).trigger('change');
            });

            function addItem(product) {
                const existing = items.find(i => i.product_id === product.product_id && i.variant_id === product.variant_id);
                if (existing) {
                    existing.quantity++;
                } else {
                    items.push({
                        product_id: product.product_id,
                        variant_id: product.variant_id,
                        name: product.text,
                        price: product.price,
                        quantity: 1,
                        currency: product.currency,
                        image: product.image
                    });
                }
                renderItems();
            }

            window.removeItem = function(index) {
                items.splice(index, 1);
                renderItems();
            }

            window.updateQty = function(index, qty) {
                items[index].quantity = parseInt(qty);
                renderItems();
            }

            function renderItems() {
                const itemsBody = $('#itemsBody');
                const noItemsMessage = $('#noItemsMessage');
                
                if (items.length === 0) {
                    itemsBody.html('');
                    noItemsMessage.removeClass('hidden');
                    submitBtn.prop('disabled', true);
                } else {
                    noItemsMessage.addClass('hidden');
                    submitBtn.prop('disabled', false);
                    itemsBody.html(items.map((item, index) => `
                        <tr>
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                                        <img src="${item.image || '/assets/placeholder.png'}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-bold text-gray-900 truncate max-w-[200px]">${item.name}</p>
                                        <input type="hidden" name="items[${index}][product_id]" value="${item.product_id}">
                                        <input type="hidden" name="items[${index}][variant_id]" value="${item.variant_id || ''}">
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                <input type="number" step="0.01" name="items[${index}][price]" value="${item.price}" 
                                       class="w-full px-3 py-2 bg-gray-50 border border-gray-100 rounded-lg font-bold text-sm"
                                       onchange="items[${index}].price = this.value; calculateTotals()">
                            </td>
                            <td class="py-4">
                                <input type="number" name="items[${index}][quantity]" value="${item.quantity}" min="1"
                                       class="w-full px-3 py-2 bg-gray-50 border border-gray-100 rounded-lg font-bold text-sm text-center"
                                       onchange="updateQty(${index}, this.value)">
                            </td>
                            <td class="py-4 text-right font-black text-gray-900">
                                ${(item.price * item.quantity).toFixed(2)} ${item.currency}
                            </td>
                            <td class="py-4 text-center text-red-400 hover:text-red-600">
                                <button type="button" onclick="removeItem(${index})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    `).join(''));
                }
                calculateTotals();
            }

            function calculateTotals() {
                let subtotal = items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                let shipping = parseFloat(shippingInput.val()) || 0;
                let total = subtotal + shipping;

                $('#summarySubtotal').text(subtotal.toFixed(2));
                $('#summaryTotal').text(total.toFixed(2));
            }

            shippingInput.on('input', calculateTotals);
        });
    </script>
    @endpush
</x-vendor::layouts.master>
