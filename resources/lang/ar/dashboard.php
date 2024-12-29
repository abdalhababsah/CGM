<?php

return [
    // General Dashboard and Authentication
    'dashboard'                  => 'لوحة التحكم',
    'unauthorized'               => 'إجراء غير مصرح به.',
    'invoice_generation_failed'  => 'فشل في إنشاء الفاتورة. يرجى المحاولة مرة أخرى لاحقًا.',
    'my_orders'    => 'طلباتي',
    'report_order' => 'تقرير الطلب',
    // User Orders
    'user_orders' => [
        'orders_table'       => 'طلباتي',
        'order_id'           => 'رقم الطلب',
        'user'               => 'المستخدم',
        'ordered_at'         => 'تم الطلب في',
        'total'              => 'الإجمالي',
        'status'             => 'الحالة',
        'actions'            => 'الإجراءات',
        'completed'          => 'مكتمل',
        'pending'            => 'قيد الانتظار',
        'secondary'          => 'قيد الانتظار', // Assuming 'secondary' represents 'On Hold'
        'view'               => 'عرض',
        'no_orders_found'    => 'لم يتم العثور على طلبات.',
    ],

    // Order Details
    'order_details' => [
        'order_details'      => 'تفاصيل الطلب',
        'product'            => 'المنتج',
        'unit_price'         => 'سعر الوحدة',
        'quantity'           => 'الكمية',
        'total'              => 'الإجمالي',
        'customer_information' => 'معلومات العميل',
        'name'               => 'الاسم',
        'email'              => 'البريد الإلكتروني',
        'phone'              => 'الهاتف',
        'delivery_information' => 'معلومات التوصيل',
        'address'            => 'العنوان',
        'city'               => 'المدينة',
        'country'            => 'الدولة',
    ],

    // Order Summary
    'order_summary' => [
        'order_summary'      => 'ملخص الطلب',
        'subtotal'           => 'المجموع الفرعي',
        'discount'           => 'الخصم',
        'delivery_price'     => 'سعر التوصيل',
        'total'              => 'الإجمالي',
    ],

    // Actions
    'actions' => [
        'back_to_my_orders'  => 'العودة إلى طلباتي',
        'actions'            => 'الإجراءات',
    ],

    // User Profile
    'profile'                    => 'الملف الشخصي',

    // Logout
    'logout'                     => 'تسجيل الخروج',

    // Additional General Translations
    'total_users'                => 'إجمالي المستخدمين',
    'total_orders'               => 'إجمالي الطلبات',
    'total_revenue'              => 'إجمالي الإيرادات',
    'back_to_shop'               => 'العودة إلى المتجر',
    'new_products'               => 'منتجات جديدة !!',
    // Add more translation keys as needed
];