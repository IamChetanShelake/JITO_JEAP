<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3rd Stage Document Correction</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f7fb; margin: 0; padding: 24px;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background: #393185; color: #ffffff; padding: 20px 24px; text-align: center;">
                            <h1 style="margin: 0; font-size: 24px; font-weight: bold;">JITO JEAP</h1>
                            <p style="margin: 8px 0 0 0; font-size: 14px; opacity: 0.9;">Educational Financial Assistance Program</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 32px 24px; color: #333333;">
                            <p style="margin: 0 0 16px; font-size: 16px; line-height: 1.5;">Dear {{ $user->name }},</p>
                            <p style="margin: 0 0 16px; font-size: 16px; line-height: 1.5;">
                                Your 3rd Stage Documents require correction. Please review the remarks below and resubmit the documents.
                            </p>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 0 6px 6px 0; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <p style="margin: 0; color: #856404; font-size: 14px; line-height: 1.6;">
                                            {!! $remark !!}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="padding: 16px 0;">
                                        <a href="{{ route('login') }}" style="display: inline-block; background: #393185; color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 6px; font-size: 16px; font-weight: 600;">
                                            Update Documents
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #f8f9fa; padding: 20px 24px; text-align: center; border-top: 1px solid #e9ecef;">
                            <p style="margin: 0 0 8px 0; color: #6c757d; font-size: 13px;">
                                If you have any questions, please contact our support team.
                            </p>
                            <p style="margin: 0; color: #393185; font-size: 13px; font-weight: 600;">
                                JITO JEAP Team
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
