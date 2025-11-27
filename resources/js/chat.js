/**
 * Chat JavaScript - Slamin V2
 * Handles real-time updates, auto-scroll, and UI interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    initChatFeatures();
});

function initChatFeatures() {
    // Auto-resize textarea
    autoResizeTextarea();
    
    // Auto-scroll on new messages
    setupAutoScroll();
    
    // Keyboard shortcuts
    setupKeyboardShortcuts();
    
    // Message actions
    setupMessageActions();
}

/**
 * Auto-resize textarea as user types
 */
function autoResizeTextarea() {
    const textareas = document.querySelectorAll('.chat-input-field');
    
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });
    });
}

/**
 * Auto-scroll to bottom when new messages arrive
 */
function setupAutoScroll() {
    const messagesContainers = document.querySelectorAll('.chat-messages');
    
    messagesContainers.forEach(container => {
        // Scroll to bottom on load
        scrollToBottom(container);
        
        // Observe for new messages
        const observer = new MutationObserver(() => {
            if (isNearBottom(container)) {
                scrollToBottom(container, true);
            }
        });
        
        observer.observe(container, {
            childList: true,
            subtree: true
        });
    });
}

function scrollToBottom(container, smooth = false) {
    if (!container) return;
    
    container.scrollTo({
        top: container.scrollHeight,
        behavior: smooth ? 'smooth' : 'auto'
    });
}

function isNearBottom(container, threshold = 100) {
    return container.scrollHeight - container.scrollTop - container.clientHeight < threshold;
}

/**
 * Keyboard shortcuts
 */
function setupKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.querySelector('.chat-search input');
            if (searchInput) searchInput.focus();
        }
        
        // Escape to clear search or close modals
        if (e.key === 'Escape') {
            const searchInput = document.querySelector('.chat-search input');
            if (searchInput && searchInput.value) {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
            }
        }
    });
}

/**
 * Message actions (reply, delete, etc.)
 */
function setupMessageActions() {
    document.addEventListener('click', function(e) {
        // Reply to message
        if (e.target.closest('[data-action="reply"]')) {
            const messageId = e.target.closest('[data-message-id]')?.dataset.messageId;
            if (messageId) {
                Livewire.dispatch('setReplyTo', { messageId });
            }
        }
        
        // Delete message
        if (e.target.closest('[data-action="delete"]')) {
            const messageId = e.target.closest('[data-message-id]')?.dataset.messageId;
            if (messageId && confirm('Eliminare questo messaggio?')) {
                Livewire.dispatch('deleteMessage', { messageId });
            }
        }
    });
}

/**
 * Typing indicator
 */
let typingTimeout;
function handleTyping(conversationId) {
    clearTimeout(typingTimeout);
    
    // Emit typing event
    if (window.Echo) {
        window.Echo.private(`conversation.${conversationId}`)
            .whisper('typing', {
                user: window.authUser
            });
    }
    
    // Stop typing after 3 seconds
    typingTimeout = setTimeout(() => {
        if (window.Echo) {
            window.Echo.private(`conversation.${conversationId}`)
                .whisper('stopped-typing', {
                    user: window.authUser
                });
        }
    }, 3000);
}

/**
 * Listen for typing events
 */
if (window.Echo) {
    document.addEventListener('livewire:load', function() {
        const conversationId = document.querySelector('[data-conversation-id]')?.dataset.conversationId;
        
        if (conversationId) {
            window.Echo.private(`conversation.${conversationId}`)
                .listenForWhisper('typing', (e) => {
                    showTypingIndicator(e.user);
                })
                .listenForWhisper('stopped-typing', (e) => {
                    hideTypingIndicator(e.user);
                })
                .listen('MessageSent', (e) => {
                    Livewire.dispatch('messageSent');
                });
        }
    });
}

function showTypingIndicator(user) {
    const indicator = document.getElementById('typing-indicator');
    if (indicator) {
        indicator.textContent = `${user.name} sta scrivendo...`;
        indicator.classList.remove('hidden');
    }
}

function hideTypingIndicator(user) {
    const indicator = document.getElementById('typing-indicator');
    if (indicator) {
        indicator.classList.add('hidden');
    }
}

/**
 * Image preview in modal
 */
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('chat-message-image')) {
        const src = e.target.src;
        showImageModal(src);
    }
});

function showImageModal(src) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-90 p-4';
    modal.innerHTML = `
        <img src="${src}" class="max-w-full max-h-full object-contain" alt="Image">
        <button class="absolute top-4 right-4 text-white text-4xl hover:text-neutral-300">&times;</button>
    `;
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal || e.target.tagName === 'BUTTON') {
            modal.remove();
        }
    });
    
    document.body.appendChild(modal);
}

/**
 * Emoji picker (simple implementation)
 */
const emojis = ['😀', '😂', '😍', '🥰', '😎', '🤔', '👍', '👏', '🎉', '❤️', '🔥', '✨'];

document.addEventListener('click', function(e) {
    if (e.target.closest('[data-emoji-picker]') || e.target.closest('[title="Emoji"]')) {
        const button = e.target.closest('[data-emoji-picker]') || e.target.closest('[title="Emoji"]');
        showEmojiPicker(button);
    }
});

function showEmojiPicker(button) {
    // Remove existing picker
    const existing = document.querySelector('.emoji-picker');
    if (existing) {
        existing.remove();
        return;
    }
    
    const picker = document.createElement('div');
    picker.className = 'emoji-picker absolute bottom-full mb-2 bg-white dark:bg-neutral-800 rounded-lg shadow-xl p-2 grid grid-cols-6 gap-2 z-50';
    picker.style.left = button.offsetLeft + 'px';
    
    emojis.forEach(emoji => {
        const btn = document.createElement('button');
        btn.textContent = emoji;
        btn.className = 'text-2xl hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded p-1 transition';
        btn.onclick = function() {
            const textarea = document.querySelector('.chat-input-field');
            if (textarea) {
                // Insert emoji at cursor position or append
                const cursorPos = textarea.selectionStart || textarea.value.length;
                const textBefore = textarea.value.substring(0, cursorPos);
                const textAfter = textarea.value.substring(cursorPos);
                textarea.value = textBefore + emoji + textAfter;
                
                // Set cursor position after emoji
                const newPos = cursorPos + emoji.length;
                textarea.setSelectionRange(newPos, newPos);
                
                // Trigger Livewire update
                textarea.dispatchEvent(new Event('input', { bubbles: true }));
                textarea.dispatchEvent(new Event('change', { bubbles: true }));
                
                // Also trigger for Livewire wire:model
                if (window.Livewire) {
                    const event = new CustomEvent('input', { bubbles: true, detail: { value: textarea.value } });
                    textarea.dispatchEvent(event);
                }
                
                textarea.focus();
            }
            picker.remove();
        };
        picker.appendChild(btn);
    });
    
    button.parentElement.style.position = 'relative';
    button.parentElement.appendChild(picker);
    
    // Close on click outside
    setTimeout(() => {
        document.addEventListener('click', function closeEmojiPicker(e) {
            if (!picker.contains(e.target) && e.target !== button) {
                picker.remove();
                document.removeEventListener('click', closeEmojiPicker);
            }
        });
    }, 100);
}

/**
 * Mobile responsive
 */
function handleMobileView() {
    if (window.innerWidth < 768) {
        // Hide sidebar when conversation is selected
        const sidebar = document.querySelector('.chat-sidebar');
        const main = document.querySelector('.chat-main');
        
        if (main && main.querySelector('.chat-header')) {
            sidebar?.classList.add('hidden');
        }
    }
}

window.addEventListener('resize', handleMobileView);
handleMobileView();

// Export for use in other scripts
window.chatUtils = {
    scrollToBottom,
    handleTyping,
    showImageModal
};

