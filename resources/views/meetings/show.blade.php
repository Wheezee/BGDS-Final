@extends('layouts.app')

@section('title', 'Meeting Details')

@section('header', 'Meeting Details')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-purple: #6f42c1;
            --light-purple: #e9ecef;
            --dark-purple: #563d7c;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: var(--primary-purple);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
        }

        .meeting-details {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .meeting-details h4 {
            color: var(--primary-purple);
            margin-bottom: 20px;
            font-weight: 600;
        }

        .meeting-details p {
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .meeting-details .label {
            font-weight: 600;
            color: var(--dark-purple);
        }

        .transcription {
            white-space: pre-wrap;
            overflow-x: auto;
            font-family: monospace;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #e9ecef;
        }

        .attendees-list, .absentees-list {
            list-style-type: none;
            padding-left: 0;
        }

        .attendees-list li, .absentees-list li {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .attendees-list li:last-child, .absentees-list li:last-child {
            border-bottom: none;
        }

        .attachments-list {
            list-style-type: none;
            padding-left: 0;
        }

        .attachment-item {
            border: 1px solid #e9ecef;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .attachment-info {
            flex-grow: 1;
        }

        .attachment-name {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .attachment-description {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .attachment-meta {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .attachment-actions {
            display: flex;
            gap: 5px;
        }

        /* AI Chat Modal Styles */
        .typing-indicator {
            padding: 12px 16px;
            background: var(--light-purple);
            border-radius: 12px;
            width: fit-content;
            margin: 8px 0;
            display: flex;
            gap: 4px;
        }

        .typing-indicator span {
            height: 8px;
            width: 8px;
            background: var(--primary-purple);
            border-radius: 50%;
            display: inline-block;
            animation: typing 1.4s infinite both;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {
            0% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
            100% { transform: translateY(0); }
        }

        .message-bubble {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .message-user {
            background-color: var(--primary-purple);
            color: white;
            margin-left: auto;
        }

        .message-assistant {
            background-color: var(--light-purple);
            color: var(--dark-purple);
        }

        .markdown-content {
            line-height: 1.6;
        }

        .markdown-content h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 1rem 0 0.5rem 0;
        }

        .markdown-content ul, .markdown-content ol {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .markdown-content li {
            margin-bottom: 0.5rem;
        }

        .markdown-content p {
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .navbar {
                display: flex !important;
                position: relative !important;
                z-index: 1100 !important;
                width: 100% !important;
            }
            #content {
                padding-top: 56px !important; /* Adjust if your navbar is taller/shorter */
            }
            #sidebar {
                z-index: 100 !important;
            }
        }
    </style>
@endpush

@section('content')
            <div class="container-fluid mt-4">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Meeting Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="meeting-details">
                                    <p><span class="label">Date and Time:</span> {{ \Carbon\Carbon::parse($meeting->date_time)->format('F j, Y h:i A') }}</p>
                                    <p><span class="label">Duration:</span> {{ $meeting->duration ?? 'Not specified' }}</p>
                                    <p><span class="label">Venue:</span> {{ $meeting->venue }}</p>
                                    <p><span class="label">Organizer:</span> {{ $meeting->organizer }}</p>
                                    <p><span class="label">Agenda:</span> {{ $meeting->agenda }}</p>
                                    
                                    <h4 class="mt-4">Attendees</h4>
                                    <ul class="attendees-list">
                                        @foreach($meeting->attendees as $attendee)
                                            <li>{{ $attendee }}</li>
                                        @endforeach
                                    </ul>

                                    @if($meeting->absentees)
                                        <h4 class="mt-4">Absentees</h4>
                                        <ul class="absentees-list">
                                            @foreach($meeting->absentees as $absentee)
                                                <li>{{ $absentee }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if($meeting->transcription || $meeting->transcription_file_path)
                                        <h4 class="mt-4">Meeting Transcription</h4>
                                        @if($meeting->transcription)
                                            <div class="transcription mb-3">{{ $meeting->transcription }}</div>
                                        @endif
                                        
                                        @if($meeting->transcription_file_path)
                                            <div class="mt-2">
                                                @if(Str::endsWith(strtolower($meeting->transcription_file_path), ['.jpg', '.jpeg', '.png', '.gif', '.bmp']))
                                                    <div class="text-center mb-2">
                                                        <img src="/storage/{{ $meeting->transcription_file_path }}" alt="Transcription Image" 
                                                             class="img-fluid border rounded" style="max-height: 600px;">
                                                    </div>
                                                @elseif(Str::endsWith(strtolower($meeting->transcription_file_path), ['.pdf']))
                                                    <div class="ratio ratio-16x9 mb-2" style="min-height: 500px;">
                                                        <iframe src="/storage/{{ $meeting->transcription_file_path }}" 
                                                                title="Transcription PDF" allowfullscreen></iframe>
                                                    </div>
                                                @endif
                                                <a href="{{ route('meetings.download-transcription', $meeting) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-download"></i> Download Transcription File
                                                </a>
                                            </div>
                                        @endif
                                    @endif

                                    @if($meeting->attachments && $meeting->attachments->count() > 0)
                                        <h4 class="mt-4">Meeting Documents</h4>
                                        <div class="attachments-list">
                                            @foreach($meeting->attachments as $attachment)
                                                <div class="attachment-item">
                                                    <div class="attachment-info">
                                                        <div class="attachment-name">{{ $attachment->original_filename }}</div>
                                                        @if($attachment->description)
                                                            <div class="attachment-description">{{ $attachment->description }}</div>
                                                        @endif
                                                        <div class="attachment-meta">
                                                            {{ $attachment->file_type_display }} | {{ $attachment->formatted_size }} | Added {{ $attachment->created_at->format('M j, Y') }}
                                                        </div>
                                                    </div>
                                                    <div class="attachment-actions">
                                                        <a href="{{ route('meeting-attachments.download', $attachment) }}" class="btn btn-sm btn-primary">
                                                            <i class="bi bi-download"></i> Download
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                    <div class="d-flex flex-column flex-md-row justify-content-between mt-4 gap-2">
                                    <a href="{{ route('meetings.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Back to List
                                    </a>
                        <div class="d-flex flex-column flex-md-row gap-2">
                            <a href="{{ route('meetings.export-pdf', $meeting) }}" class="btn btn-success">
                                            <i class="bi bi-file-earmark-pdf"></i> Export to PDF
                                        </a>
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#aiChatModal">
                                            <i class="bi bi-robot"></i> Chat with AI Assistant
                                        </button>
                                        @if(in_array(auth()->user()->role, ['superadmin', 'admin', 'barangay_chairman', 'barangay_secretary']))
                                            <a href="{{ route('meetings.edit', $meeting) }}" class="btn btn-primary">
                                                <i class="bi bi-pencil"></i> Edit Meeting
                                            </a>
                                        @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Chat Modal -->
    <div class="modal fade" id="aiChatModal" tabindex="-1" aria-labelledby="aiChatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 800px; height: 90vh;">
            <div class="modal-content h-100">
                <div class="modal-header" style="background-color: var(--primary-purple); color: white;">
                    <h5 class="modal-title" id="aiChatModalLabel">AI Assistant</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column" style="height: calc(100% - 56px);">
                    <!-- Chat Container -->
                    <div id="chat-container" class="bg-white rounded-lg p-3 flex-grow-1" style="overflow-y: auto;">
                        <div id="messages" class="space-y-3">
                            <!-- Messages will be added here dynamically -->
                        </div>
                    </div>

                    <!-- Input Area -->
                    <div class="mt-3">
                        <form id="chat-form" class="d-flex gap-2">
                            <input 
                                type="text" 
                                id="message-input" 
                                class="form-control"
                                placeholder="Type your message..."
                            >
                            <button 
                                type="submit" 
                                class="btn btn-primary"
                            >
                                <i class="bi bi-send"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        // AI Chat functionality
        const API_KEY = '{{ env('OPENROUTER_API_KEY') }}';
        const API_URL = 'https://openrouter.ai/api/v1/chat/completions';
        const messagesContainer = document.getElementById('messages');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');

        // Store conversation history
        let conversationHistory = [];
        const MAX_HISTORY = 10;

        function scrollToBottom() {
            const chatContainer = document.getElementById('chat-container');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        function showTypingIndicator() {
            const typingDiv = document.createElement('div');
            typingDiv.className = 'typing-indicator';
            typingDiv.innerHTML = '<span></span><span></span><span></span>';
            typingDiv.id = 'typing-indicator';
            messagesContainer.appendChild(typingDiv);
            scrollToBottom();
        }

        function hideTypingIndicator() {
            const typingIndicator = document.getElementById('typing-indicator');
            if (typingIndicator) {
                typingIndicator.remove();
            }
        }

        function addMessage(content, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `d-flex ${isUser ? 'justify-content-end' : 'justify-content-start'}`;
            
            const messageBubble = document.createElement('div');
            messageBubble.className = `message-bubble ${isUser ? 'message-user' : 'message-assistant'}`;
            
            if (isUser) {
                messageBubble.textContent = content;
            } else {
                messageBubble.innerHTML = marked.parse(content);
                messageBubble.classList.add('markdown-content');
            }
            
            messageDiv.appendChild(messageBubble);
            messagesContainer.appendChild(messageDiv);
            scrollToBottom();

            conversationHistory.push({
                role: isUser ? 'user' : 'assistant',
                content: content
            });

            if (conversationHistory.length > MAX_HISTORY * 2) {
                conversationHistory = conversationHistory.slice(-MAX_HISTORY * 2);
            }
        }

        async function sendMessage(message) {
            try {
                showTypingIndicator();
                
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${API_KEY}`,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        model: "deepseek/deepseek-chat:free",
                        messages: conversationHistory
                    })
                });

                if (!response.ok) {
                    throw new Error('API request failed');
                }

                const data = await response.json();
                hideTypingIndicator();

                if (data.choices && Array.isArray(data.choices) && data.choices[0] && data.choices[0].message && data.choices[0].message.content) {
                    const aiResponse = data.choices[0].message.content;
                    addMessage(aiResponse);
                } else {
                    addMessage('Sorry, there was an error processing your request.', false);
                }
            } catch (error) {
                console.error('Error:', error);
                hideTypingIndicator();
                addMessage('Sorry, there was an error processing your request.', false);
            }
        }

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = messageInput.value.trim();
            
            if (message) {
                addMessage(message, true);
                messageInput.value = '';
                await sendMessage(message);
            }
        });

        // Initialize chat when modal is shown
        document.getElementById('aiChatModal').addEventListener('show.bs.modal', function () {
            // Add initial context about the meeting
            const meetingContext = {
                role: 'system',
                content: `You are an AI assistant helping with a meeting that took place on ${new Date('{{ $meeting->date_time }}').toLocaleString()}. 
                         Agenda: {{ $meeting->agenda }}
                         Venue: {{ $meeting->venue }}
                         Organizer: {{ $meeting->organizer }}
                         Attendees: {{ implode(', ', $meeting->attendees) }}
                         {{ $meeting->transcription ? 'Transcription: ' . $meeting->transcription : '' }}
                         Please help answer questions about this meeting.`
            };
            
            // Only initialize if this is the first time
            if (!window.chatInitialized) {
                // Reset conversation history with just the context
                conversationHistory = [meetingContext];
                window.chatInitialized = true;
            } else {
                // Just update the system context without resetting conversation
                conversationHistory[0] = meetingContext;
            }
        });

        // Reset chat initialization when modal is hidden
        document.getElementById('aiChatModal').addEventListener('hidden.bs.modal', function () {
            window.chatInitialized = false;
        });
    </script>
@endpush 