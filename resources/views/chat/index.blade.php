@extends('layouts.app')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="mv-card inline-flex w-fit rounded-2xl border border-white/30 bg-white/95 px-4 py-2 shadow-xl dark:border-slate-700 dark:bg-slate-800">
        <p class="text-2xl font-bold uppercase tracking-wide text-slate-700 md:text-3xl dark:text-slate-200">
            <i data-lucide="message-circle" class="inline-block w-7 h-7 mr-1 align-middle"></i>
            Group Chat
        </p>
    </div>

    {{-- Chat Container --}}
    <div class="mv-card rounded-2xl border border-white/30 bg-white/95 shadow-xl dark:border-slate-700 dark:bg-slate-800 flex flex-col" style="height: calc(100vh - 260px); min-height: 400px;">

        {{-- Chat Messages Area --}}
        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-3">
            {{-- Loading indicator --}}
            <div id="chat-loading" class="flex items-center justify-center h-full">
                <div class="text-center text-slate-400 dark:text-slate-500">
                    <i data-lucide="loader-2" class="inline-block w-8 h-8 animate-spin mb-2"></i>
                    <p>Loading messages...</p>
                </div>
            </div>

            {{-- Empty state --}}
            <div id="chat-empty" class="hidden flex items-center justify-center h-full">
                <div class="text-center text-slate-400 dark:text-slate-500">
                    <i data-lucide="message-square-plus" class="inline-block w-12 h-12 mb-2 opacity-50"></i>
                    <p class="text-lg font-medium">Walang messages pa</p>
                    <p class="text-sm">Maging una kang mag-send ng message!</p>
                </div>
            </div>
        </div>

        {{-- Divider --}}
        <div class="border-t border-slate-200 dark:border-slate-600"></div>

        {{-- Message Input Area --}}
        <div class="p-4">
            <form id="chat-form" class="flex items-end gap-3">
                <div class="flex-1 relative">
                    <textarea
                        id="chat-input"
                        name="message"
                        rows="1"
                        maxlength="5000"
                        placeholder="Type your message..."
                        class="w-full resize-none rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 dark:placeholder-slate-400 dark:focus:border-blue-400 dark:focus:ring-blue-400/20"
                        style="max-height: 120px;"
                    ></textarea>
                </div>
                <button
                    type="submit"
                    id="chat-send-btn"
                    class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:ring-2 focus:ring-blue-500/50 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed dark:bg-blue-500 dark:hover:bg-blue-600"
                >
                    <i data-lucide="send" class="w-4 h-4"></i>
                    Send
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const messagesContainer = document.getElementById('chat-messages');
    const chatLoading = document.getElementById('chat-loading');
    const chatEmpty = document.getElementById('chat-empty');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const sendBtn = document.getElementById('chat-send-btn');
    const currentUserId = @json(auth()->id());
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let lastMessageId = 0;

    // Auto-resize textarea
    chatInput.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    // Send on Enter (Shift+Enter for newline)
    chatInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            chatForm.dispatchEvent(new Event('submit'));
        }
    });

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function formatTime(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const isToday = date.toDateString() === now.toDateString();

        const time = date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });

        if (isToday) {
            return time;
        }

        const dateStr = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        return dateStr + ' ' + time;
    }

    function getInitials(name) {
        return name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
    }

    function getAvatarColor(userId) {
        const colors = [
            'bg-blue-500', 'bg-emerald-500', 'bg-violet-500', 'bg-amber-500',
            'bg-rose-500', 'bg-cyan-500', 'bg-indigo-500', 'bg-pink-500',
            'bg-teal-500', 'bg-orange-500'
        ];
        return colors[userId % colors.length];
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function createMessageElement(msg) {
        const isOwn = msg.user_id === currentUserId;
        const userName = msg.user ? msg.user.name : 'Unknown';
        const profilePhoto = msg.user && msg.user.profile_photo_path
            ? '/storage/' + msg.user.profile_photo_path
            : null;

        const wrapper = document.createElement('div');
        wrapper.className = 'flex items-end gap-2.5 ' + (isOwn ? 'justify-end' : 'justify-start');
        wrapper.dataset.messageId = msg.id;

        // Avatar (left side for others)
        const avatarHtml = profilePhoto
            ? '<img src="' + escapeHtml(profilePhoto) + '" alt="' + escapeHtml(userName) + '" class="w-8 h-8 rounded-full object-cover shadow-sm">'
            : '<div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shadow-sm ' + getAvatarColor(msg.user_id) + '">' + escapeHtml(getInitials(userName)) + '</div>';

        const bubbleClass = isOwn
            ? 'bg-blue-600 text-white rounded-2xl rounded-br-md'
            : 'bg-slate-100 text-slate-800 rounded-2xl rounded-bl-md dark:bg-slate-700 dark:text-slate-200';

        const nameClass = isOwn
            ? 'text-blue-200 text-xs font-medium mb-0.5'
            : 'text-slate-500 text-xs font-medium mb-0.5 dark:text-slate-400';

        const timeClass = isOwn
            ? 'text-blue-200/70 text-[10px] mt-1'
            : 'text-slate-400 text-[10px] mt-1 dark:text-slate-500';

        const messageText = escapeHtml(msg.message).replace(/\n/g, '<br>');

        if (isOwn) {
            wrapper.innerHTML =
                '<div class="max-w-[70%] min-w-[120px]">' +
                    '<div class="' + bubbleClass + ' px-3.5 py-2 shadow-sm">' +
                        '<div class="' + nameClass + '">You</div>' +
                        '<div class="text-sm leading-relaxed break-words">' + messageText + '</div>' +
                        '<div class="' + timeClass + ' text-right">' + formatTime(msg.created_at) + '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="flex-shrink-0">' + avatarHtml + '</div>';
        } else {
            wrapper.innerHTML =
                '<div class="flex-shrink-0">' + avatarHtml + '</div>' +
                '<div class="max-w-[70%] min-w-[120px]">' +
                    '<div class="' + bubbleClass + ' px-3.5 py-2 shadow-sm">' +
                        '<div class="' + nameClass + '">' + escapeHtml(userName) + '</div>' +
                        '<div class="text-sm leading-relaxed break-words">' + messageText + '</div>' +
                        '<div class="' + timeClass + '">' + formatTime(msg.created_at) + '</div>' +
                    '</div>' +
                '</div>';
        }

        return wrapper;
    }

    function renderMessages(messages) {
        // Remove loading/empty states
        chatLoading.classList.add('hidden');
        chatEmpty.classList.add('hidden');

        if (messages.length === 0) {
            chatEmpty.classList.remove('hidden');
            chatEmpty.classList.add('flex');
            return;
        }

        // Remove existing dynamic messages
        messagesContainer.querySelectorAll('[data-message-id]').forEach(el => el.remove());

        messages.forEach(function (msg) {
            messagesContainer.appendChild(createMessageElement(msg));
            if (msg.id > lastMessageId) {
                lastMessageId = msg.id;
            }
        });

        scrollToBottom();
    }

    function appendMessage(msg) {
        chatEmpty.classList.add('hidden');
        chatEmpty.classList.remove('flex');

        messagesContainer.appendChild(createMessageElement(msg));

        if (msg.id > lastMessageId) {
            lastMessageId = msg.id;
        }

        scrollToBottom();
    }

    // Fetch all messages
    function fetchMessages() {
        fetch('/messages', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
        .then(function (response) {
            if (!response.ok) throw new Error('Failed to fetch messages');
            return response.json();
        })
        .then(function (messages) {
            renderMessages(messages);
        })
        .catch(function (error) {
            console.error('Fetch messages error:', error);
            chatLoading.innerHTML = '<div class="text-center text-red-400"><p>Failed to load messages. Retrying...</p></div>';
            setTimeout(fetchMessages, 3000);
        });
    }

    // Send message
    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const message = chatInput.value.trim();
        if (!message) return;

        sendBtn.disabled = true;
        chatInput.disabled = true;

        fetch('/messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ message: message }),
        })
        .then(function (response) {
            if (!response.ok) throw new Error('Failed to send message');
            return response.json();
        })
        .then(function (msg) {
            appendMessage(msg);
            chatInput.value = '';
            chatInput.style.height = 'auto';
        })
        .catch(function (error) {
            console.error('Send message error:', error);
            alert('Hindi na-send ang message. Subukan ulit.');
        })
        .finally(function () {
            sendBtn.disabled = false;
            chatInput.disabled = false;
            chatInput.focus();
        });
    });

    // Initial load
    fetchMessages();

    // Poll for new messages every 3 seconds
    setInterval(fetchMessages, 3000);

    // Re-initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
@endsection
