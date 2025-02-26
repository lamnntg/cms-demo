<!DOCTYPE html>
<html>
<head>
    <title>Thông báo đặt hàng. </title>
</head>
<body>
    <title>Thông báo đặt hàng {{$mailData['name']}} </title>

    <p>Tên người đặt: {{ $mailData['name'] }}</p>
    <p>Điện thoại: {{ $mailData['phone'] }}</p>
    <p>Địa chỉ {{ $mailData['address'] }}</p>
    <p>Email: {{ $mailData['email'] }}</p>
    <p>Thời gian đặt hàng: {{ $mailData['time'] }}</p>
    <b>Tổng số tiền: {{ $mailData['amount'] }} VND</b>

    <p>-----Chi tiết đơn hàng --------------</p>
        @foreach ($mailData['products'] as $product)
            <p>Tên sản phẩm: {{ $product['product']['name'] }}</p>
            <p>Size: {{ $product['size'] }}</p>
            <p>Màu sắc: {{ $product['product_sku']['color'] }}</p>
            <p>Đơn giá: {{ $product['price'] }}</p>
            <br/>
        @endforeach
    <p>-------------------</p><br/>

    <p>Thank you</p>
</body>
</html>
