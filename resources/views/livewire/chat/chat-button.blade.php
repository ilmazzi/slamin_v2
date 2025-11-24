<div>
    @auth
    {{-- Nascondi il pulsante quando si è già nella pagina chat --}}
    @if(!request()->routeIs('chat.*'))
    <div class="fixed bottom-6 right-6 z-50">
        <a href="{{ route('chat.index') }}" 
           class="chat-fab group"
           title="Messaggi">
            <!-- Badge messaggi non letti -->
            @if($unreadCount > 0)
                <span class="chat-fab-badge">
                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                </span>
            @endif
            
            <!-- Icona Chat -->
            <svg class="w-6 h-6 transition-transform group-hover:scale-110" 
                 fill="none" 
                 stroke="currentColor" 
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" 
                      stroke-linejoin="round" 
                      stroke-width="2" 
                      d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
        </a>
    </div>
    @endif

    <style>
    .chat-fab {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #05A77D 0%, #06D6A0 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(5, 167, 125, 0.4);
        transition: all 0.3s ease;
        position: relative;
        cursor: pointer;
    }

    .chat-fab:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(5, 167, 125, 0.5);
    }

    .chat-fab:active {
        transform: translateY(-2px);
    }

    .chat-fab-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        min-width: 24px;
        height: 24px;
        background: #EF4444;
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0 6px;
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .chat-fab {
            width: 56px;
            height: 56px;
        }
        
        .chat-fab svg {
            width: 24px;
            height: 24px;
        }
    }
    </style>
    @endauth
</div>
