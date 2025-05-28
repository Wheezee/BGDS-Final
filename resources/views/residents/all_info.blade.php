@extends('layouts.app')

@section('title', 'All Resident Information')

@section('header')
    All Resident Information
@endsection

@push('styles')
<style>
    .table-responsive {
        overflow-x: auto;
    }
    
    .table th, .table td {
        white-space: nowrap;
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
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Complete Resident Data</h5>
                <div>
                    <button class="btn btn-light me-2" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="/residents" class="btn btn-light">Back to Residents</a>
                </div>
            </div>
            <div class="card-body">
                <!-- Filter Section -->
                <div class="collapse mb-4" id="filterCollapse">
                    <div class="card card-body bg-light">
                        <form id="filterForm" method="GET" action="{{ route('residents.all-residents-info') }}">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ request('last_name') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ request('first_name') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="sex" class="form-label">Sex</label>
                                    <select class="form-select" id="sex" name="sex">
                                        <option value="">All</option>
                                        <option value="Male" {{ request('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ request('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="civil_status" class="form-label">Civil Status</label>
                                    <select class="form-select" id="civil_status" name="civil_status">
                                        <option value="">All</option>
                                        <option value="Single" {{ request('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                                        <option value="Married" {{ request('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                                        <option value="Widowed" {{ request('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                        <option value="Divorced" {{ request('civil_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="age_min" class="form-label">Age Range</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="age_min" name="age_min" placeholder="Min" value="{{ request('age_min') }}">
                                        <span class="input-group-text">to</span>
                                        <input type="number" class="form-control" id="age_max" name="age_max" placeholder="Max" value="{{ request('age_max') }}">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="household_id" class="form-label">Household ID</label>
                                    <input type="text" class="form-control" id="household_id" name="household_id" value="{{ request('household_id') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="family_group" class="form-label">Family Group</label>
                                    <input type="text" class="form-control" id="family_group" name="family_group" value="{{ request('family_group') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="occupation" class="form-label">Occupation</label>
                                    <input type="text" class="form-control" id="occupation" name="occupation" value="{{ request('occupation') }}">
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Apply Filters
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Resident Data Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Suffix</th>
                                <th>Place of Birth</th>
                                <th>Date of Birth</th>
                                <th>Age</th>
                                <th>Sex</th>
                                <th>Civil Status</th>
                                <th>Citizenship</th>
                                <th>Occupation</th>
                                <th>Labor Status</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>Education</th>
                                <th>Mother's Name</th>
                                <th>Father's Name</th>
                                <th>PhilSys Card #</th>
                                <th>Household ID #</th>
                                <th>Program Participation</th>
                                <th>Family Group</th>
                                <th>Blood Type</th>
                                <th>Height</th>
                                <th>Weight</th>
                                <th>Skin Complexion</th>
                                <th>Voter</th>
                                <th>Resident Voter</th>
                                <th>Year Last Voted</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($residents as $resident)
                            <tr>
                                <td>{{ $resident->last_name }}</td>
                                <td>{{ $resident->first_name }}</td>
                                <td>{{ $resident->middle_name ?? 'N/A' }}</td>
                                <td>{{ $resident->suffix ?? 'N/A' }}</td>
                                <td>{{ $resident->place_of_birth }}</td>
                                <td>{{ $resident->date_of_birth->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($resident->date_of_birth)->age }}</td>
                                <td>{{ $resident->sex }}</td>
                                <td>{{ $resident->civil_status }}</td>
                                <td>{{ $resident->citizenship }}</td>
                                <td>{{ $resident->occupation ?? 'N/A' }}</td>
                                <td>{{ $resident->labor_status ?? 'N/A' }}</td>
                                <td>{{ $resident->contact_number }}</td>
                                <td>{{ $resident->email ?? 'N/A' }}</td>
                                <td>{{ $resident->education ?? 'N/A' }}</td>
                                <td>{{ $resident->mother_name ?? 'N/A' }}</td>
                                <td>{{ $resident->father_name ?? 'N/A' }}</td>
                                <td>{{ $resident->philsys_number ?? 'N/A' }}</td>
                                <td>{{ $resident->household_id ?? 'N/A' }}</td>
                                <td>{{ $resident->program_participation ?? 'N/A' }}</td>
                                <td>{{ $resident->family_group ?? 'N/A' }}</td>
                                <td>{{ $resident->blood_type ?? 'N/A' }}</td>
                                <td>{{ $resident->height ?? 'N/A' }}</td>
                                <td>{{ $resident->weight ?? 'N/A' }}</td>
                                <td>{{ $resident->skin_complexion ?? 'N/A' }}</td>
                                <td>{{ $resident->voter ?? 'N/A' }}</td>
                                <td>{{ $resident->resident_voter ?? 'N/A' }}</td>
                                <td>{{ $resident->year_last_voted ?? 'N/A' }}</td>
                                <td>{{ $resident->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>{{ $resident->updated_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-3">
                    <button class="btn btn-success me-2" type="button" onclick="event.stopPropagation(); exportTableToExcel()">
                        <i class="bi bi-file-earmark-excel"></i> Export to Excel
                    </button>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#aiChatModal">
                        <i class="bi bi-robot"></i> Chat with AI Assistant
                    </button>
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
<!-- SheetJS for Excel export -->
<script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
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
        // Add initial context about all residents
        const residentsContext = {
            role: 'system',
            content: `You are an AI assistant helping with information about residents in the barangay.
                     Here is the current data about residents:
                     
                     Total Residents: {{ $residents->count() }}
                     
                     List of Residents:
                     {{ $residents->map(function($r) {
                         $age = \Carbon\Carbon::parse($r->date_of_birth)->age;
                         return "- {$r->last_name}, {$r->first_name} {$r->middle_name} ({$age} years old, {$r->sex}, {$r->civil_status})";
                     })->join("\n") }}
                     
                     Demographics:
                     - Male: {{ $residents->where('sex', 'Male')->count() }}
                     - Female: {{ $residents->where('sex', 'Female')->count() }}
                     
                     Civil Status:
                     - Single: {{ $residents->where('civil_status', 'Single')->count() }}
                     - Married: {{ $residents->where('civil_status', 'Married')->count() }}
                     - Widowed: {{ $residents->where('civil_status', 'Widowed')->count() }}
                     - Divorced: {{ $residents->where('civil_status', 'Divorced')->count() }}
                     
                     Age Groups:
                     - 0-17: {{ $residents->filter(function($r) { return \Carbon\Carbon::parse($r->date_of_birth)->age <= 17; })->count() }}
                     - 18-59: {{ $residents->filter(function($r) { $age = \Carbon\Carbon::parse($r->date_of_birth)->age; return $age >= 18 && $age <= 59; })->count() }}
                     - 60+: {{ $residents->filter(function($r) { return \Carbon\Carbon::parse($r->date_of_birth)->age >= 60; })->count() }}
                     
                     Education Levels:
                     {{ $residents->pluck('education')->filter()->unique()->map(function($edu) use ($residents) {
                         return "- {$edu}: " . $residents->where('education', $edu)->count();
                     })->join("\n") }}
                     
                     Occupations:
                     {{ $residents->pluck('occupation')->filter()->unique()->map(function($occ) use ($residents) {
                         return "- {$occ}: " . $residents->where('occupation', $occ)->count();
                     })->join("\n") }}
                     
                     Program Participation:
                     {{ $residents->pluck('program_participation')->filter()->unique()->map(function($prog) use ($residents) {
                         return "- {$prog}: " . $residents->where('program_participation', $prog)->count();
                     })->join("\n") }}
                     
                     Please help analyze this data and answer questions about the resident population. You can search for specific residents by name and provide information about them.`
        };
        
        // Only initialize if this is the first time
        if (!window.chatInitialized) {
            // Reset conversation history with just the context
            conversationHistory = [residentsContext];
            window.chatInitialized = true;
        } else {
            // Just update the system context without resetting conversation
            conversationHistory[0] = residentsContext;
        }
    });

    // Reset chat initialization when modal is hidden
    document.getElementById('aiChatModal').addEventListener('hidden.bs.modal', function () {
        window.chatInitialized = false;
    });

    function exportTableToExcel() {
        const table = document.querySelector('.table');
        const wb = XLSX.utils.book_new();
        const ws_data = [];
        const rows = table.querySelectorAll('tr');

        rows.forEach((row, rowIndex) => {
            const rowData = [];
            row.querySelectorAll('th,td').forEach((cell, colIndex) => {
                let text = cell.innerText;
                // Format date columns (6th col: Date of Birth, 29th: Created At, 30th: Updated At)
                if ([5, 28, 29].includes(colIndex) && rowIndex > 0) {
                    if (text && text !== 'N/A') {
                        let date = new Date(text);
                        if (!isNaN(date.getTime())) {
                            if (colIndex === 5) {
                                text = date.toISOString().slice(0, 10);
                            } else {
                                text = date.toISOString().replace('T', ' ').slice(0, 19);
                            }
                        }
                    }
                }
                // Replace N/A with empty string
                if (text === 'N/A') text = '';
                rowData.push(text);
            });
            ws_data.push(rowData);
        });

        const ws = XLSX.utils.aoa_to_sheet(ws_data);
        // Set contact number column (M) to string type for all data rows
        const range = XLSX.utils.decode_range(ws['!ref']);
        for (let R = 1; R <= range.e.r; ++R) { // skip header row
            const cellAddress = XLSX.utils.encode_cell({c:12, r:R});
            if (ws[cellAddress]) {
                ws[cellAddress].t = 's';
            }
        }
        XLSX.utils.book_append_sheet(wb, ws, "Residents");
        XLSX.writeFile(wb, "residents_data.xlsx");
    }
</script>
@endpush 