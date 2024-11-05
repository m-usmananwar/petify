<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome & Account Verification Email</title>
  <style>
    /* General styling */
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
    .button-container {
      text-align: center;
      margin-top: 20px;
    }
    .verification-code {
      background-color: #f39c12;
      color: white;
      padding: 10px 20px;
      font-size: 18px;
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
      <h1>Welcome to Petify!</h1>
    </div>

    <div class="content">
      <p>Hi {{$user->first_name}} {{$user->last_name}},</p>
      <p>Welcome to Petify! We're excited to have you join our growing family of pet lovers and owners.</p>
      <p>Your account has been successfully created. To start exploring everything Petify has to offer — from discovering the perfect pet to managing your pet's needs — we need you to verify your email address.</p>
      <p>Please use the verification code below to complete your registration:</p>
      
      <div class="button-container">
        <div class="verification-code">{{$verificationCode}}</div>
      </div>

      <p>If you have any questions, feel free to reach out to us at <strong>+923138912762</strong>. We're here to help!</p>
    </div>

    <div class="footer">
      <p>Best regards, Team Petify</p>
    </div>
  </div>

</body>
</html>
