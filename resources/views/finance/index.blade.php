@extends('layouts.app')

@section('header')
    Financial Transactions
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Financial Transactions</h5>
                        <div>
                            <button class="btn btn-light me-2" type="button" id="filterToggle">
                                <i class="bi bi-funnel"></i> <span class="filter-text">Filter Records</span>
                            </button>
                            <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#aiChatModal">
                                <i class="bi bi-robot"></i> Chat with AI Assistant
                            </button>
                            <a href="{{ route('finance.create') }}" class="btn btn-light">Add New Transaction</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filter Section -->
                        <div class="mb-4">
                            <div class="collapse" id="filterCollapse">
                                <div class="card card-body">
                                    <form method="GET" action="{{ route('finance.index') }}" id="filterForm">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label for="transaction_type" class="form-label">Transaction Type</label>
                                                <select class="form-select" id="transaction_type" name="transaction_type">
                                                    <option value="">All Types</option>
                                                    <option value="Income" {{ request('transaction_type') == 'Income' ? 'selected' : '' }}>Income</option>
                                                    <option value="Expense" {{ request('transaction_type') == 'Expense' ? 'selected' : '' }}>Expense</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="category" class="form-label">Category</label>
                                                <select class="form-select" id="category" name="category">
                                                    <option value="">All Categories</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="start_date" class="form-label">Start Date</label>
                                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="end_date" class="form-label">End Date</label>
                                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary" id="clearFilters">Clear Filters</button>
                                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <!-- Summary Cards -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 d-md-none">
                                <h5 class="mb-0">Financial Summary</h5>
                                <button class="btn btn-light btn-sm" type="button" id="statsToggle">
                                    <i class="bi bi-chevron-down"></i> <span class="stats-text">Hide Stats</span>
                                </button>
                            </div>
                            <div class="collapse show" id="statsCollapse">
                                <div class="row">
                            <div class="col-md-4">
                                <div class="card summary-card bg-success text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Income</h5>
                                        <h3 class="card-text">₱{{ number_format($records->where('transaction_type', 'Income')->sum('amount'), 2) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card summary-card bg-danger text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Expenses</h5>
                                        <h3 class="card-text">₱{{ number_format($records->where('transaction_type', 'Expense')->sum('amount'), 2) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card summary-card bg-primary text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Net Balance</h5>
                                        <h3 class="card-text">₱{{ number_format($records->where('transaction_type', 'Income')->sum('amount') - $records->where('transaction_type', 'Expense')->sum('amount'), 2) }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Financial Records Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <a href="{{ route('finance.index', ['sort' => 'date', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}" class="text-dark text-decoration-none">
                                                Date
                                                @if(request('sort') == 'date')
                                                    <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ route('finance.index', ['sort' => 'transaction_type', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}" class="text-dark text-decoration-none">
                                                Type
                                                @if(request('sort') == 'transaction_type')
                                                    <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ route('finance.index', ['sort' => 'amount', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}" class="text-dark text-decoration-none">
                                                Amount
                                                @if(request('sort') == 'amount')
                                                    <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ route('finance.index', ['sort' => 'source_payee', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}" class="text-dark text-decoration-none">
                                                Source/Payee
                                                @if(request('sort') == 'source_payee')
                                                    <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ route('finance.index', ['sort' => 'category', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}" class="text-dark text-decoration-none">
                                                Category
                                                @if(request('sort') == 'category')
                                                    <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($records as $record)
                                        <tr>
                                            <td>{{ $record->date->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge {{ $record->transaction_type == 'Income' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $record->transaction_type }}
                                                </span>
                                            </td>
                                            <td class="{{ $record->transaction_type == 'Income' ? 'income' : 'expense' }}">
                                                ₱{{ number_format($record->amount, 2) }}
                                            </td>
                                            <td>{{ $record->source_payee }}</td>
                                            <td>{{ $record->category }}</td>
                                            <td>{{ $record->description ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('finance.show', $record->id) }}" class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('finance.edit', $record->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('finance.destroy', $record->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No financial records found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $records->links() }}
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

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Add marked.js for markdown parsing -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    
    <style>
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

        /* Add these styles to your existing style section */
        .collapse {
            transition: all 0.3s ease-in-out;
        }

        .collapse:not(.show) {
            display: none;
        }

        .collapse.show {
            display: block;
        }

        .btn {
            transition: all 0.2s ease-in-out;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(1px);
        }

        .filter-text {
            transition: all 0.2s ease-in-out;
        }

        #filterCollapse {
            transition: all 0.3s ease-in-out;
            opacity: 1;
            transform: translateY(0);
        }

        #filterCollapse.collapsing {
            opacity: 0;
            transform: translateY(-10px);
        }

        /* Add to your existing styles */
        .summary-card {
            transition: all 0.3s ease-in-out;
        }

        .summary-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        @media (max-width: 767.98px) {
            .summary-card {
                margin-bottom: 1rem;
            }
        }
    </style>

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
            // Add initial context about the financial records
            const financialContext = {
                role: 'system',
                content: `You are an AI assistant helping with financial records. 
                         Total Income: ₱{{ number_format($records->where('transaction_type', 'Income')->sum('amount'), 2) }}
                         Total Expenses: ₱{{ number_format($records->where('transaction_type', 'Expense')->sum('amount'), 2) }}
                         Net Balance: ₱{{ number_format($records->where('transaction_type', 'Income')->sum('amount') - $records->where('transaction_type', 'Expense')->sum('amount'), 2) }}
                         Number of Transactions: {{ $records->count() }}
                         Categories: {{ implode(', ', $categories->toArray()) }}
                         
                         Recent Transactions:
                         @foreach($records->take(5) as $record)
                         - {{ $record->date->format('M d, Y') }} | {{ $record->transaction_type }} | ₱{{ number_format($record->amount, 2) }} | {{ $record->category }} | {{ $record->description ?? 'No description' }}
                         @endforeach
                         
                         Please help answer questions about these financial records.`
            };
            
            // Only initialize if this is the first time
            if (!window.chatInitialized) {
                // Reset conversation history with just the context
                conversationHistory = [financialContext];
                window.chatInitialized = true;
            } else {
                // Just update the system context without resetting conversation
                conversationHistory[0] = financialContext;
            }
        });

        // Reset chat initialization when modal is hidden
        document.getElementById('aiChatModal').addEventListener('hidden.bs.modal', function () {
            window.chatInitialized = false;
        });

        // Clear filters function
        function clearFilters() {
            // Reset all form inputs
            document.getElementById('filterForm').reset();
            
            // Get the collapse element
            const filterCollapse = document.getElementById('filterCollapse');
            const bsCollapse = new bootstrap.Collapse(filterCollapse, { 
                toggle: false,
                duration: 300
            });

            // Hide the collapse with animation
            bsCollapse.hide();

            // Listen for the hidden event
            filterCollapse.addEventListener('hidden.bs.collapse', function handler() {
                // Remove the event listener to prevent multiple calls
                filterCollapse.removeEventListener('hidden.bs.collapse', handler);
                // Submit the form after animation completes
                document.getElementById('filterForm').submit();
            }, { once: true });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const filterToggle = document.getElementById('filterToggle');
            const filterText = filterToggle.querySelector('.filter-text');
            const filterCollapse = document.getElementById('filterCollapse');
            const clearFiltersBtn = document.getElementById('clearFilters');
            const bsCollapse = new bootstrap.Collapse(filterCollapse, { 
                toggle: false,
                duration: 300
            });

            // Stats toggle functionality
            const statsToggle = document.getElementById('statsToggle');
            const statsText = statsToggle.querySelector('.stats-text');
            const statsCollapse = document.getElementById('statsCollapse');
            const bsStatsCollapse = new bootstrap.Collapse(statsCollapse, {
                toggle: false,
                duration: 300
            });

            // Stats toggle button click handler
            statsToggle.addEventListener('click', function() {
                if (statsCollapse.classList.contains('show')) {
                    bsStatsCollapse.hide();
                    statsText.textContent = 'Show Stats';
                } else {
                    bsStatsCollapse.show();
                    statsText.textContent = 'Hide Stats';
                }
            });

            // Filter toggle button click handler
            filterToggle.addEventListener('click', function() {
                if (filterCollapse.classList.contains('show')) {
                    clearFilters();
                } else {
                    bsCollapse.show();
                    filterText.textContent = 'Hide Filters';
                    filterToggle.classList.remove('btn-light');
                    filterToggle.classList.add('btn-primary');
                }
            });

            // Clear filters button click handler
            clearFiltersBtn.addEventListener('click', clearFilters);

            // Check if filters are applied and update button state accordingly
            const hasFilters = Object.keys(new URLSearchParams(window.location.search)).length > 0;
            if (hasFilters) {
                filterText.textContent = 'Hide Filters';
                filterToggle.classList.remove('btn-light');
                filterToggle.classList.add('btn-primary');
                filterCollapse.classList.add('show');
            }
        });
    </script>
@endsection 