<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Consultation Record</title>
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
            font-size: 12px;
            color: #333;
        }

        .para-0 {
            margin: 0 !important;
            padding: 0 !important
        }

        .title {
            text-align: center;
            margin-bottom: 30px;
            margin-top: 30px;
        }

        .title p {
            font-size: 16px;
            margin: 5px 0;
            font-weight: bold;
        }

        .patient-info {
            margin-bottom: 20px;
        }

        .patient-info p {
            margin-bottom: 8px;
        }

        .examination,
        .medication,
        .doctors-note {
            margin-bottom: 20px;
        }

        .examination h4,
        .medication h4,
        .doctors-note h4 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            text-align: left;
            margin-top: 10px;
        }

        th,
        td {
            padding: 8px;
            padding-left: 0px;
        }

        .doctors-note p {
            margin-top: 10px;
        }

        .check-mark {
            font-family: DejaVu Sans, sans-serif;
        }

        th,
        td {
            background-color: transparent;
            text-align: left !important;
            font-weight: 400;
        }

        th {
            color: #125567;
        }

        .medication th:nth-child(1),
        .medication td:nth-child(1) {
            width: 35%;
        }

        .medication th:nth-child(2),
        .medication td:nth-child(2) {
            width: 35%;
        }

        .medication th:nth-child(3),
        .medication td:nth-child(3) {
            width: 15%;
        }

        .medication th:nth-child(4),
        .medication td:nth-child(4) {
            width: 15%;
        }
    </style>
</head>

<body>
    <div class="record-container">
        <div style="width: 100%;">
            <div style="width: 50%; float: left;">
                <img src="{{ asset('storage/images/vcs_logo.jpg') }}" alt="VCS Logo"
                    style="width: 120px; object-fit: cover;">
                <div style="text-align: start">
                    <p class="para-0">ទីតាំង/Location: #86B Street 313, Phnom Penh</p>
                    <p class="para-0">ទំនាក់ទំនង/Tell: +855 987654321 / +855 123456789</p>
                    <p class="para-0">អាសយដ្ធានអ៊ីមែល/Email Address: vichesalHospital@gmail.com</p>
                </div>
            </div>
            <div style="width: 50%; float: left; text-align: right;">
                <ul style="list-style-type: none;">
                    <li>លេខសម្គាល់/Record No: {{ $record_no ?? 'N/A' }}</li>
                    <li>កាលបរិច្ឆេទណាត់/Date: {{ $date ?? 'N/A' }}</li>
                </ul>
            </div>
        </div>

        <!-- Title Section -->
        <div class="title" style="color: #125567;">
            <p>កំណត់ត្រាពិគ្រោះវេជ្ជសាស្ត្រ</p>
            <p>MEDICAL CONSULTATION RECORD</p>
        </div>

        <!-- Patient Info Section (Styled Like Image) -->
        <div class="patient-info">
            <span class="label">ឈ្មោះ/Name:</span>
            <span class="data-span">{{ $local_name ?? 'N/A' }} </span>/
            English Name:
            {{ $english_name ?? 'N/A' }}
            <span class="label" style="margin-left: 20px;">ភេទ/Gender:</span> <span
                class="data-span">{{ $gender ?? 'N/A' }}</span>
            <span class="label" style="margin-left: 20px;">អាយុ/Age:</span>
            @if($dob && \Carbon\Carbon::parse($dob)->age)
                {{ \Carbon\Carbon::parse($dob)->age }}
            @else
                N/A
            @endif
            <span class="label">លេខទូរស័ព្ទ/Phone Number:</span> {{ $phone ?? 'N/A' }}
            <span class="label" style="margin-left: 20px;">អ៊ីមែល/Email Address:</span> {{ $email ?? 'N/A' }}
        </div>

        <!-- Examination Section (Styled Like Image) -->
        <div class="examination">
            <table>
                <thead>
                    <tr>
                        <th>ពិនិត្យសុខភាព/Examination</th>
                        <th>លទ្ធផល/Result</th>
                        <th>ធម្មតា/Normal</th>
                        <th>មិនធម្មតា/Abnormal</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($examinations))
                        @foreach($examinations as $exam)
                            <tr>
                                <td>{{ $exam['name'] ?? 'N/A' }}</td>
                                <td>{{ $exam['result'] ?? 'N/A' }}</td>
                                <td class="check-mark">{{ $exam['status'] === 'Normal' ? '✔' : '' }}</td>
                                <td class="check-mark">{{ $exam['status'] === 'Abnormal' ? '✔' : '' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">No examinations available.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Medication Section (Styled Like Image) -->
        <div class="medication">
            <table>
                <thead>
                    <tr>
                        <th>ឈ្មោះ/Name</th>
                        <th>កម្រិត/Dosage</th>
                        <th>ភាពញឹកញាប់/Frequency</th>
                        <th>រយៈពេល/Duration</th>
                    </tr>
                </thead>
                <tbody> @if(!empty($prescriptions)) @foreach($prescriptions as $pres) <tr>
                            <td>{{ $pres['name'] ?? 'N/A' }}</td>
                            <td>{{ $pres['dosage'] ?? 'N/A' }}</td>
                            <td>{{ $pres['frequency'] ?? 'N/A' }}</td>
                            <td>{{ $pres['duration'] ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                @else
                        <tr>
                            <td colspan="4">No prescriptions available.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Doctor's Note Section (Styled Like Image) -->
        <div class="doctors-note">
            <h4 style="font-weight: 400">កំណត់សម្គាល់របស់វេជ្ជបណ្ឌិត/Doctor's Note:</h4>
            <p>{{ $doctors_note ?? 'No doctor\'s note available.' }}</p>
        </div>
    </div>
</body>

</html>
