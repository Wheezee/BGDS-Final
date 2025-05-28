@extends('layouts.app')

@section('title', 'Project Details')

@section('header', 'Project Details')

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
        }

        .progress {
            height: 25px;
        }

        .project-info {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .project-info h5 {
            color: var(--dark-purple);
            margin-bottom: 15px;
        }

        .project-info p {
            margin-bottom: 10px;
        }

        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 500;
        }

        /* Typing indicator animation */
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

        /* Message styling */
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

        [data-theme="dark"] .card-body,
        [data-theme="dark"] .project-info {
            background-color: #23202b !important;
            color: #fff !important;
            border-color: #3d3d3d !important;
        }
    </style>
@endpush

@section('content')
            <div class="container-fluid mt-4">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Project Overview -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Project Overview</h5>
                            </div>
                            <div class="card-body">
                                <div class="project-info">
                                    <h5>Basic Information</h5>
                                    <p><strong>Project Name:</strong> {{ $project->project_name }}</p>
                                    <p><strong>Project Type:</strong> {{ $project->project_type }} ({{ $project->project_type == 'BDP' ? '20%' : '5%' }})</p>
                                    <p><strong>Assigned Committee:</strong> {{ $project->assigned_committee }}</p>
                                </div>

                                <div class="project-info">
                                    <h5>Timeline</h5>
                                    <p><strong>Start Date:</strong> {{ $project->start_date->format('M d, Y') }}</p>
                                    <p><strong>Target End Date:</strong> {{ $project->target_end_date->format('M d, Y') }}</p>
                                    <p><strong>Status:</strong> 
                                        <span class="status-badge bg-{{ 
                                            $project->status == 'Completed' ? 'success' : 
                                            ($project->status == 'Ongoing' ? 'primary' : 
                                            ($project->status == 'Delayed' ? 'warning' : 'secondary')) 
                                        }}">
                                            {{ $project->status }}
                                        </span>
                                    </p>
                                </div>

                                <div class="project-info">
                                    <h5>Progress</h5>
                                    <div class="progress mb-3">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: {{ $project->progress }}%;" 
                                             aria-valuenow="{{ $project->progress }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                            {{ $project->progress }}%
                                        </div>
                                    </div>
                                </div>

                                @if($project->description)
                                    <div class="project-info">
                                        <h5>Description</h5>
                                        <p>{{ $project->description }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Project Actions -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Project Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary">
                                        <i class="bi bi-pencil"></i> Update Project
                                    </a>
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#aiChatModal">
                                        <i class="bi bi-robot"></i> Chat with AI Assistant
                                    </button>
                                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-grid">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project?')">
                                            <i class="bi bi-trash"></i> Delete Project
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Project Timeline -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">Project Timeline</h5>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <h6>Project Started</h6>
                                            <p>{{ $project->start_date->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <h6>Current Status</h6>
                                            <p>{{ $project->status }}</p>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <h6>Target Completion</h6>
                                            <p>{{ $project->target_end_date->format('M d, Y') }}</p>
                                </div>
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
    <!-- Add marked.js for markdown parsing -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <!-- Add MathJax for math rendering -->
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

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
                // Render math after adding the message
                if (window.MathJax) {
                    MathJax.typesetPromise([messageBubble]).catch(function (err) {
                        console.error('MathJax error:', err);
                    });
                }
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
            // Add initial context about the project
            const projectContext = {
                role: 'system',
                content: `You are an AI assistant helping with information about project {{ $project->name }}.
                         Type: {{ $project->type }}
                         Committee: {{ $project->committee }}
                         Start Date: {{ $project->start_date }}
                         Target End Date: {{ $project->target_end_date }}
                         Status: {{ $project->status }}
                         Progress: {{ $project->progress }}%
                         Description: {{ $project->description }}
                         Please help answer questions about this project.`
            };
            conversationHistory = [projectContext];
        });
    </script>
@endpush 