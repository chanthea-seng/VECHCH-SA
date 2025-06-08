<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        @font-face {
            font-family: 'kh_content';
            src: url('{{ asset("fonts/kh_content.ttf") }}') format('truetype');
            font-weight: 400;
            font-style: normal;
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'kh_content', sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            text-align: left;
            border: none;
        }

        th,
        td {
            padding: 8px;
        }

        th {
            background-color: #0093BB;
            color: white;
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #e6f7ff;
        }

        ul,
        li {
            all: unset;
        }

        .para-0 {
            margin: 0;
            padding: 0
        }

        .p-20px {
            padding: 20px
        }

        .bg-light {
            background-color: #EDF6F9
        }

        li {
            margin-bottom: 5px;
        }

        ol {
            list-style: none;
            padding-left: 20px;
        }

        ol li {
            position: relative;
            padding-left: 1.5rem;
        }

        .instruction-title {
            color: #00303e
        }

        .row {
            display: flex;
        }
    </style>
</head>

<body>
    <main>
        <div class="row">
            <div style="width: 100%;">
                <div style="width: 50%; float: left;">
                    <img src="{{ asset('storage/images/vcs_logo.jpg') }}" alt="VCS Logo"
                        style="width: 120px; object-fit: cover;">
                    <div style="all: unset; list-style-type: none; text-align: start">
                        <p class="para-0">ទីតាំង/Location: #86B Street 313, Phnom Penh</p>
                        <p class="para-0">ទំនាក់ទំនង/Tell: +855 987654321 / +855 123456789</p>
                        <p class="para-0">អាសយដ្ធានអ៊ីមែល/Email Address: vichesalHospital@gmail.com</p>
                    </div>
                </div>
                <div style="width: 50%; float: left; text-align: right;">
                    <ul style="list-style-type: none;">
                        <li>លេខសម្គាល់/Record No: {{ $record_no }}</li>
                        <li>កាលបរិច្ឆេទណាត់/Date: {{ $date }}</li>
                    </ul>
                </div>
            </div>

            <div style="text-align: center; padding: 0; margin: 0; margin-bottom: 30px;line-height: 0px">
                <p style="color: #125567;">បង្កាន់ដៃបង់ប្រាក់</p>
                <p style="color: #125567;">PAYMENT RECEIPT</p>
                <p>សូមយកបង្កាន់ដៃតាមខ្លួននៅពេលអ្នកធ្វើដំណើរមកទីនេះ</p>
                <p style="font-style: italic">Please bring your receipt with you when you travel here.</p>
            </div>

            <div style="width:100%; margin: 0; padding: 30px; margin-bottom: 30px;" class="bg-light">
                <ul style="list-style-type: none; float:left; width:50%; margin: 0; text-align: left; padding: 0;">
                    <li>ឈ្មោះសមីខ្លួន/Name: {{ $local_name }}</li>
                    <li>ឈ្មោះអក្សរឡាតាំង/English Name: {{ $english_name }}</li>
                    <li>ភេទ/Gender: {{ $gender }}</li>
                    <li>ខែឆ្នាំកំណើត/Date of Birth: {{ $dob }}</li>
                </ul>
                <ul style="list-style-type: none; float:left; width:50%; margin: 0; text-align: left; padding: 0;">
                    <li>លេខទូរស័ព្ទ/Phone Number: {{ $phone }}</li>
                    <li>អាសយដ្ធានអុីមែល/Email Address: {{ $email }}</li>
                    <li>វិធីសាស្ត្របង់ប្រាក់/Payment Method: {{ $payment_method }}</li>
                    <li>ប្រភេទសេវាកម្ម/Type of Service: {{ $service_type }}</li>
                </ul>
            </div>

            <div style="width: 100%; margin: 0; padding: 0; margin-bottom: 30px;">
                <div style="width: 49%; float: left;">
                    <table style="width: 100%; border-collapse: collapse">
                        <thead>
                            <tr>
                                <th>ល.រ/No</th>
                                <th>ប្រភេទសេវាកម្ម/Type of Service</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td>{{ $service['no'] }}</td>
                                    <td>{{ $service['name'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="width: 49%; float:right">
                    <table style="width: 100%; border-collapse: collapse">
                        <thead>
                            <tr>
                                <th colspan="2">ប្រភេទសេវាកម្ម/Type of Service</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>តម្លៃសរុបទាំងអស់/Sub Total</td>
                                <td>${{ number_format($sub_total, 2) }}</td>
                            </tr>
                            <tr>
                                <td>បញ្ចុះតម្លៃ/Promotion</td>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <td>តម្លៃសរុប/Total</td>
                                <td>${{ number_format($total, 2) }}</td>
                            </tr>
                            <tr>
                                <td>កក់ប្រាក់ចំនួន/Deposit</td>
                                <td>${{ number_format($deposit, 2) }}</td>
                            </tr>
                            <tr>
                                <td>នៅសល់សមតុល្យ/Balance</td>
                                <td>${{ number_format($sub_total - $deposit, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <p class="instruction-title">ការណែនាំមុនពេលពិនិត្យសុខភាព អ្នកជំងឺគួរតែធ្វើតាមការណែនាំទាំងនេះ៖
                </p>
                @php
                    $parsedItems = [];

                    if (!empty($instruction)) {
                        $dom = new \DOMDocument();
                        libxml_use_internal_errors(true); // Prevent HTML5 warnings

                        // Load HTML with proper encoding
                        $dom->loadHTML(mb_convert_encoding($instruction, 'HTML-ENTITIES', 'UTF-8'));

                        // Extract all <li> elements
                        foreach ($dom->getElementsByTagName('li') as $li) {
                            $parsedItems[] = trim($li->textContent);
                        }
                    }
                @endphp

                @if (!empty($parsedItems))
                    <ol style="list-style: none; padding-left: 0;">
                        @foreach ($parsedItems as $item)
                            <li style="font-family: 'DejaVu Sans';">&#10003; <span
                                    style="font-family: 'kh_content', sans-serif;">{{ $item }}</span></li>
                        @endforeach
                    </ol>
                @else
                    <ul>
                        <li>សូមជៀសវាងការទទួលអាហារ *ចាប់ពី 8 ដល់ 12 ម៉ោង* មុនពេលធ្វើតេស្ត។</li>
                        <li>លើកលែងតែទឹកស្អាត អ្នកគួរជៀសវាងការប្រើប្រាស់ជាតិកាហ្វេអ៊ីន និងអាល់កុល *ក្នុងរយៈពេល 12-24 ម៉ោង*
                            មុនពិនិត្យ។</li>
                        <li>សូមផឹកទឹកឲ្យគ្រប់គ្រាន់ដើម្បីបង្ការការខ្វះទឹកក្នុងរាងកាយ។</li>
                        <li>សូមអនុវត្តតាមសេចក្ដីណែនាំរបស់វេជ្ជបណ្ឌិតចំពោះការប្រើថ្នាំ (បើមាន)។</li>
                        <li>ប្រសិនបើមានអាហារដែលត្រូវពិសារឬជៀសវាងជាពិសេស សូមអនុវត្តតាមការណែនាំ។</li>
                    </ul>
                @endif
            </div>
        </div>

    </main>
</body>

</html>
