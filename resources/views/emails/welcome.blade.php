<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Company!</title>
</head>
<body>
    <h1>Welcome, {{ $staff->first_name }}!</h1>
    <p>We're excited to have you on board as a staff member at our company.</p>
    <p>Here are your details:</p>
    <ul>
        <li>Name: {{ $staff->first_name }} {{ $staff->last_name }}</li>
        <li>Email: {{ $staff->email }}</li>
        <li>Password: {{ $staff->user_password }}</li>
    </ul>
    <p>We look forward to working with you!</p>
</body>
</html>
