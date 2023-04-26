<!DOCTYPE html>
<html>
<head>
    <title>Email View</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        /* Define styles for the email view page */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #1f1f1f;
            background-color: #f5f5f5;
        }

        header {
            background-color: #fff;
            color: #1f1f1f;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            border-bottom: 1px solid #ddd;
        }

        h1 {
            margin: 0;
            font-size: 24px;
            font-weight: normal;
        }

        main {
            padding: 20px;
        }

        .email {
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 16px;
        }

        .from {
            font-weight: bold;
            margin-right: 10px;
        }

        .to {
            font-weight: normal;
            margin: 0;
        }

        .subject {
            font-size: 20px;
            font-weight: normal;
            margin: 16px 0;
        }

        .date {
            color: #aaa;
            text-align: right;
        }

        .message {
            white-space: pre-wrap;
            line-height: 1.5;
            margin-top: 16px;
        }
    </style>
</head>
<body>

<header>
    @if(!empty($email->headers))
        <h1>{{$email->headers->subject}}</h1>
    @else
        <h1>No email found</h1>
    @endif


</header>
@if(!empty($email->headers))
<main>

    <div class="email">
        <div>
            <span class="from">{{$email->headers->from}}</span>
            <span class="to">to {{$email->headers->to}}</span>
        </div>
        <div class="date">{{$email->headers->date}}</div>
        <div class="message">
{!! $email->plain !!}
        </div>
    </div>
</main>
@endif
</body>
</html>
