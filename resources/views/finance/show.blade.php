@extends('layouts.app')

@section('header')
    Transaction Details
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Transaction Details</h5>
                        <div>
                            <a href="{{ route('finance.index') }}" class="btn btn-light me-2">Back to List</a>
                            <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#aiChatModal">
                                <i class="bi bi-robot"></i> Chat with AI Assistant
                            </button>
                            <a href="{{ route('finance.edit', $finance->id) }}" class="btn btn-primary">Edit Record</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-card">
                                    <h6 class="detail-label">Transaction Type</h6>
                                    <p class="detail-value">
                                        <span class="badge {{ $finance->transaction_type == 'Income' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $finance->transaction_type }}
                                        </span>
                                    </p>

                                    <h6 class="detail-label">Amount</h6>
                                    <p class="detail-value">
                                        <span class="amount {{ $finance->transaction_type == 'Income' ? 'income' : 'expense' }}">
                                            ₱{{ number_format($finance->amount, 2) }}
                                        </span>
                                    </p>

                                    <h6 class="detail-label">Date</h6>
                                    <p class="detail-value">{{ $finance->date->format('F d, Y') }}</p>

                                    <h6 class="detail-label">Category</h6>
                                    <p class="detail-value">{{ $finance->category }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-card">
                                    <h6 class="detail-label">{{ $finance->transaction_type == 'Income' ? 'Source' : 'Payee' }}</h6>
                                    <p class="detail-value">{{ $finance->source_payee }}</p>

                                    <h6 class="detail-label">Description</h6>
                                    <p class="detail-value">{{ $finance->description ?? 'N/A' }}</p>

                                    <h6 class="detail-label">Reference Number</h6>
                                    <p class="detail-value">{{ $finance->reference_number ?? 'N/A' }}</p>

                                    <h6 class="detail-label">Created At</h6>
                                    <p class="detail-value">{{ $finance->created_at->format('F d, Y H:i:s') }}</p>

                                    <h6 class="detail-label">Last Updated</h6>
                                    <p class="detail-value">{{ $finance->updated_at->format('F d, Y H:i:s') }}</p>
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
        <div class="modal-dialog modal-lg" style="height: 90vh;">
            <div class="modal-content h-100">
                <div class="modal-header">
                    <h5 class="modal-title" id="aiChatModalLabel">AI Assistant - Financial Analysis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column" style="height: calc(100% - 120px);">
                    <div id="messages" class="flex-grow-1 overflow-auto mb-3" style="height: calc(100% - 60px);">
                        <!-- Messages will be added here -->
                    </div>
                    <div class="input-group">
                        <input type="text" id="messageInput" class="form-control" placeholder="Ask about this financial record...">
                        <button class="btn btn-primary" id="sendButton">
                            <i class="bi bi-send"></i> Send
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Marked.js for markdown parsing -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <!-- MathJax for math rendering -->
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    
    <style>
        .message {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
            max-width: 80%;
        }
        
        .user-message {
            background-color: var(--primary-purple);
            color: white;
            margin-left: auto;
        }
        
        .ai-message {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        
        .typing-indicator {
            display: none;
            padding: 0.75rem;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .typing-indicator span {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #6c757d;
            border-radius: 50%;
            margin-right: 4px;
            animation: typing 1s infinite;
        }
        
        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }
        
        @keyframes typing {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
    </style>
    
    <script>
        // AI Chat functionality
        const API_KEY = '{{ env('OPENROUTER_API_KEY') }}';
        const API_URL = 'https://openrouter.ai/api/v1/chat/completions';
        const messagesContainer = document.getElementById('messages');
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');
        let messageHistory = [];

        // Initialize system context with financial record details
        const systemContext = {
            role: "system",
            content: `You are a financial analysis assistant for the Barangay Government Data System. You have access to the following financial record details:

Transaction Type: ${@json($finance->transaction_type)}
Amount: ₱${@json(number_format($finance->amount, 2))}
Date: ${@json($finance->date->format('F d, Y'))}
Category: ${@json($finance->category)}
${@json($finance->transaction_type == 'Income' ? 'Source' : 'Payee')}: ${@json($finance->source_payee)}
Description: ${@json($finance->description ?? 'N/A')}
Reference Number: ${@json($finance->reference_number ?? 'N/A')}

Please help analyze this financial record and answer any questions about it. You can:
1. Explain the transaction details
2. Provide insights about the amount
3. Compare with typical transactions in this category
4. Suggest financial management tips
5. Calculate related metrics or percentages
6. Explain the significance of the reference number
7. Provide context about the source/payee

Use markdown for formatting and LaTeX for calculations.`
        };

        messageHistory.push(systemContext);

        function addMessage(content, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isUser ? 'user-message' : 'ai-message'}`;
            
            if (isUser) {
                messageDiv.textContent = content;
            } else {
                // Parse markdown and render math
                messageDiv.innerHTML = marked.parse(content);
                MathJax.typesetPromise([messageDiv]);
            }
            
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function showTypingIndicator() {
            const indicator = document.createElement('div');
            indicator.className = 'typing-indicator';
            indicator.innerHTML = '<span></span><span></span><span></span>';
            indicator.id = 'typingIndicator';
            messagesContainer.appendChild(indicator);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function hideTypingIndicator() {
            const indicator = document.getElementById('typingIndicator');
            if (indicator) {
                indicator.remove();
            }
        }

        async function sendMessage() {
            const message = messageInput.value.trim();
            if (!message) return;

            // Add user message to UI
            addMessage(message, true);
            messageInput.value = '';

            // Add user message to history
            messageHistory.push({ role: "user", content: message });

            // Show typing indicator
            showTypingIndicator();

            try {
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${API_KEY}`,
                        'HTTP-Referer': window.location.origin,
                        'X-Title': 'BGDS Financial Analysis'
                    },
                    body: JSON.stringify({
                        model: "deepseek/deepseek-chat:free",
                        messages: messageHistory
                    })
                });

                const data = await response.json();
                const aiResponse = data.choices[0].message.content;

                // Add AI response to history
                messageHistory.push({ role: "assistant", content: aiResponse });

                // Add AI response to UI
                hideTypingIndicator();
                addMessage(aiResponse);
            } catch (error) {
                console.error('Error:', error);
                hideTypingIndicator();
                addMessage('Sorry, I encountered an error. Please try again.');
            }
        }

        sendButton.addEventListener('click', sendMessage);
        messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        // Add welcome message when modal is opened
        document.getElementById('aiChatModal').addEventListener('show.bs.modal', function () {
            messagesContainer.innerHTML = '';
            messageHistory = [systemContext];
            addMessage('Hello! I\'m your financial analysis assistant. I can help you understand and analyze this financial record. What would you like to know?');
        });
    </script>
@endsection 