@extends('layouts.app')

@section('title', 'Contact Us - PESO Manolo Fortich')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/contact-section.css') }}">
    <style>
        #chatbot-widget{position:fixed;bottom:1.5rem;right:1.5rem;z-index:9999;display:flex;flex-direction:column;align-items:flex-end;gap:.75rem}
        #chat-window{width:20rem;background:#fff;border-radius:1rem;box-shadow:0 20px 25px -5px rgba(0,0,0,.1),0 10px 10px -5px rgba(0,0,0,.04);border:1px solid #e5e7eb;display:flex;flex-direction:column;overflow:hidden;height:420px}
        #chat-window.hidden{display:none}
        #chat-toggle-btn{background:#1d4ed8;color:#fff;border:none;border-radius:9999px;width:3.5rem;height:3.5rem;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 10px 15px -3px rgba(0,0,0,.1)}
        #chat-toggle-btn:hover{background:#1e40af}
        #chat-header{background:#1d4ed8;padding:.75rem 1rem;display:flex;align-items:center;justify-content:space-between}
        #chat-messages{flex:1;overflow-y:auto;padding:1rem;display:flex;flex-direction:column;gap:.75rem;font-size:.875rem}
        #chat-footer{padding:.75rem;border-top:1px solid #f3f4f6;display:flex;gap:.5rem}
        #chat-input{flex:1;border:1px solid #e5e7eb;border-radius:.75rem;padding:.5rem .75rem;font-size:.875rem;outline:none}
        #chat-input:focus{box-shadow:0 0 0 2px #3b82f6}
        #chat-send-btn{background:#1d4ed8;color:#fff;border:none;border-radius:.75rem;padding:.5rem .75rem;font-size:.875rem;font-weight:600;cursor:pointer}
        #chat-send-btn:hover{background:#1e40af}
        .chat-msg-user{align-self:flex-end;background:#1d4ed8;color:#fff;border-radius:1rem;border-bottom-right-radius:.25rem;padding:.5rem .75rem;max-width:75%}
        .chat-msg-bot{align-self:flex-start;background:#f3f4f6;color:#1f2937;border-radius:1rem;border-bottom-left-radius:.25rem;padding:.5rem .75rem;max-width:75%}
    </style>
@endpush

@section('content')
<div class="contact-page d-flex flex-column min-vh-100">
    <header class="contact-hero" aria-labelledby="contact-heading">
        <div class="contact-hero-inner text-center text-lg-start">
            <span class="contact-hero-accent" aria-hidden="true"></span>
            <h1 id="contact-heading"><i class="bi bi-send-fill me-2" aria-hidden="true"></i>Get in touch</h1>
            <p>Send us a message about job listings, registrations, or local employment programs. We use the same channels as our main office information below.</p>
        </div>
    </header>

    <div class="contact-body">
        <div class="contact-card">
            <div class="contact-card-header">
                <h2><i class="bi bi-chat-dots-fill me-2 text-danger" style="color: #d72638 !important;" aria-hidden="true"></i>Contact form</h2>
                <p>Fields marked with <span class="text-danger">*</span> are required.</p>
            </div>
            <div class="contact-form-wrap">
                @if (session('status'))
                    <div class="alert contact-alert mb-4" role="status">
                        <i class="bi bi-check-circle-fill me-2" aria-hidden="true"></i>{{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mb-4 rounded-3 border-0" style="border-left: 4px solid #d72638 !important;" role="alert">
                        <strong>Please fix the following:</strong>
                        <ul class="mb-0 mt-2 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.submit') }}" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required maxlength="120" autocomplete="name" placeholder="Your name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email" placeholder="you@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="phone" class="form-label">Phone <span class="contact-hint fw-normal">(optional)</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" maxlength="40" autocomplete="tel" placeholder="(088) 123-4567">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" required maxlength="180" placeholder="What is your inquiry about?">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required maxlength="5000" placeholder="Write your message here...">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3 mt-4">
                        <button type="submit" class="btn btn-contact-submit">
                            <i class="bi bi-send me-2" aria-hidden="true"></i>Send message
                        </button>
                        <p class="contact-hint mb-0">You can also reach us at the address and numbers in the footer.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="chatbot-widget">
        <div id="chat-window" class="hidden">
            <div id="chat-header">
                <span style="color:#fff;font-weight:600;font-size:.875rem">PESO Assistant</span>
                <button onclick="toggleChat()" style="background:none;border:none;color:#fff;font-size:1.25rem;cursor:pointer;line-height:1">&times;</button>
            </div>
            <div id="chat-messages"></div>
            <div id="chat-footer">
                <input id="chat-input" type="text" placeholder="Ask a question..." onkeydown="if(event.key==='Enter') sendMessage()">
                <button id="chat-send-btn" onclick="sendMessage()">Send</button>
            </div>
        </div>

        <button id="chat-toggle-btn" onclick="toggleChat()">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-4 4H9v-4z"/>
            </svg>
        </button>
    </div>

    @include('components.footer')
</div>
@endsection

@push('scripts')
    <script>
        function toggleChat() {
            const win = document.getElementById('chat-window');
            win.classList.toggle('hidden');
            if (!win.classList.contains('hidden') && document.getElementById('chat-messages').children.length === 0) {
                appendMessage('bot', 'Hi! I\'m the PESO Assistant. How can I help you today?');
            }
        }

        function appendMessage(role, text) {
            const container = document.getElementById('chat-messages');
            const div = document.createElement('div');
            div.className = role === 'user' ? 'chat-msg-user' : 'chat-msg-bot';
            div.textContent = text;
            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
        }

        async function sendMessage() {
            const input = document.getElementById('chat-input');
            const message = input.value.trim();
            if (!message) return;

            appendMessage('user', message);
            input.value = '';

            appendMessage('bot', '...');
            const dots = document.getElementById('chat-messages').lastChild;

            try {
                const res = await fetch('{{ route('chatbot.chat') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message })
                });
                const data = await res.json();
                dots.textContent = data.reply ?? 'Sorry, I couldn\'t get a response.';
            } catch {
                dots.textContent = 'Something went wrong. Please try again.';
            }
        }
    </script>
@endpush
