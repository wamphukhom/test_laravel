<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เกี่ยวกับเรา</title>
</head>

<body>
    <h1>ยินดีต้อนรับ นี้คือหน้า about</h1>
    <p>
        ที่อยู่ : {{ $city }}<!-- ค่าที่อยู่ใน controller -->
    </p>
    <p>
        เบอร์ : {{ $tel }}<!-- ค่าที่อยู่ใน controller -->
    </p>
    <p style="color:red;">{{$error}}</p>

    <a href="{{ url('/') }}">Home</a>
    <a href="{{ url('/admin') }}">Admin</a>
    <a href="{{ url('/member') }}">Member</a>
    <a href="{{ URL::route('about') }}">About</a>
    <a href="{{ url('/users/{1name}&{2lname}') }}">users1</a>
    <a href="{{ URL::route('users', ['name' => 'John', 'lname' => 'Doe']) }}">users2</a>
    <?php
    $url = URL::route('users', ['name' => 'max', 'lname' => 'liner']);
    ?>
    <a href="{{ $url }}">users3</a>
</body>

</html>
