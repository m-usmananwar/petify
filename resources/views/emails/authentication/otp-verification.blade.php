<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verification Code</title>
  <style>
    body {
      font-family: 'Poppins', Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .email-container {
      background-color: #ffffff;
      max-width: 600px;
      margin: 0 auto;
      border-radius: 8px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }
    .header {
      background-color: #4b93cf;
      padding: 20px;
      text-align: center;
      color: #ffffff;
    }
    .header h1 {
      margin: 0;
      font-size: 24px;
      font-weight: bold;
    }
    .content {
      padding: 20px;
      color: #333333;
    }
    .content p {
      margin: 0 0 15px 0;
      font-size: 16px;
      line-height: 1.6;
    }
    .otp-container {
      text-align: center;
      margin: 20px 0;
    }
    .otp-code {
      background-color: #f39c12;
      color: white;
      padding: 15px 30px;
      font-size: 20px;
      font-weight: bold;
      border-radius: 4px;
      display: inline-block;
    }
    .footer {
      background-color: #f4f4f4;
      text-align: center;
      padding: 10px;
      font-size: 12px;
      color: #777777;
    }
  </style>
</head>
<body>

  <div class="email-container">

    <div class="header">
      <h1>Verification Code</h1>
    </div>

    <div class="content">
      <p>Hi {{$user->first_name}} {{$user->last_name}},</p>
      
      <p>Your verification code is below. Please use this code to complete your {{$type == 'password' ? 'forgot password' : 'email verification'}} process.</p>
      
      <div class="otp-container">
        <div class="otp-code">{{$otpCode}}</div>
      </div>

      <p>If you didn’t request this, please ignore this email. If you have any questions, contact us at <strong>+923138912762</strong>.</p>
    </div>

    <div class="footer">
      <p>Best regards, Team Petify</p>
    </div>
  </div>

</body>
</html>
