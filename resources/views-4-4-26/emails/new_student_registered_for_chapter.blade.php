<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Student Registered</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f7fb; margin: 0; padding: 24px;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; background: #ffffff; border-radius: 8px; overflow: hidden;">
                    <tr>
                        <td style="background: #393185; color: #ffffff; padding: 16px 24px; font-size: 20px; font-weight: bold;">
                            JITO JEAP - New Registration
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 24px; color: #333333;">
                            <p style="margin: 0 0 12px;">Hello {{ $chapter->chapter_name }} Team,</p>
                            
                            <p style="margin: 0 0 12px;">
                                A new student has registered for your chapter (<strong>{{ $chapter->chapter_name }}</strong>).
                            </p>
                            
                            <p style="margin: 0 0 12px;">
                                <strong>Student Details:</strong>
                            </p>
                            
                            <table style="width: 100%; margin: 10px 0; border-collapse: collapse;">
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Name:</strong></td>
                                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Email:</strong></td>
                                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Phone:</strong></td>
                                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $user->phone }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>PAN Card:</strong></td>
                                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $user->pan_card }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Aadhar Card:</strong></td>
                                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $user->aadhar_card_number }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>City:</strong></td>
                                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $user->city }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>State:</strong></td>
                                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $user->state }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Pincode:</strong></td>
                                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $user->pin_code }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Application No:</strong></td>
                                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $user->application_no }}</td>
                                </tr>
                            </table>
                            
                            <p style="margin: 24px 0 0;">Thanks,<br>JITO JEAP Team</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>