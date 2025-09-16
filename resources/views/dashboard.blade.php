<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Chat Assistant</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #0c0c0c, #2a3a4b);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .chat-container {
            width: 100%;
            max-width: 500px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            animation: fadeIn 0.5s ease-out;
            display: flex;
            flex-direction: column;
            height: 90vh;
        }
        
        .chat-header {
            background: linear-gradient(to right, #1a1a2e, #16213e);
            color: white;
            padding: 24px;
            text-align: center;
            position: relative;
        }
        
        .chat-header h2 {
            font-weight: 600;
            font-size: 1.8rem;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }
        
        .chat-header p {
            font-weight: 300;
            font-size: 0.9rem;
            opacity: 0.9;
            margin-top: 6px;
        }
        
        .chat-history {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
            background: #f8f9fa;
        }
        
        .message {
            max-width: 80%;
            padding: 12px 16px;
            border-radius: 18px;
            animation: fadeIn 0.3s ease-out;
            position: relative;
        }
        
        .message.question {
            align-self: flex-end;
            background: linear-gradient(to right, #1a1a2e, #16213e);
            color: white;
            border-bottom-right-radius: 5px;
        }
        
        .message.answer {
            align-self: flex-start;
            background: white;
            color: #343a40;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-bottom-left-radius: 5px;
        }
        
        .message-time {
            font-size: 0.7rem;
            opacity: 0.7;
            margin-top: 5px;
            text-align: right;
        }
        
        .chat-input-container {
            padding: 20px;
            background: white;
            border-top: 1px solid #e9ecef;
            display: flex;
            gap: 10px;
        }
        
        .question-input {
            flex: 1;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            border-radius: 16px;
            resize: none;
            font-size: 1rem;
            transition: all 0.3s ease;
            max-height: 150px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }
        
        .question-input:focus {
            outline: none;
            border-color: #1a1a2e;
            box-shadow: 0 0 0 3px rgba(26, 26, 46, 0.2);
        }
        
        .send-button {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(to right, #1a1a2e, #16213e);
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(26, 26, 46, 0.3);
            align-self: flex-end;
        }
        
        .send-button:hover {
            transform: translateY(-2px) rotate(10deg);
            box-shadow: 0 6px 14px rgba(26, 26, 46, 0.4);
        }
        
        .send-button:active {
            transform: translateY(0);
        }
        
        .chat-footer {
            padding: 0 24px 24px;
            text-align: center;
        }
        
        .suggestion-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
            justify-content: center;
        }
        
        .suggestion-chip {
            background: rgba(26, 26, 46, 0.1);
            color: #1a1a2e;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .suggestion-chip:hover {
            background: rgba(26, 26, 46, 0.2);
            transform: translateY(-2px);
        }
        
        .more-questions-btn {
            background: linear-gradient(to right, #1a1a2e, #16213e);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 10px rgba(26, 26, 46, 0.3);
        }
        
        .more-questions-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(26, 26, 46, 0.4);
        }
        
        .credit {
            color: #6c757d;
            font-size: 0.8rem;
            margin-top: 15px;
        }
        
        .typing-indicator {
            display: none;
            padding: 12px 0;
            align-self: flex-start;
        }
        
        .typing-dot {
            width: 10px;
            height: 10px;
            background: #1a1a2e;
            border-radius: 50%;
            display: inline-block;
            margin-right: 4px;
            animation: typingAnimation 1.4s infinite ease-in-out;
        }
        
        .typing-dot:nth-child(1) { animation-delay: 0s; }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }
        
        /* Questions Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .modal-content {
            background: white;
            border-radius: 20px;
            width: 100%;
            max-width: 600px;
            max-height: 80vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        .modal-header {
            background: linear-gradient(to right, #1a1a2e, #16213e);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-header h3 {
            font-weight: 600;
        }
        
        .close-modal {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        .modal-body {
            padding: 20px;
            overflow-y: auto;
        }
        
        .question-category {
            margin-bottom: 25px;
        }
        
        .question-category h4 {
            color: #1a1a2e;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .question-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }
        
        .question-item {
            padding: 12px 15px;
            background: #f8f9fa;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .question-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes typingAnimation {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-10px); }
        }
        
        /* Scrollbar styling */
        .chat-history::-webkit-scrollbar {
            width: 6px;
        }
        
        .chat-history::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .chat-history::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 10px;
        }
        
        .chat-history::-webkit-scrollbar-thumb:hover {
            background: #a5a5a5;
        }
        
        /* Responsive adjustments */
        @media (min-width: 768px) {
            .question-list {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        @media (max-width: 480px) {
            .chat-container {
                border-radius: 16px;
                height: 95vh;
            }
            
            .chat-header {
                padding: 18px;
            }
            
            .chat-history {
                padding: 15px;
            }
            
            .chat-input-container {
                padding: 15px;
            }
            
            .message {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <h2><i class="fas fa-robot"></i> AI Chat Assistant</h2>
            <p>Ask about orders, customers, and aircodes</p>
        </div>
        
        <div class="chat-history" id="chatHistory">
            <div class="message answer">
                <div>Hello! I'm your AI assistant. How can I help you today?</div>
                <div class="message-time">Just now</div>
            </div>
            
            <div class="typing-indicator" id="typingIndicator">
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
            </div>
        </div>
        
        <div class="chat-input-container">
            <textarea class="question-input" id="question" placeholder="Type your question..." rows="1"></textarea>
            <button class="send-button" onclick="askQuestion()">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
        
        <div class="chat-footer">
            <div class="suggestion-chips">
                <div class="suggestion-chip" onclick="insertSuggestion('What is the total order count?')">Total orders</div>
                <div class="suggestion-chip" onclick="insertSuggestion('How many customers are there?')">Total customers</div>
                <div class="suggestion-chip" onclick="insertSuggestion('Are there customers with the same name?')">Same customer names</div>
                <div class="suggestion-chip" onclick="insertSuggestion('How many aircode records?')">Aircode count</div>
            </div>
            
            <button class="more-questions-btn" onclick="openModal()">
                <i class="fas fa-lightbulb"></i> More Questions
            </button>
            
            <div class="credit">AI Assistant v1.0 · Database Query System</div>
        </div>
    </div>

    <!-- Questions Modal -->
    <div class="modal" id="questionsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Suggested Questions</h3>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="question-category">
                    <h4>Order Questions</h4>
                    <div class="question-list">
                        <div class="question-item" onclick="insertSuggestion('What is the total number of orders?')">Total number of orders</div>
                        <div class="question-item" onclick="insertSuggestion('Show me recent orders')">Recent orders</div>
                        <div class="question-item" onclick="insertSuggestion('Which orders are pending?')">Pending orders</div>
                        <div class="question-item" onclick="insertSuggestion('What are the highest value orders?')">Highest value orders</div>
                        <div class="question-item" onclick="insertSuggestion('How many orders were placed this month?')">Orders this month</div>
                        <div class="question-item" onclick="insertSuggestion('Which customer has the most orders?')">Customer with most orders</div>
                    </div>
                </div>
                
                <div class="question-category">
                    <h4>Customer Questions</h4>
                    <div class="question-list">
                        <div class="question-item" onclick="insertSuggestion('How many customers do we have?')">Total customers</div>
                        <div class="question-item" onclick="insertSuggestion('Which customers are most active?')">Most active customers</div>
                        <div class="question-item" onclick="insertSuggestion('Show customers with duplicate names')">Customers with duplicate names</div>
                        <div class="question-item" onclick="insertSuggestion('Which customers joined recently?')">Recently joined customers</div>
                        <div class="question-item" onclick="insertSuggestion('What are our premium customers?')">Premium customers</div>
                        <div class="question-item" onclick="insertSuggestion('Which customers have no orders?')">Customers with no orders</div>
                    </div>
                </div>
                
                <div class="question-category">
                    <h4>Aircode Questions</h4>
                    <div class="question-list">
                        <div class="question-item" onclick="insertSuggestion('How many aircode records are there?')">Total aircode records</div>
                        <div class="question-item" onclick="insertSuggestion('What are the most used aircodes?')">Most used aircodes</div>
                        <div class="question-item" onclick="insertSuggestion('Show available aircodes')">Available aircodes</div>
                        <div class="question-item" onclick="insertSuggestion('Which aircodes are expiring soon?')">Expiring aircodes</div>
                        <div class="question-item" onclick="insertSuggestion('What is the distribution of aircodes?')">Aircode distribution</div>
                        <div class="question-item" onclick="insertSuggestion('Show aircodes by category')">Aircodes by category</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const questionInput = document.getElementById('question');
        const chatHistory = document.getElementById('chatHistory');
        const typingIndicator = document.getElementById('typingIndicator');
        const modal = document.getElementById('questionsModal');
        
        questionInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        questionInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                askQuestion();
            }
        });
        
        function insertSuggestion(suggestion) {
            questionInput.value = suggestion;
            questionInput.focus();
            questionInput.dispatchEvent(new Event('input'));
            closeModal();
        }
        
        function openModal() {
            modal.style.display = 'flex';
        }
        
        function closeModal() {
            modal.style.display = 'none';
        }
        
        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
        
        function askQuestion() {
            const question = questionInput.value.trim();
            
            if (!question) {
                // Show error animation
                questionInput.style.borderColor = '#ff4757';
                setTimeout(() => {
                    questionInput.style.borderColor = '#e9ecef';
                }, 1000);
                return;
            }
            
            // Add question to chat history
            addMessage(question, 'question');
            
            // Clear input and reset height
            questionInput.value = '';
            questionInput.style.height = 'auto';
            
            // Show typing indicator
            typingIndicator.style.display = 'flex';
            
            // Scroll to bottom of chat history
            scrollToBottom();
            
            // Send request to backend
            fetch('{{ route('ask') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ question })
            })
            .then(response => response.json())
            .then(data => {
                typingIndicator.style.display = 'none';
                addMessage(data.answer, 'answer');
                
                scrollToBottom();
            })
            .catch(error => {
                typingIndicator.style.display = 'none';
                addMessage("Error: Could not fetch response. Please try again.", 'answer');
                console.error('Error:', error);
            });
        }
        
        function addMessage(text, type) {
            const messageElement = document.createElement('div');
            messageElement.classList.add('message');
            messageElement.classList.add(type);
            
            const currentTime = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            
            messageElement.innerHTML = `
                <div>${text}</div>
                <div class="message-time">${currentTime}</div>
            `;
            
            chatHistory.insertBefore(messageElement, typingIndicator);
        }
        
        function scrollToBottom() {
            chatHistory.scrollTop = chatHistory.scrollHeight;
        }
    </script>
</body>
</html>