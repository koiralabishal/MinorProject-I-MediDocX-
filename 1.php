<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- page1.php -->
    <div class="visit" data-visit-id="1" data-date="2024-04-12">Visit 1</div>
    <div class="patient" data-patient-id="101" data-patient-name="John" data-patient-age="30" data-patient-gender="Male" data-visit-id="1">Patient 1</div>

    <!-- page2.php -->
    <div class="visit" data-visit-id="2" data-date="2024-04-13">Visit 2</div>
    <div class="patient" data-patient-id="102" data-patient-name="Alice" data-patient-age="25" data-patient-gender="Female" data-visit-id="2">Patient 2</div>

</body>
<!-- JavaScript code in page1.php -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var visits = document.querySelectorAll('.visit');
        var patients = document.querySelectorAll('.patient');

        visits.forEach(function (visit) {
            visit.addEventListener('click', function () {
                var visitID = this.getAttribute('data-visit-id');
                var date = this.getAttribute('data-date');

                var xhr = new XMLHttpRequest();
                xhr.open('POST', '3.php');
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Handle the response if needed
                        window.location.href = '3.php'; // Redirect to page 2
                    }
                };

                var data = {
                    visitID: visitID,
                    date: date
                };

                xhr.send(JSON.stringify(data));
            });
        });

        patients.forEach(function (patient) {
            patient.addEventListener('click', function () {
                var patientID = this.getAttribute('data-patient-id');
                var patientName = this.getAttribute('data-patient-name');
                var patientAge = this.getAttribute('data-patient-age');
                var patientGender = this.getAttribute('data-patient-gender');
                var visitID = this.getAttribute('data-visit-id');

                var xhr = new XMLHttpRequest();
                xhr.open('POST', '2.php');
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Handle the response if needed
                        window.location.href = '2.php'; // Redirect to page 3
                    }
                };

                var data = {
                    patientID: patientID,
                    patientName: patientName,
                    patientAge: patientAge,
                    patientGender: patientGender,
                    visitID: visitID
                };

                xhr.send(JSON.stringify(data));
            });
        });
    });
</script>

</html>
