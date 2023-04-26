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

{{--        <h1>{{'We’ve encountered an issue while trying to '.$this->upload_text.' '.$this->content->file_title.' to folder '.$this->content->folder->name}}</h1>--}}
{{--    </div>--}}
    <div class="content">
        <p>Hi,</p>
        <p>We are sorry to inform you that your file - {{$content->file_title}} - could not be {{$upload_text}} to our system.</p>
        <p>
            Please check that the file is a PDF, that file name does not incluide “.” periods in the middle of the filename; in the case of updating a file make sure to enter the correct FileID and use the correct syntax in email subject
        </p>
        <p>
            (email subject example:  [[replace={FileID}]]
        </p>
    </div>
    <div class="footer">
        <p>
            If you require further assistance, please do not hesitate to contact us at jquan@cartridgeworld.com. We are always ready to help and ensure that you have a seamless experience.
        </p>
        <p>Thank you for choosing our services, and we look forward to serving you again soon.</p>
    </div>
</div>
</body>
</html>
