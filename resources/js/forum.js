/**
 * FORUM JAVASCRIPT - Slamin V2
 * Gestione interazioni forum, voti, commenti, moderazione
 */

// Vote System
document.addEventListener('DOMContentLoaded', function() {
    initializeVoteButtons();
    initializeCommentForms();
    initializeReportModal();
    initializeModeration();
});

/**
 * Initialize vote buttons
 */
function initializeVoteButtons() {
    document.querySelectorAll('.vote-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const voteType = this.dataset.voteType;
            const voteableType = this.dataset.voteableType;
            const voteableId = this.dataset.voteableId;
            
            vote(voteType, voteableType, voteableId, this);
        });
    });
}

/**
 * Handle voting
 */
async function vote(voteType, voteableType, voteableId, button) {
    try {
        const response = await fetch('/forum/api/vote', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                vote_type: voteType,
                voteable_type: voteableType,
                voteable_id: voteableId
            })
        });

        const data = await response.json();

        if (data.success) {
            // Update UI
            const voteContainer = button.closest('.post-vote, .comment-vote');
            const scoreElement = voteContainer.querySelector('.vote-score');
            const upvoteBtn = voteContainer.querySelector('.vote-btn.upvote');
            const downvoteBtn = voteContainer.querySelector('.vote-btn.downvote');

            // Update score
            scoreElement.textContent = data.score;
            scoreElement.className = 'vote-score';
            if (data.score > 0) scoreElement.classList.add('positive');
            if (data.score < 0) scoreElement.classList.add('negative');

            // Update button states
            upvoteBtn.classList.remove('active');
            downvoteBtn.classList.remove('active');

            if (data.action === 'added' || data.action === 'changed') {
                button.classList.add('active');
            }

            // Animate
            scoreElement.classList.add('pulse');
            setTimeout(() => scoreElement.classList.remove('pulse'), 300);
        }
    } catch (error) {
        console.error('Vote error:', error);
        showNotification('Errore durante il voto', 'error');
    }
}

/**
 * Initialize comment forms
 */
function initializeCommentForms() {
    // Reply buttons
    document.querySelectorAll('.reply-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const commentId = this.dataset.commentId;
            showReplyForm(commentId);
        });
    });

    // Cancel reply buttons
    document.querySelectorAll('.cancel-reply').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            hideReplyForms();
        });
    });
}

/**
 * Show reply form
 */
function showReplyForm(commentId) {
    hideReplyForms();
    const replyForm = document.getElementById(`reply-form-${commentId}`);
    if (replyForm) {
        replyForm.style.display = 'block';
        replyForm.querySelector('textarea').focus();
    }
}

/**
 * Hide all reply forms
 */
function hideReplyForms() {
    document.querySelectorAll('.reply-form').forEach(form => {
        form.style.display = 'none';
    });
}

/**
 * Initialize report modal
 */
function initializeReportModal() {
    document.querySelectorAll('.report-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const targetType = this.dataset.targetType;
            const targetId = this.dataset.targetId;
            showReportModal(targetType, targetId);
        });
    });
}

/**
 * Show report modal
 */
function showReportModal(targetType, targetId) {
    const modal = document.getElementById('report-modal');
    if (modal) {
        modal.dataset.targetType = targetType;
        modal.dataset.targetId = targetId;
        modal.style.display = 'flex';
    }
}

/**
 * Hide report modal
 */
function hideReportModal() {
    const modal = document.getElementById('report-modal');
    if (modal) {
        modal.style.display = 'none';
    }
}

/**
 * Submit report
 */
async function submitReport(reason, description) {
    const modal = document.getElementById('report-modal');
    const targetType = modal.dataset.targetType;
    const targetId = modal.dataset.targetId;

    try {
        const response = await fetch('/forum/api/report', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                target_type: targetType,
                target_id: targetId,
                reason: reason,
                description: description
            })
        });

        const data = await response.json();

        if (data.success) {
            showNotification(data.message, 'success');
            hideReportModal();
        } else {
            showNotification(data.error || 'Errore durante la segnalazione', 'error');
        }
    } catch (error) {
        console.error('Report error:', error);
        showNotification('Errore durante la segnalazione', 'error');
    }
}

/**
 * Initialize moderation actions
 */
function initializeModeration() {
    // Lock/Unlock post
    document.querySelectorAll('.lock-post-btn').forEach(btn => {
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            const postId = this.dataset.postId;
            await togglePostLock(postId);
        });
    });

    // Sticky/Unsticky post
    document.querySelectorAll('.sticky-post-btn').forEach(btn => {
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            const postId = this.dataset.postId;
            await togglePostSticky(postId);
        });
    });
}

/**
 * Toggle post lock
 */
async function togglePostLock(postId) {
    try {
        const response = await fetch('/forum/api/post/lock', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ post_id: postId })
        });

        const data = await response.json();

        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        }
    } catch (error) {
        console.error('Lock error:', error);
        showNotification('Errore durante l\'operazione', 'error');
    }
}

/**
 * Toggle post sticky
 */
async function togglePostSticky(postId) {
    try {
        const response = await fetch('/forum/api/post/sticky', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ post_id: postId })
        });

        const data = await response.json();

        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        }
    } catch (error) {
        console.error('Sticky error:', error);
        showNotification('Errore durante l\'operazione', 'error');
    }
}

/**
 * Show notification
 */
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: ${type === 'success' ? '#06A77D' : type === 'error' ? '#D62828' : '#004E89'};
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        animation: slideInRight 0.3s ease-out;
    `;

    document.body.appendChild(notification);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

/**
 * Image preview for post creation
 */
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" style="max-width: 100%; border-radius: 8px;">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

/**
 * Character counter for textareas
 */
function updateCharCount(textarea, maxLength) {
    const counter = textarea.nextElementSibling;
    if (counter && counter.classList.contains('char-counter')) {
        const remaining = maxLength - textarea.value.length;
        counter.textContent = `${remaining} caratteri rimanenti`;
        counter.style.color = remaining < 100 ? '#D62828' : '#666';
    }
}

/**
 * Confirm delete actions
 */
function confirmDelete(message) {
    return confirm(message || 'Sei sicuro di voler eliminare questo elemento?');
}

/**
 * Copy link to clipboard
 */
function copyLink(url) {
    navigator.clipboard.writeText(url).then(() => {
        showNotification('Link copiato negli appunti', 'success');
    }).catch(() => {
        showNotification('Errore durante la copia del link', 'error');
    });
}

// Export functions for use in Livewire components
window.forumVote = vote;
window.forumPreviewImage = previewImage;
window.forumUpdateCharCount = updateCharCount;
window.forumConfirmDelete = confirmDelete;
window.forumCopyLink = copyLink;
window.forumShowNotification = showNotification;

