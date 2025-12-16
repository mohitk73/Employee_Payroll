<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payslip</title>

    <style>
        body {
          
            font-size: 13px;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        hr {
            border: 1px solid #1479b8;
            margin: 12px 0;
        }

        h3 {
            margin: 5px 0;
        }

        .blue {
            color: #1479b8;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            padding: 6px;
            vertical-align: top;
        }

        th {
            text-align: left;
            color: #1479b8;
        }

        .netpay-box {
            text-align: center;
            padding: 15px;
        }

        .netpay-amount {
            font-size: 28px;
            font-weight: bold;
        }

        .net-row {
            background: #add5ec;
            font-weight: bold;
        }

        .note {
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- COMPANY HEADER -->
    <table>
        <tr>
            <td>
                <h3>Mind2Web</h3>
                <p>Mohali, India</p>
            </td>
            <td align="right">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4ufOjMD7ZU4Ww2oHuSAuX1nTeLe6hZu_gIA&s" width="50">
            </td>
        </tr>
    </table>

    <hr>

    <h3>Payslip for the month of <?= date('F Y', strtotime($result['month'])) ?></h3>

    <br>
    <!-- employee summary  -->
    <table>
        <tr>
            <td width="60%">
                <h3 class="blue">Employee Pay Summary</h3>

                <table>
                    <tr><td>Payslip ID</td><td>: <?= $result['payslip_id'] ?></td></tr>
                    <tr><td>Employee ID</td><td>: <?= $result['id'] ?></td></tr>
                    <tr><td>Employee Name</td><td>: <?= $result['name'] ?></td></tr>
                    <tr><td>Job Position</td><td>: <?= $result['position'] ?></td></tr>
                    <tr><td>Date of Joining</td><td>: <?= $result['joining'] ?></td></tr>
                    <tr><td>Pay Month</td><td>: <?= date('F Y', strtotime($result['month'])) ?></td></tr>
                    <tr><td>Pay Date</td><td>: <?= date('d M Y', strtotime($paydate)) ?></td></tr>
                </table>
            </td>

            <td width="40%">
                <div class="netpay-box">
                    <h3>Employee Net Pay</h3>
                    <div class="netpay-amount">
                        ₹<?= number_format($result['net_salary'], 2) ?>
                    </div>
                    <p>
                        Paid Days: <?= $result['present_days'] ?> |
                        LOP Days: <?= $result['absent_days'] ?>
                    </p>
                </div>
            </td>
        </tr>
    </table>

    <hr>

    <!--  earnings -->
    <table>
        <thead>
            <tr>
                <th>Earnings</th>
                <th align="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Basic Salary</td>
                <td align="right">₹<?= number_format($result['basic_salary'],2) ?></td>
            </tr>
            <tr>
                <td>House Rent Allowance</td>
                <td align="right">₹<?= number_format($result['hra'],2) ?></td>
            </tr>
            <tr>
                <td><strong>Gross Earnings</strong></td>
                <td align="right"><strong>₹<?= number_format($result['gross_salary'],2) ?></strong></td>
            </tr>
        </tbody>
    </table>

    <hr>

    <!-- attendance -->
    <table>
        <thead>
            <tr>
                <th>Attendance</th>
                <th align="right">Total Days</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Present Days</td>
                <td align="right"><?= $result['present_days'] ?></td>
            </tr>
            <tr>
                <td>Absent Days</td>
                <td align="right"><?= $result['absent_days'] ?></td>
            </tr>
        </tbody>
    </table>

    <hr>

    <!-- deductions -->
    <table>
        <thead>
            <tr>
                <th>Deductions</th>
                <th align="right">(-) Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Professional Tax</td>
                <td align="right">₹<?= number_format($result['deduction'],2) ?></td>
            </tr>
            <tr>
                <td>Absent Days</td>
                <td align="right">₹<?= number_format($absentdeduction,2) ?></td>
            </tr>
            <tr>
                <td><strong>Total Deductions</strong></td>
                <td align="right"><strong>₹<?= number_format($result['deductions'],2) ?></strong></td>
            </tr>
            <tr class="net-row">
                <td>Net Pay (Gross - Deductions)</td>
                <td align="right">₹<?= number_format($result['net_salary'],2) ?></td>
            </tr>
        </tbody>
    </table>

    <br>

    <h3 align="center">
        Total Net Payable ₹<?= number_format($result['net_salary'],2) ?>
    </h3>

    <hr>

    <p class="note">
        -- This document is generated by Mind2Web Payroll, therefore a signature is not required --
    </p>

</div>

</body>
</html>
