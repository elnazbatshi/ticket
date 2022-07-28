<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>
<body style="direction: rtl">
<h2 class="text-danger">پیام از طرف <span>{{$customerEmail}}</span></h2>
<h3>با سلام خدمت شما</h3>
<h4 style="color: red">تیکت تازه ای در دپارتمان {{$categoryName}} ثبت گردید .</h4>
<h4>موضوع تیکت : {{$request->title}}</h4>
<h4>متن تیکت : {{$request->content}}</h4>
</body>
</html>
