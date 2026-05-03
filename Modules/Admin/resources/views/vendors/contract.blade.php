<x-admin::layouts.master>
    <div class="mb-10 flex justify-between items-center no-print">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('Vendor Contract') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Review and print the formal agreement with') }} {{ $vendor->name }}</p>
        </div>
        <button onclick="window.print()" class="px-8 py-4 bg-primary text-white rounded-2xl font-bold shadow-xl shadow-primary/20 hover:opacity-90 transition-all flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            {{ __('Print Contract') }}
        </button>
    </div>

    <div class="print-container bg-white shadow-2xl rounded-[3rem] p-16 md:p-24 border border-gray-100 relative overflow-hidden mx-auto max-w-5xl rtl" dir="rtl">
        <!-- Stamp Watermark -->
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none select-none -rotate-45">
            <h1 class="text-[12rem] font-black text-gray-900 whitespace-nowrap">ياسمينة ستور</h1>
        </div>

        <!-- Header -->
        <div class="flex justify-between items-start border-b-4 border-primary pb-12 mb-12">
            <div class="flex items-center gap-6">
                @if($vendor->logo)
                    <img src="{{ asset('storage/' . $vendor->logo) }}" class="w-20 h-20 rounded-2xl object-cover shadow-sm">
                @endif
                <div>
                    <h2 class="text-4xl font-black text-gray-900 mb-2">عقد تقديم خدمات تقنية</h2>
                    <p class="text-gray-500 font-bold tracking-widest uppercase">{{ __('TECHNICAL SERVICE AGREEMENT') }}</p>
                </div>
            </div>
            <div class="text-left">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">تاريخ العقد</p>
                <p class="text-xl font-black text-gray-900">{{ now()->format('Y/m/d') }}</p>
            </div>
        </div>

        <!-- Parties -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12 bg-gray-50 rounded-[2rem] p-10 border border-gray-100">
            <div>
                <h3 class="text-xs font-black text-primary uppercase tracking-[0.2em] mb-4">الطرف الأول (المنصة)</h3>
                <div class="space-y-2">
                    <p class="text-xl font-black text-gray-900">{{ config('app.name') }}</p>
                    <p class="text-sm text-gray-500 font-bold leading-relaxed">المسؤولة عن توفير البنية التحتية التقنية (السيرفر، الدومين، لوحة التحكم).</p>
                </div>
            </div>
            <div>
                <h3 class="text-xs font-black text-primary uppercase tracking-[0.2em] mb-4">الطرف الثاني (المؤسسة)</h3>
                <div class="space-y-4">
                    <p class="text-xl font-black text-gray-900">{{ $vendor->name }}</p>
                    <div class="grid grid-cols-1 gap-1 text-sm text-gray-500 font-bold">
                        <p>بتمثيل السيد / السيدة: {{ $vendor->manager_name ?? '................' }}</p>
                        <p>بصفتـه (المدير المسؤول) - رقم قومي: {{ $vendor->manager_id_number ?? '................' }}</p>
                        <p>رقم الهاتف: {{ $vendor->manager_phone ?? '................' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clauses -->
        <div class="space-y-10 mb-16">
            <section>
                <div class="flex items-center gap-4 mb-4">
                    <span class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-black">١</span>
                    <h4 class="text-xl font-black text-gray-900">الخدمات التقنية والفنية المقدمة</h4>
                </div>
                <div class="pr-14 space-y-3 text-gray-600 leading-relaxed font-bold">
                    <p>
                        تلتزم المنصة (الطرف الأول) بتقديم الخدمات التالية للطرف الثاني لضمان سير العمل بكفاءة:
                    </p>
                    <ul class="list-disc pr-5 text-gray-500 font-medium space-y-1 text-sm">
                        <li>توفير استضافة سحابية (Server) مؤمنة وعالية السرعة لضمان استقرار الموقع.</li>
                        <li>منح المؤسسة رابطاً خاصاً (Sub-domain) لعرض منتجاتها واستقبال الطلبات من خلاله.</li>
                        <li>توفير لوحة تحكم إدارية (Admin Panel) تمكن المؤسسة من إدارة المنتجات، الأسعار، المخزون، والطلبات.</li>
                        <li>إتاحة إدارة نظام "الكوبونات والخصومات" ونقاط الولاء بشكل مستقل تماماً من قِبل المؤسسة.</li>
                        <li>توفير خاصية "الدفع الجزئي" وإمكانية رفع إيصالات التحويل (مثل InstaPay) لتوثيق السداد يدوياً.</li>
                        <li>توفير تقارير دورية شاملة للطلبات، مدفوعات العملاء، وكشف حساب تفصيلي للمعاملات المالية مع الإدارة.</li>
                        <li>توفير الدعم الفني اللازم لمعالجة أي أعطال تقنية قد تعيق عمل النظام.</li>
                    </ul>
                </div>
            </section>

            <section>
                <div class="flex items-center gap-4 mb-4">
                    <span class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-black">٢</span>
                    <h4 class="text-xl font-black text-gray-900">طبيعة التعاون المادي</h4>
                </div>
                <div class="pr-14 space-y-3">
                    <p class="text-gray-600 leading-relaxed font-bold">
                        تلتزم المنصة بتوفير الاستضافة (Server) واسم النطاق (Domain) ولوحة التحكم الخاصة بالمؤسسة، مقابل رسوم دورية قدرها ({{ number_format($vendor->subscription_fees, 2) }} ج.م) بالإضافة إلى عمولة مبيعات.
                    </p>
                    <p class="text-gray-600 leading-relaxed font-bold">
                        @if($vendor->setup_fee > 0)
                            تلتزم ({{ $vendor->name }}) بسداد رسوم إعداد وشراء النظام لمرة واحدة قدرها ({{ number_format($vendor->setup_fee, 2) }} ج.م).
                        @else
                            يُعفى الطرف الثاني ({{ $vendor->name }}) من رسوم شراء النظام كونه "شريك نجاح" في فترة الإطلاق التجريبي.
                        @endif
                    </p>
                    <ul class="list-disc pr-5 text-gray-500 font-medium space-y-1">
                        <li>
                            تستحق المنصة عمولة مبيعات عامة قدرها 
                            ({{ $vendor->commission_value }}{{ $vendor->commission_type == 'percentage' ? '%' : ' ج.م' }}) 
                            عن كل طلبية ناجحة.
                        </li>
                        @if($vendor->product_commission_value > 0)
                        <li>
                            تطبق عمولة خاصة على المنتجات قدرها 
                            ({{ $vendor->product_commission_value }}{{ $vendor->product_commission_type == 'percentage' ? '%' : ' ج.م' }}) 
                            لكل قطعة يتم بيعها (كبديل للعمولة العامة أو مضافة إليها حسب الاتفاق التقني).
                        </li>
                        @endif
                        <li>المؤسسة مسؤولة عن سداد اشتراك السيرفر والدومين في المواعيد المحددة لضمان استمرار الخدمة.</li>
                    </ul>
                </div>
            </section>

            <section>
                <div class="flex items-center gap-4 mb-4">
                    <span class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-black">٣</span>
                    <h4 class="text-xl font-black text-gray-900">طبيعة المنصة وإخلاء المسؤولية عن المبيعات</h4>
                </div>
                <div class="pr-14 space-y-3 text-gray-600 leading-relaxed font-bold">
                    <p>
                        يقر الطرفان بأن المنصة (الطرف الأول) هي **"منصة تقنية ووسيط إلكتروني فقط"**، وتخلي مسؤوليتها تماماً ونهائياً عن عملية البيع بكافة مراحلها.
                    </p>
                    <ul class="list-disc pr-5 text-gray-500 font-medium space-y-2 text-sm">
                        <li>تتحمل المؤسسة المسؤولية الكاملة والمنفردة عن صحة المنتجات، أسعارها، وعمليات التوصيل.</li>
                        <li>**إدارة المنصة غير مسؤولة أبداً** عن أي معاملات مالية أو قانونية تتم بين المؤسسة والعميل النهائي.</li>
                        <li>تقع مسؤولية **المرتجعات والاستبدال والاسترداد** على عاتق المؤسسة "بشكل بحت"، ولا يحق للعميل أو المؤسسة مطالبة المنصة بأي تعويضات ناتجة عن ذلك.</li>
                        <li>لا تلتزم المنصة برد العمولة الخاصة بها في حال تم الاسترجاع، حيث أن دور المنصة التقني قد تم بمجرد إتمام الطلب برمجياً.</li>
                    </ul>
                </div>
            </section>

            <section>
                <div class="flex items-center gap-4 mb-4">
                    <span class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-black">٤</span>
                    <h4 class="text-xl font-black text-gray-900">استقلالية العلامة التجارية وفصل البيانات</h4>
                </div>
                <div class="pr-14 space-y-3 text-gray-600 leading-relaxed font-bold">
                    <p>
                        تلتزم المنصة بتوفير بيئة عرض مستقلة للطرف الثاني ({{ $vendor->name }})، بحيث لا تظهر منتجات المؤسسات الأخرى لمستخدمي الرابط الخاص به، وذلك لتعزيز خصوصية العلامة التجارية.
                    </p>
                    <ul class="list-disc pr-5 text-gray-500 font-medium space-y-1 text-sm">
                        <li>يحق للمنصة إضافة مؤسسات أخرى أو زيادة عدد المشتركين في النظام العام بموافقة كتابية وتحديد رسوم اشتراك شهرية إضافية.</li>
                        <li>يمنع منعاً باتاً استغلال بيئة العمل الخاصة بالمؤسسة لعرض منتجات لمؤسسات منافسة دون الرجوع للمنصة (الطرف الأول).</li>
                    </ul>
                </div>
            </section>

            <section>
                <div class="flex items-center gap-4 mb-4">
                    <span class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-black">٥</span>
                    <h4 class="text-xl font-black text-gray-900">الملكية الفكرية وحقوق الاستخدام</h4>
                </div>
                <div class="pr-14 space-y-3 text-gray-600 leading-relaxed font-bold">
                    <p>
                        يقر الطرف الثاني ({{ $vendor->name }}) بأن كافة الحقوق الفكرية، الكود المصدري (Source Code)، التصاميم، وقواعد البيانات هي ملكية حصرية للمنصة (الطرف الأول).
                    </p>
                    <ul class="list-disc pr-5 text-gray-500 font-medium space-y-1 text-sm">
                        <li>رسوم الشراء أو الإعداد لا تعطي الحق للمؤسسة في المطالبة بالكود المصدري أو نقل النظام لسيرفر خارجي.</li>
                        <li>لا يحق للمؤسسة التنازل عن الرابط (Domain/Slug) أو تأجيره من الباطن لأي جهة أخرى دون موافقة كتابية.</li>
                        <li>في حال إنهاء العقد، تلتزم المنصة بتسليم المؤسسة بيانات منتجاتها وطلباتها فقط، دون أي ملفات برمجية.</li>
                    </ul>
                </div>
            </section>

            <section>
                <div class="flex items-center gap-4 mb-4">
                    <span class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-black">٦</span>
                    <h4 class="text-xl font-black text-gray-900">مدة العقد والإنهاء</h4>
                </div>
                <div class="pr-14 space-y-3">
                    <p class="text-gray-600 leading-relaxed font-bold">
                        مدة هذا العقد (سنة ميلادية واحدة) تبدأ من تاريخ التوقيع، وتجدد تلقائياً ما لم يخطر أحد الطرفين الآخر برغبته في الإنهاء قبل موعد التجديد بـ (30 يوماً).
                    </p>
                    <p class="text-gray-600 leading-relaxed font-bold">
                        في حال رغب الطرف الثاني في فسخ العقد قبل انتهاء مدته، يلتزم بسداد شرط جزائي يعادل قيمة اشتراك (٣ أشهر) بإجمالي قدره ({{ number_format($vendor->subscription_fees * 3, 2) }} ج.م).
                    </p>
                    <p class="text-gray-600 leading-relaxed font-bold">
                        كما يحق للمنصة إيقاف الخدمة فوراً في حال إخلال ({{ $vendor->name }}) ببنود العقد أو التأخر في سداد الالتزامات المالية.
                    </p>
                </div>
            </section>
        </div>

        <!-- Signatures -->
        <div class="grid grid-cols-2 gap-16 mt-20 pt-16 border-t border-gray-100">
            <div class="text-center">
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-12">توقيع الطرف الأول (المنصة)</p>
                <div class="h-24 border-b-2 border-dashed border-gray-200 mb-4"></div>
                <p class="text-sm font-bold text-gray-400 italic">الختم الرسمي للمنصة</p>
            </div>
            <div class="text-center">
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-12">توقيع الطرف الثاني (المؤسسة)</p>
                <div class="h-24 border-b-2 border-dashed border-gray-200 mb-4"></div>
                <p class="text-sm font-bold text-gray-400 italic">الختم الرسمي للمؤسسة</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-20 text-center opacity-30 no-print">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.5em]">This document is generated electronically via {{ config('app.name') }} Admin Portal</p>
        </div>
    </div>

    <style>
        @media print {
            body { 
                background: white !important; 
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print, aside, header { display: none !important; }
            .print-container { 
                box-shadow: none !important; 
                border: none !important; 
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
            }
            main { 
                padding: 0 !important; 
                margin: 0 !important;
                overflow: visible !important;
            }
            .x-admin-layouts-master { padding: 0 !important; }
        }
        .rtl { direction: rtl; text-align: right; }
    </style>
</x-admin::layouts.master>
