<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Back For Correction</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f7fb; margin: 0; padding: 24px;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: #393185; color: #ffffff; padding: 20px 24px; text-align: center;">
                            <h1 style="margin: 0; font-size: 24px; font-weight: bold;">JITO JEAP</h1>
                            <p style="margin: 8px 0 0 0; font-size: 14px; opacity: 0.9;">Educational Financial Assistance Program</p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 32px 24px; color: #333333;">
                            <p style="margin: 0 0 16px; font-size: 16px; line-height: 1.5;">To Student,</p>

                            <p style="margin: 0 0 24px; font-size: 16px; line-height: 1.5;">
                                <strong>EF Asst. request from {{ $user->name }}</strong>
                            </p>

                            <!-- Application Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #f8f9fa; border-radius: 6px; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                                    <span style="color: #6c757d; font-size: 14px;">EF Asst. Type:</span>
                                                </td>
                                                <td style="padding: 8px 0; border-bottom: 1px solid #e9ecef; text-align: right;">
                                                    <span style="color: #333333; font-size: 14px; font-weight: 600;">{{ $user->financial_asset_type ?? 'N/A' }}</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                                    <span style="color: #6c757d; font-size: 14px;">EF Asst. For:</span>
                                                </td>
                                                <td style="padding: 8px 0; border-bottom: 1px solid #e9ecef; text-align: right;">
                                                    <span style="color: #333333; font-size: 14px; font-weight: 600;">{{ $user->financial_asset_for ?? 'N/A' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0;">
                                                    <span style="color: #6c757d; font-size: 14px;">EF Asst. Amount:</span>
                                                </td>
                                                <td style="padding: 8px 0; text-align: right;">
                                                    <span style="color: #333333; font-size: 14px; font-weight: 600;">
                                                        @if($financialAssistanceAmount)
                                                            ₹{{ number_format($financialAssistanceAmount, 2) }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Reject Remark Section -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 0 6px 6px 0; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <p style="margin: 0 0 8px 0; color: #856404; font-size: 14px; font-weight: 600;">
                                            <span style="margin-right: 8px;">⚠️</span>Correction Required:
                                        </p>
                                        <p style="margin: 0; color: #856404; font-size: 14px; line-height: 1.6;">
                                            {!! $rejectRemark !!}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 24px; font-size: 14px; line-height: 1.5; color: #666666;">
                                Please review the above remarks and make the necessary corrections to your application.
                            </p>

                            <!-- View Application Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="padding: 16px 0;">
                                        <a href="{{ route('login') }}" style="display: inline-block; background: #393185; color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 6px; font-size: 16px; font-weight: 600; box-shadow: 0 4px 12px rgba(57, 49, 133, 0.3); transition: all 0.3s ease;">
                                            View Application
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
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
