<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f7fb; margin: 0; padding: 24px;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; background: #ffffff; border-radius: 8px; overflow: hidden;">
                    <tr>
                        <td style="background: #393185; color: #ffffff; padding: 16px 24px; font-size: 20px; font-weight: bold;">
                            JITO JEAP
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 24px; color: #333333;">
                            <p style="margin: 0 0 12px;">Hello {{ $user->name ?: 'User' }},</p>
                            <p style="margin: 0 0 12px;">
                                Your registration has been completed successfully.
                            </p>
                            <p style="margin: 0 0 12px;">
                                You can now log in and continue your application process.
                            </p>
                            <p style="margin: 24px 0 0;">Thanks,<br>JITO JEAP Team</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
