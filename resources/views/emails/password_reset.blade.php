<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
    <table width="100%" bgcolor="#f4f4f4" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table align="center" width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; margin: 40px auto; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td align="center" bgcolor="#1d72b8" style="padding: 20px 0;">
                            <h1 style="color: #ffffff; margin: 0;">Reset Your Password</h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px;">
                            <p style="font-size: 16px; color: #333;">Hi <strong>{{ $name }}</strong>,</p>
                            <p style="font-size: 16px; color: #333;">
                                We received a request to reset your password. Click the button below to proceed:
                            </p>
                            <p style="text-align: center; margin: 30px 0;">
                                <a href="{{ $link }}" style="background-color: #1d72b8; color: #ffffff; padding: 14px 28px; text-decoration: none; border-radius: 6px; display: inline-block; font-weight: bold;">
                                    Reset Password
                                </a>
                            </p>
                            <p style="font-size: 14px; color: #666;">
                                If you did not request a password reset, please ignore this email.
                            </p>
                            <p style="font-size: 14px; color: #666;">
                                <!-- This link will expire in 60 minutes. -->
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" bgcolor="#f4f4f4" style="padding: 20px; font-size: 12px; color: #aaa;">
                            &copy; {{ date('Y') }} Your Company. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
