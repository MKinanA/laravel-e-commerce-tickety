@php
    require_once app_path('Libraries/phpqrcode/qrlib.php');
    dd(QrCode::png($code));
@endphp