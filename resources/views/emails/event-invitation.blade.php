<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invito Evento - Slamin</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #dc2626 0%, #f59e0b 100%); padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: bold;">Sei stato invitato!</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <p style="color: #333333; font-size: 16px; line-height: 1.6; margin: 0 0 20px 0;">
                                Ciao <strong>{{ $invitation->invited_name }}</strong>,
                            </p>
                            
                            <p style="color: #333333; font-size: 16px; line-height: 1.6; margin: 0 0 20px 0;">
                                <strong>{{ $inviter->name }}</strong> ti ha invitato come 
                                <strong>
                                    @if($invitation->role === 'performer')
                                        artista
                                    @elseif($invitation->role === 'organizer')
                                        organizzatore
                                    @elseif($invitation->role === 'audience')
                                        pubblico
                                    @else
                                        partecipante
                                    @endif
                                </strong>
                                all'evento <strong>"{{ $event->title }}"</strong> su Slamin.
                            </p>
                            
                            @if($event->start_datetime)
                            <div style="background-color: #f9fafb; border-left: 4px solid #dc2626; padding: 15px; margin: 20px 0;">
                                <p style="color: #333333; font-size: 14px; margin: 0 0 5px 0;"><strong>Data:</strong> {{ $event->start_datetime->format('d/m/Y H:i') }}</p>
                                @if($event->venue_name || $event->city)
                                <p style="color: #333333; font-size: 14px; margin: 0;"><strong>Luogo:</strong> {{ $event->venue_name ?? $event->city }}</p>
                                @endif
                            </div>
                            @endif
                            
                            <p style="color: #333333; font-size: 16px; line-height: 1.6; margin: 20px 0;">
                                Per accettare l'invito e interagire con l'evento, devi registrarti su Slamin.
                            </p>
                            
                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 20px 0;">
                                        <a href="{{ route('register') }}?email={{ urlencode($invitation->invited_email) }}&event_invitation={{ $invitation->id }}" 
                                           style="display: inline-block; background: linear-gradient(135deg, #dc2626 0%, #f59e0b 100%); color: #ffffff; text-decoration: none; padding: 15px 30px; border-radius: 6px; font-weight: bold; font-size: 16px;">
                                            Registrati su Slamin
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="color: #666666; font-size: 14px; line-height: 1.6; margin: 20px 0 0 0;">
                                Una volta registrato, potrai accettare l'invito e partecipare all'evento!
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
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

