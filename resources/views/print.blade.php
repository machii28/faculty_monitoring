<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        /* Default styles */
        .centered-image {
            text-align: center;
        }

        /* Styles for printing */
        @media print {
            .centered-image {
                text-align: center;
                margin: 0 auto;
                display: block;
            }
        }

        .attention {
            margin-top: 20px;
            color: #e06c6c;
        }

        .room {
            font-size: 70px;
        }

        .instruction {
            color: black;
            margin: 40px 80px;
            text-align: left;
        }
    </style>
</head>
<body>
<div class="centered-image">
    <img src="{{ str_replace('storage', '/storage/app/public', storage_path($room->qr_code_path)) }}" alt="">

    <p class="attention">Please Scan the QR code before and after using the Room</p>

    <h1 class="room">
        Room: {{ $room->room_number }}
    </h1>

    <ol class="instruction">
        <li style="margin-top: 10px;">Before using the Room</li>
        <li style="margin-top: 10px;">Using the app. Scan the QR Code</li>
        <li style="margin-top: 10px;">A Prompt will pop-up to input the Subject Code</li>
        <li style="margin-top: 10px;">After using the Rescan the QR Code</li>
    </ol>
</div>
</body>
</html>
