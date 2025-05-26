<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'accepted' => 'השדה :attribute חייב להתקבל.',
    'accepted_if' => 'השדה :attribute חייב להתקבל כאשר :other הוא :value.',
    'active_url' => 'השדה :attribute חייב להיות URL חוקי.',
    'after' => 'השדה :attribute חייב להיות תאריך אחרי :date.',
    'after_or_equal' => 'השדה :attribute חייב להיות תאריך אחרי או שווה ל:date.',
    'alpha' => 'השדה :attribute חייב להכיל רק אותיות.',
    'alpha_dash' => 'השדה :attribute חייב להכיל רק אותיות, מספרים, מקפים וסימני תחתון.',
    'alpha_num' => 'השדה :attribute חייב להכיל רק אותיות ומספרים.',
    'array' => 'השדה :attribute חייב להיות מערך.',
    'ascii' => 'השדה :attribute חייב להכיל רק תווים וסימנים עם חצי-בייט.',
    'before' => 'השדה :attribute חייב להיות תאריך לפני :date.',
    'before_or_equal' => 'השדה :attribute חייב להיות תאריך לפני או שווה ל:date.',
    'between' => [
        'array' => 'שדה :attribute חייב להיות בין :min ל:max פריטים.',
        'file' => 'שדה :attribute חייב להיות בין :min ל:max קילובייט.',
        'numeric' => 'שדה :attribute חייב להיות בין :min ל:max.',
        'string' => 'שדה :attribute חייב להיות בין :min ל:max תווים.',
    ],
    'boolean' => 'שדה :attribute חייב להיות נכון או שגוי.',
    'can' => 'שדה :attribute מכיל ערך לא מורשה.',
    'confirmed' => 'אישור שדה :attribute אינו תואם.',
    'contains' => 'שדה :attribute חסר ערך נדרש.',
    'current_password' => 'הסיסמה שגויה.',
    'date' => 'שדה :attribute חייב להיות תאריך חוקי.',
    'date_equals' => 'שדה :attribute חייב להיות תאריך השווה ל:date.',
    'date_format' => 'שדה :attribute חייב להתאים לפורמט :format.',
    'decimal' => 'שדה :attribute חייב להיות בעל :decimal מקומות עשרוניים.',
    'declined' => 'שדה :attribute חייב להידחות.',
    'declined_if' => 'שדה :attribute חייב להיות דחוי כאשר :other הוא :value.',
    'different' => 'שדה :attribute ו:other חייבים להיות שונים.',
    'digits' => 'שדה :attribute חייב להיות :digits ספרות.',
    'digits_between' => 'שדה :attribute חייב להיות בין :min ל: max ספרות.',
    'dimensions' => 'שדה :attribute יש לו ממדי תמונה לא תקינים.',
    'distinct' => 'שדה :attribute יש ערך כפול.',
    'doesnt_end_with' => 'שדה :attribute לא יכול להסתיים באחד מהבאים: :values.',
    'doesnt_start_with' => 'שדה :attribute לא יכול להתחיל באחד מהבאים: :values.',
    'email' => 'שדה :attribute חייב להיות כתובת דוא"ל חוקית.',
    'ends_with' => 'שדה :attribute חייב להסתיים באחד מהבאים: :values.',
    'enum' =>'הערך הנבחר עבור :attribute אינו תקין.',
    'exists' =>'הערך הנבחר עבור :attribute אינו תקין.',
    'extensions' =>'שדה :attribute חייב להיות עם אחד מהסיומות הבאות: :values.',
    'file'=>'שדה :attribute חייב להיות קובץ.',
    'filled' => 'שדה :attribute חייב להיות עם ערך.',
    'gt' => [ 
        'array' => 'שדה ה:attribute חייב להכיל יותר מ: value פריטים.',
        'file' => 'שדה ה:attribute חייב להיות גדול מ: value קילובייט.',
        'numeric' => 'שדה ה:attribute חייב להיות גדול מ: value.', 
        'string' => 'שדה ה:attribute חייב להיות גדול מ: value תוים.', 
    ], 
    'gte' => [ 
        'array' => 'שדה ה:attribute חייב להכיל : value פריטים או יותר.', 
        'file' => 'שדה ה:attribute חייב להיות גדול או שווה ל: value קילובייט.', 
        'numeric' => 'שדה ה:attribute חייב להיות גדול או שווה ל: value.', 
        'string' => 'שדה ה:attribute חייב להיות גדול או שווה ל: value תוים.', 
    ],
    'hex_color' => 'שדה ה:attribute חייב להיות צבע הקסדצימלי חוקי.', 
    'image' => 'שדה ה:attribute חייב להיות תמונה.', 
    'in' => 'הנבחר :attribute אינו חוקי.', 
    'in_array' => 'שדה ה:attribute חייב להיות קיים ב:other.', 
    'integer' => 'שדה ה:attribute חייב להיות שלם.', 
    'ip' => 'שדה ה:attribute חייב להיות כתובת IP חוקית.',
    'ipv4' => 'The :attribute field must be a valid IPv4 address.',
    'ipv6' => 'The :attribute field must be a valid IPv6 address.',
    'json' => 'שדה :attribute חייב להיות מיתר JSON תקף.',
    'list' => 'שדה :attribute חייב להיות רשימה.',
    'lowercase' => 'שדה :attribute חייב להיות באותיות קטנות.',
    'lt' => [ 
        'array' => 'שדה :attribute חייב להכיל פחות מ :value פריטים.',
        'file' => 'שדה :attribute חייב להיות פחות מ :value קילובייטים.',
        'numeric' => 'שדה :attribute חייב להיות פחות מ :value.',
        'string' => 'שדה :attribute חייב להיות פחות מ :value תווים.'
    ], 
    'lte' => [ 
        'array' => 'שדה :attribute לא יכול להכיל יותר מ :value פריטים.',
        'file' => 'שדה :attribute חייב להיות פחות או שווה ל :value קילובייטים.',
        'numeric' => 'שדה :attribute חייב להיות פחות או שווה ל :value.',
        'string' => 'שדה :attribute חייב להיות פחות או שווה ל :value תווים.'
    ],
    'mac_address' => 'שדה :attribute חייב להיות כתובת MAC תקפה.',
    'max' => [
    'array' => 'שדה :attribute לא יכול להכיל יותר מ-:max פריטים.',
    'file' => 'שדה :attribute לא יכול להיות גדול מ-:max קילובייט.',
    'numeric' => 'שדה :attribute לא יכול להיות גדול מ-:max.',
    'string' => 'שדה :attribute לא יכול להיות גדול מ-:max תווים.',
    ],
    'max_digits' => 'שדה :attribute לא יכול להכיל יותר מ-:max ספרות.',
    'mimes' => 'שדה :attribute חייב להיות קובץ מסוג: :values.',
    'mimetypes' => 'שדה :attribute חייב להיות קובץ מסוג: :values.',
    'min' => [
    'array' => 'שדה :attribute חייב להכיל לפחות :min פריטים.',
    'file' => 'שדה :attribute חייב להיות לפחות :min קילובייט.',
    'numeric' => 'שדה :attribute חייב להיות לפחות :min.',
    'string' => 'שדה :attribute חייב להיות לפחות :min תווים.',
    ],
    'min_digits' => 'שדה :attribute חייב להכיל לפחות :min ספרות.',
    'missing' => 'שדה :attribute חייב להיות חסר.',
    'missing_if' => 'שדה :attribute חייב להיות חסר כאשר :other הוא :value.', 
    'missing_unless' => 'שדה :attribute חייב להיות חסר אלא אם כן :other הוא :value.', 
    'missing_with' => 'שדה :attribute חייב להיות חסר כאשר :values נמצא.', 
    'missing_with_all' => 'שדה :attribute חייב להיות חסר כאשר :values נמצאים.', 
    'multiple_of' => 'שדה :attribute חייב להיות כפולה של :value.',
    'not_in' => 'ה:attribute שנבחר אינו תקין.',
    'not_regex' => 'התחביר של השדה :attribute אינו תקין.',
    'numeric' => 'השדה :attribute חייב להיות מספר.',
    'password' => [ 
        'letters' => 'השדה :attribute חייב להכיל לפחות אות אחת.',
        'mixed' => 'השדה :attribute חייב להכיל לפחות אות גדולה אחת ואות קטנה אחת.',
        'numbers' => 'השדה :attribute חייב להכיל לפחות מספר אחד.',
        'symbols' => 'השדה :attribute חייב להכיל לפחות סמל אחד.',
        'uncompromised' => 'ה:attribute שניתן הופיע בהדלפת נתונים. אנא בחר :attribute שונה.'
    ],
    'present' => 'השדה :attribute חייב להיות נוכח.',
    'present_if' => 'השדה :attribute חייב להיות נוכח כאשר :other הוא :value.',
    'present_unless' => 'השדה :attribute חייב להיות נוכח אלא אם כן :other הוא :value.',
    'present_with' => 'השדה :attribute חייב להיות נוכח כאשר :values נוכח.',
    'present_with_all' => 'השדה :attribute חייב להיות נוכח כאשר :values נוכחים.',
    'prohibited' => 'השדה :attribute אסור.', 
    'prohibited_if' => 'השדה :attribute אסור כאשר :other הוא :value.', 
    'prohibited_unless' => 'השדה :attribute אסור אלא אם כן :other נמצא ב:values.', 
    'prohibits' => 'השדה :attribute אוסר על :other להיות נוכח.',
    'regex' => 'תבנית השדה :attribute אינה חוקית.',
    'required' => 'השדה :attribute is required.',
    'required_array_keys' => 'השדה :attribute חייב להכיל ערכים עבור: :values.',
    'required_if' => 'השדה :attribute נדרש כאשר :other הוא :value.',
    'required_if_accepted' => 'השדה :attribute נדרש כאשר :other מתקבל.',
    'required_if_declined' => 'השדה :attribute נדרש כאשר :other נדחה.',
    'required_unless' => 'השדה :attribute נדרש אלא אם :other נמצא ב- :values.',
    'required_with' => 'השדה :attribute נדרש כאשר :values קיים.',
    'required_with_all' => 'השדה :attribute נדרש כאשר :values קיימים.',
    'required_without' => 'השדה :attribute נדרש כאשר :values אינו קיים.',
    'required_without_all' => 'השדה :attribute נדרש כאשר אף אחד מהערכים :אינו קיים.',
    'same' => 'השדה :attribute חייב להתאים :other.',
    'size' => [
        'array' => 'השדה :attribute חייב להכיל :size items.',
        'file' => 'שדה :attribute חייב להיות בגודל של :size קילובייט.', 
        'numeric' => 'שדה :attribute חייב להיות :size.', 
        'string' => 'שדה :attribute חייב להיות באורך של :size תווים.', 
    ],
    'starts_with' => 'שדה :attribute חייב להתחיל באחד מהבאים: :values.', 
    'string' => 'שדה :attribute חייב להיות מיתר.', 
    'timezone' => 'שדה :attribute חייב להיות אזור זמן חוקי.', 
    'unique' => 'שדה :attribute כבר נלקח.', 
    'uploaded' => 'שדה :attribute נכשל בהעלאה.', 
    'uppercase' => 'שדה :attribute חייב להיות באותיות גדולות.', 
    'url' => 'שדה :attribute חייב להיות URL חוקי.', 
    'ulid' => 'שדה :attribute חייב להיות ULID חוקי.', 
    'uuid' => 'שדה :attribute חייב להיות UUID חוקי.', 

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
