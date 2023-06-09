<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เกี่ยวกับเรา</title>
</head>

<body>
    <?php
    $user = 'KKKK';
    $arrayName = ['Home', 'MEMBER', 'About','Contact'];
    ?>

    <h1>นี้คือหน้า admin ยินดีต้อนรับ admin</h1>
    <p></p>
    <h2>{{ $user }}</h2>
    <p></p>

    @if ($user == 'KKKK')
        <h1>คุณคือ admin</h1>
    @else
        <h1>คุณคือ ใคร ใครคือ คุณ</h1>
    @endif

    @foreach ($arrayName as $menu)
    <a href="">{{$menu}}</a>

    @endforeach

    @for ($i=0;$i<=5;$i++)
    <p>{{$i}}</p>

    @endfor
</body>

</html>
