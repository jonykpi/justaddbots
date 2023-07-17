<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            background-color: #f8f8f8;
            padding: 20px;
        }

        h1, h2, h3, h4, h5, h6 {
            margin: 0;
            line-height: 1.2;
            color: #333;
        }

        p {
            margin: 0 0 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .footer {
            background-color: #eee;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
{{--    <div class="header">--}}

{{--        <h1>{{'You’ve successfully '.$upload_text.' '.$content->file_title.' to folder '.$content->folder->name}}</h1>--}}
{{--    </div>--}}

    @if($summery)
        <div class="content">
            <p style="font-weight: bolder;text-transform: uppercase">{{$prompt}}</p>
            <p>{{$summery}}</p>

        </div>
    @endif
    @if(empty($prompt))
        <div class="content">
            <p>Hi,</p>
            <p>We are pleased to inform you that your file - {{$content->file_title}} - has been successfully {{$upload_text}} to our system. You can now access the updated chatbot by clicking on the following link:</p>
            <p><a href="https://chat.docs2ai.com/?widget={{$content->folder->embedded_id}}">https://chat.docs2ai.com/?widget={{$content->folder->embedded_id}}</a></p>
            <p>Thank you for choosing our services, and we look forward to serving you again soon.</p>
        </div>
    @endif


    <div class="footer">
        <p>If you have any questions or concerns, please do not hesitate to contact us. We are always happy to assist you.</p>
        <p>Thank you for choosing our services, and we look forward to serving you again soon.</p>
    </div>
</div>
</body>
</html>
