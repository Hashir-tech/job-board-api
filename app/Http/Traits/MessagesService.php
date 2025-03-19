<?php

namespace App\Http\Traits;

trait MessagesService {

    public function getMessageData($type, $lang = 'en') {
        if ($lang == 'ar' && $type == 'error') {
            return $this->error_de;
        }if ($lang == 'ar' && $type == 'success') {
            return $this->success_de;
        }
        if ($lang == 'en' && $type == 'error') {
            return $this->error_en;
        }if ($lang == 'en' && $type == 'success') {
            return $this->success_en;
        }
    }

    public $success_en = [
        'general_success' => 'Request successfully processed.'
    ];

    public $success_ar = [
        'general_success' => 'تمت معالجة الطلب بنجاح'
    ];


    public $error_en = [
        'general_error' => 'Request not processed at this moment. Please try again or contact with support team.',
        'norecord_error' => 'Sorry, no record found.',
        'validation_error' => 'Validation Failed.',
        'unauthenticated_error' => 'Unauthenticated.',
        'invalid_error' => 'Invalid credentials.'
    ];


    public $error_ar = [
        'general_error' => 'لم تتم معالجة الطلب في هذه اللحظة. يرجى المحاولة مرة أخرى أو التواصل مع فريق الدعم.',
        'norecord_error' => 'عذرا، لم يتم العثور على أي سجل.',
        'validation_error' => 'فشل التحقق من الصحة',
        'unauthenticated_error' => 'غير مصادق عليه',
        'invalid_error' => 'بيانات اعتماد غير صالحة.'


    ];

}
