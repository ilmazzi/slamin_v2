<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter - Slamin</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #dc2626 0%, #f59e0b 100%); padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: bold;">Newsletter Slamin</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            @if($subscriber && $subscriber->name)
                            <p style="color: #333333; font-size: 16px; line-height: 1.6; margin: 0 0 20px 0;">
                                Ciao <strong>{{ $subscriber->name }}</strong>,
                            </p>
                            @endif
                            
                            <div style="color: #333333; font-size: 16px; line-height: 1.6;">
                                {!! nl2br(e($content)) !!}
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
                            @if($unsubscribeUrl)
                            <p style="color: #666666; font-size: 12px; margin: 0 0 10px 0;">
                                <a href="{{ $unsubscribeUrl }}" style="color: #dc2626; text-decoration: none;">Disiscriviti dalla newsletter</a>
                            </p>
                            @endif
                            <p style="color: #666666; font-size: 12px; margin: 0;">
                                Questo è un messaggio automatico da Slamin. Non rispondere a questa email.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

