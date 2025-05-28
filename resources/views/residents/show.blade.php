@extends('layouts.app')

@section('title', 'Resident Information')

@section('header')
    Resident Information
@endsection
/*resident evilll*/
@push('styles')
<style>
    .form-section {
        margin-bottom: 2rem;
    }

    .form-section-title {
        color: var(--dark-purple);
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--light-purple);
    }

    /* Info section styles */
    .info-section {
        margin-bottom: 2.5rem;
    }

    .info-section-title {
        color: var(--dark-purple);
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--light-purple);
    }

    .info-label {
        font-weight: 600;
        color: var(--dark-purple);
        margin-bottom: 0.5rem;
    }

    .info-value {
        padding: 0.75rem;
        border-radius: 8px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(0,0,0,0.1);
        box-shadow: 0 1px 4px 0 rgba(0,0,0,0.05);
    }

    [data-theme="dark"] .info-value {
        background: rgba(255,255,255,0.05);
        border-color: rgba(255,255,255,0.1);
        color: #fff;
    }

    /* Card header actions */
    .card-header .btn-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .card-header .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .card-header .btn i {
        font-size: 1rem;
    }

    .card-header .btn-info {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        color: #000;
    }

    .card-header .btn-info:hover {
        background-color: #31d2f2;
        border-color: #25cff2;
        color: #000;
    }

    .card-header .btn-light {
        background-color: #f8f9fa;
        border-color: #f8f9fa;
        color: #212529;
    }

    .card-header .btn-light:hover {
        background-color: #e9ecef;
        border-color: #e9ecef;
        color: #212529;
    }

    [data-theme="dark"] .card-header .btn-light {
        background-color: #2d2d2d;
        border-color: #3d3d3d;
        color: #fff;
    }

    [data-theme="dark"] .card-header .btn-light:hover {
        background-color: #3d3d3d;
        border-color: #4d4d4d;
        color: #fff;
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

    /* AI Chat Modal styles */
    #aiChatModal .message-bubble {
        max-width: 80%;
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1rem;
    }

    #aiChatModal .message-user {
        background-color: var(--primary-purple);
        color: white;
        margin-left: auto;
    }

    #aiChatModal .message-assistant {
        background-color: #f8f9fa;
        color: #212529;
    }

    [data-theme="dark"] #aiChatModal .message-assistant {
        background-color: #2a2540;
        color: #fff;
    }

    #aiChatModal .markdown-content {
        line-height: 1.6;
    }

    #aiChatModal .markdown-content p {
        margin-bottom: 1rem;
    }

    #aiChatModal .markdown-content p:last-child {
        margin-bottom: 0;
    }

    #aiChatModal .typing-indicator {
        display: flex;
        gap: 0.5rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 12px;
        margin-bottom: 1rem;
    }

    [data-theme="dark"] #aiChatModal .typing-indicator {
        background: #2a2540;
        border: 1px solid #3d3d3d;
    }

    #aiChatModal .typing-indicator span {
        width: 8px;
        height: 8px;
        background: var(--primary-purple);
        border-radius: 50%;
        animation: typing 1s infinite ease-in-out;
    }

    [data-theme="dark"] #aiChatModal .typing-indicator span {
        background: #b39ddb;
    }

    @keyframes typing {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    [data-theme="dark"] .modal-content, [data-theme="dark"] .modal-content * {
        background-color: #23202b !important;
        color: #fff !important;
        border-color: #3d3d3d !important;
    }

    [data-theme="dark"] #aiChatModal #chat-container,
    [data-theme="dark"] #aiChatModal .typing-indicator {
        background-color: #23202b !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Resident Information</h5>
                    <div class="d-flex flex-column flex-md-row gap-2">
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#aiChatModal">
                            <i class="bi bi-robot"></i> Chat with AI Assistant
                        </button>
                        <a href="{{ route('residents.edit', $resident->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="/residents" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Personal Information Section -->
                    <div class="info-section">
                        <h4 class="info-section-title">Personal Information</h4>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="info-label">Last Name</div>
                                <div class="info-value">{{ $resident->last_name }}</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-label">First Name</div>
                                <div class="info-value">{{ $resident->first_name }}</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-label">Middle Name</div>
                                <div class="info-value">{{ $resident->middle_name ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-label">Suffix/Ext.</div>
                                <div class="info-value">{{ $resident->suffix ?? 'N/A' }}</div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-label">Place of Birth</div>
                                <div class="info-value">{{ $resident->place_of_birth }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">Date of Birth</div>
                                <div class="info-value">{{ $resident->date_of_birth->format('F d, Y') }}</div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="info-label">Age</div>
                                <div class="info-value">{{ $resident->age }}</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-label">Sex</div>
                                <div class="info-value">{{ $resident->sex }}</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-label">Civil Status</div>
                                <div class="info-value">{{ $resident->civil_status }}</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-label">Citizenship</div>
                                <div class="info-value">{{ $resident->citizenship }}</div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-label">Occupation</div>
                                <div class="info-value">{{ $resident->occupation ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">Labor Status</div>
                                <div class="info-value">{{ $resident->labor_status ?? 'N/A' }}</div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-label">Contact Number</div>
                                <div class="info-value">{{ $resident->contact_number }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">Email</div>
                                <div class="info-value">{{ $resident->email ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Family Information Section -->
                    <div class="info-section">
                        <h4 class="info-section-title">Family Information</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-label">Mother's Name</div>
                                <div class="info-value">{{ $resident->mother_name ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">Father's Name</div>
                                <div class="info-value">{{ $resident->father_name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-label">Family Group</div>
                                <div class="info-value">{{ $resident->family_group ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">Household ID</div>
                                <div class="info-value">{{ $resident->household_id ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information Section -->
                    <div class="info-section">
                        <h4 class="info-section-title">Additional Information</h4>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="info-label">Education</div>
                                <div class="info-value">{{ $resident->education ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-label">Blood Type</div>
                                <div class="info-value">{{ $resident->blood_type ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-label">Height</div>
                                <div class="info-value">{{ $resident->height ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="info-label">Weight</div>
                                <div class="info-value">{{ $resident->weight ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-label">Skin Complexion</div>
                                <div class="info-value">{{ $resident->skin_complexion ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">Program Participation</div>
                                <div class="info-value">{{ $resident->program_participation ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Voter Information Section -->
                    <div class="info-section">
                        <h4 class="info-section-title">Voter Information</h4>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="info-label">Voter</div>
                                <div class="info-value">{{ $resident->voter ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label">Resident Voter</div>
                                <div class="info-value">{{ $resident->resident_voter ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="info-label">Year Last Voted</div>
                                <div class="info-value">{{ $resident->year_last_voted ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Identification Numbers Section -->
                    <div class="info-section">
                        <h4 class="info-section-title">Identification Numbers</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-label">PhilSys Card Number</div>
                                <div class="info-value">{{ $resident->philsys_number ?? 'N/A' }}</div>
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
        // Add initial context about the resident
        const residentContext = {
            role: 'system',
            content: `You are an AI assistant helping with information about resident {{ $resident->first_name }} {{ $resident->last_name }}.
                     Here is the complete information about the resident:
                     
                     Personal Information:
                     - Full Name: {{ $resident->first_name }} {{ $resident->middle_name }} {{ $resident->last_name }} {{ $resident->suffix }}
                     - Age: {{ $resident->age }}
                     - Sex: {{ $resident->sex }}
                     - Civil Status: {{ $resident->civil_status }}
                     - Citizenship: {{ $resident->citizenship }}
                     - Place of Birth: {{ $resident->place_of_birth }}
                     - Date of Birth: {{ $resident->date_of_birth->format('F d, Y') }}
                     - Contact: {{ $resident->contact_number }}
                     - Email: {{ $resident->email ?? 'N/A' }}
                     
                     Employment Information:
                     - Labor Status: {{ $resident->labor_status ?? 'N/A' }}
                     
                     Family Information:
                     - Mother's Name: {{ $resident->mother_name ?? 'N/A' }}
                     - Father's Name: {{ $resident->father_name ?? 'N/A' }}
                     - Family Group: {{ $resident->family_group ?? 'N/A' }}
                     - Household ID: {{ $resident->household_id ?? 'N/A' }}
                     
                     Additional Information:
                     - Education: {{ $resident->education ?? 'N/A' }}
                     - Blood Type: {{ $resident->blood_type ?? 'N/A' }}
                     - Height: {{ $resident->height ?? 'N/A' }}
                     - Weight: {{ $resident->weight ?? 'N/A' }}
                     - Skin Complexion: {{ $resident->skin_complexion ?? 'N/A' }}
                     - Program Participation: {{ $resident->program_participation ?? 'N/A' }}
                     
                     Voter Information:
                     - Voter: {{ $resident->voter ?? 'N/A' }}
                     - Resident Voter: {{ $resident->resident_voter ?? 'N/A' }}
                     - Year Last Voted: {{ $resident->year_last_voted ?? 'N/A' }}
                     
                     Identification:
                     - PhilSys Card Number: {{ $resident->philsys_number ?? 'N/A' }}
                     
                     Please help answer questions about this resident. You can provide detailed information about any aspect of their profile.`
        };
        
        // Only initialize if this is the first time
        if (!window.chatInitialized) {
            // Reset conversation history with just the context
            conversationHistory = [residentContext];
            window.chatInitialized = true;
        } else {
            // Just update the system context without resetting conversation
            conversationHistory[0] = residentContext;
        }
    });

    // Reset chat initialization when modal is hidden
    document.getElementById('aiChatModal').addEventListener('hidden.bs.modal', function () {
        window.chatInitialized = false;
    });
</script>
@endpush 