<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Sikap Assistant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'slide-up': 'slideUp 0.3s ease-out',
                        'fade-in': 'fadeIn 0.4s ease-out',
                        'pulse-soft': 'pulseSoft 2s infinite',
                        'bounce-soft': 'bounceSoft 1s infinite',
                    },
                    keyframes: {
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'scale(0.9)' },
                            '100%': { opacity: '1', transform: 'scale(1)' }
                        },
                        pulseSoft: {
                            '0%, 100%': { opacity: '1' },
                            '50%': { opacity: '0.7' }
                        },
                        bounceSoft: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-4px)' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .typing-indicator {
            display: flex;
            gap: 4px;
            padding: 8px 12px;
            background: #f1f1f1;
            border-radius: 20px;
            width: fit-content;
        }

        .typing-indicator span {
            width: 6px;
            height: 6px;
            background: #93c5fd;
            border-radius: 50%;
            animation: bounce 1.5s infinite;
        }

        .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
        .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }

        .message-bubble {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.3s ease forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        #chat-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        #chat-messages::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
    </style>
</head>
<body class="bg-gray-100">


<?php
// Remove any output before this point
?>
<div class="fixed bottom-4 right-4 z-[9999]">
    <div id="chatbot" class="hidden bg-white rounded-2xl shadow-2xl w-[380px] h-[600px] flex flex-col overflow-hidden">
        <!-- Header -->
        <div class="p-4 text-white bg-gradient-to-r from-blue-600 to-blue-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-white/20">
                        <i class="text-xl fas fa-robot"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Sikap Assistant</h3>
                        <div class="flex items-center gap-2 text-sm text-blue-100">
                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                            <span>Online</span>
                        </div>
                    </div>
                </div>
                <button id="close-chat" class="p-2 transition-colors rounded-full hover:bg-white/20">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div id="chat-messages" class="flex-1 p-4 space-y-4 overflow-y-auto scroll-smooth"></div>

        <!-- Input Area -->
        <div class="p-4 border-t bg-white/80 backdrop-blur-sm">
            <div class="flex gap-2">
                <input type="text" 
                    id="chat-input"
                    class="flex-1 px-4 py-3 text-gray-700 bg-gray-100 border-0 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Type your question...">
                <button id="send-message"
                    class="px-4 py-3 text-white transition-colors bg-blue-600 rounded-xl hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Toggle Button -->
    <button id="chatbot-toggle" 
        class="p-4 text-white transition-transform bg-blue-600 rounded-full shadow-lg hover:bg-blue-700 hover:scale-110">
        <i class="text-xl fas fa-comments"></i>
    </button>
</div>

<!-- Chatbot Scripts -->
<script src="/sikap/app/views/components/chatbot/chatbot.js"></script>
<script>
function formatBulletPoints(text) {
    // Split by newline and bullet points
    const parts = text.split('\n');
    let messages = [];
    let currentMessage = '';

    parts.forEach(part => {
        if (part.trim() === '') {
            if (currentMessage) {
                messages.push(currentMessage);
                currentMessage = '';
            }
        } else if (part.startsWith('•')) {
            if (currentMessage) {
                messages.push(currentMessage);
            }
            currentMessage = part;
        } else if (part.startsWith('🔒')) {
            if (currentMessage) {
                messages.push(currentMessage);
            }
            currentMessage = part;
        } else if (currentMessage) {
            currentMessage += ' ' + part;
        } else {
            currentMessage = part;
        }
    });

    if (currentMessage) {
        messages.push(currentMessage);
    }

    return messages.filter(msg => msg.trim() !== '');
}

document.addEventListener('DOMContentLoaded', () => {
    const chatbot = document.getElementById('chatbot');
    const chatbotToggle = document.getElementById('chatbot-toggle');
    const closeChat = document.getElementById('close-chat');
    const chatMessages = document.getElementById('chat-messages');
    const chatInput = document.getElementById('chat-input');
    const sendMessage = document.getElementById('send-message');

    function addMessage(sender, text) {
        // Add typing indicator for bot messages
        let typingIndicator;
        if (sender === 'bot') {
            typingIndicator = document.createElement('div');
            typingIndicator.className = 'flex justify-start';
            typingIndicator.innerHTML = `
                <div class="typing-indicator">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            `;
            chatMessages.appendChild(typingIndicator);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Delay actual message for bot responses
        setTimeout(() => {
            if (typingIndicator) {
                typingIndicator.remove();
            }

            const messageDiv = document.createElement('div');
            messageDiv.className = `flex ${sender === 'user' ? 'justify-end' : 'justify-start'}`;
            
            const bubbleClass = sender === 'user' 
                ? 'bg-blue-600 text-white' 
                : 'bg-gray-100 text-gray-800';
            
            messageDiv.innerHTML = `
                <div class="message-bubble ${bubbleClass} rounded-2xl px-4 py-2 max-w-[80%] shadow-sm">
                    ${text}
                </div>
            `;
            
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }, sender === 'bot' ? 1000 : 0);
    }

    function showFAQMenu() {
        addMessage('bot', `
            <div class="space-y-3">
                <p class="font-medium text-gray-700">Choose a category:</p>
                <button onclick="showFAQsByType('jobseeker')" 
                    class="flex items-center w-full gap-2 p-3 text-left transition-colors bg-gray-50 hover:bg-gray-100 rounded-xl">
                    <span class="flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-100 rounded-full">
                        <i class="fas fa-user-tie"></i>
                    </span>
                    <span>Jobseeker FAQs</span>
                </button>
                <button onclick="showFAQsByType('employer')" 
                    class="flex items-center w-full gap-2 p-3 text-left transition-colors bg-gray-50 hover:bg-gray-100 rounded-xl">
                    <span class="flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-100 rounded-full">
                        <i class="fas fa-building"></i>
                    </span>
                    <span>Employer FAQs</span>
                </button>
            </div>
        `);
    }

    window.showFAQsByType = function(type) {
        const faqs = SIKAP_FAQS[type];
        let faqButtons = faqs.map(faq => `
            <button onclick="showAnswer('${type}', '${faq.q.replace(/'/g, "\\'")}')"
                class="block w-full p-2 mb-2 text-left bg-gray-200 rounded hover:bg-gray-300">
                ${faq.q}
            </button>
        `).join('');

        addMessage('bot', `
            <div class="space-y-2">
                <p class="mb-2 font-medium">${type.charAt(0).toUpperCase() + type.slice(1)} FAQs:</p>
                ${faqButtons}
                <button onclick="showFAQMenu()" 
                    class="block w-full p-2 text-left bg-gray-300 rounded hover:bg-gray-400">
                    ← Back to Categories
                </button>
            </div>
        `);
    };

    window.showAnswer = function(type, question) {
        const faq = SIKAP_FAQS[type].find(f => f.q === question);
        if (faq) {
            addMessage('user', faq.q);
            
            const messages = formatBulletPoints(faq.a);
            messages.forEach((msg, index) => {
                setTimeout(() => {
                    addMessage('bot', msg);
                    
                    // Show FAQ menu after last message
                    if (index === messages.length - 1) {
                        setTimeout(showFAQMenu, 2000);
                    }
                }, (index + 1) * 2000); // 2 second delay between each message
            });
        }
    };

    // Update handleUserInput function as well
    function handleUserInput(message) {
        const normalizedInput = message.toLowerCase();
        let foundAnswer = false;

        for (const type in SIKAP_FAQS) {
            for (const faq of SIKAP_FAQS[type]) {
                if (faq.q.toLowerCase().includes(normalizedInput) || 
                    normalizedInput.includes(faq.q.toLowerCase())) {
                    
                    const messages = formatBulletPoints(faq.a);
                    messages.forEach((msg, index) => {
                        setTimeout(() => {
                            addMessage('bot', msg);
                            if (index === messages.length - 1) {
                                setTimeout(showFAQMenu, 2000);
                            }
                        }, index * 2000); // 2 second delay between each message
                    });
                    
                    foundAnswer = true;
                    break;
                }
            }
            if (foundAnswer) break;
        }

        if (!foundAnswer) {
            addMessage('bot', "I couldn't find a specific answer. Here are some frequently asked questions:");
            setTimeout(showFAQMenu, 1000);
        }
    }

    chatbotToggle.addEventListener('click', () => {
        chatbot.classList.remove('hidden');
        chatbotToggle.classList.add('hidden');
        addMessage('bot', 'Hello! How can I help you today?');
        showFAQMenu();
    });

    closeChat.addEventListener('click', () => {
        chatbot.classList.add('hidden');
        chatbotToggle.classList.remove('hidden');
        chatMessages.innerHTML = '';
    });

    sendMessage.addEventListener('click', () => {
        const message = chatInput.value.trim();
        if (message) {
            addMessage('user', message);
            handleUserInput(message);
            chatInput.value = '';
        }
    });

    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage.click();
        }
    });
});
</script>


</body>
</html>

