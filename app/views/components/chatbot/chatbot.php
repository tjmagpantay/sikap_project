<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Sikap Assistant</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sikap-bg: #ffffff;
            --sikap-surface: #f8fafc;
            --sikap-border: #e2e8f0;
            --sikap-text: #334155;
            --sikap-text-light: #64748b;
            --sikap-primary: #092c4c;
            --sikap-primary-dark: #2563eb;
            --sikap-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            --sikap-online: #22c55e;
            --sikap-chat-bg: #f1f5f9; /* New gray background for chat area */
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --sikap-bg: #ffffff;
                --sikap-surface: #f8fafc;
                --sikap-border: #e2e8f0;
                --sikap-text: #334155;
                --sikap-text-light: #64748b;
                --sikap-primary: #092c4c;
                --sikap-primary-dark: #2563eb;
                --sikap-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
                --sikap-online: #22c55e;
                --sikap-chat-bg: #f1f5f9;
            }
        }

        .sikap-chatbot-wrapper {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 999999;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        .sikap-chatbot {
            display: none;
            background: var(--sikap-bg);
            border-radius: 1.25rem;
            box-shadow: var(--sikap-shadow);
            border: 1px solid var(--sikap-border);
            width: 380px;
            height: 600px;
            flex-direction: column;
            overflow: hidden;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .sikap-chatbot.active {
            display: flex;
            opacity: 1;
            transform: translateY(0);
        }

        .sikap-chatbot-header {
            padding: 1.25rem;
            background: var(--sikap-surface);
            color: var(--sikap-text);
            border-bottom: 1px solid var(--sikap-border);
        }

        .sikap-header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sikap-header-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sikap-avatar {
            width: 2.75rem;
            height: 2.75rem;
            background: var(--sikap-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            position: relative;
            transition: transform 0.2s ease;
        }

        .sikap-avatar::after {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 50%;
            border: 2px solid var(--sikap-primary);
            opacity: 0.3;
        }

        .sikap-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--sikap-text-light);
        }

        .sikap-status-dot {
            width: 0.5rem;
            height: 0.5rem;
            background: var(--sikap-online);
            border-radius: 50%;
            position: relative;
        }

        .sikap-status-dot::after {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 50%;
            background: var(--sikap-online);
            opacity: 0.3;
            animation: pulse 2s ease-out infinite;
        }

        .sikap-close-btn {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--sikap-text-light);
            transition: all 0.2s ease;
            border: 1px solid transparent;
            background: transparent;
            cursor: pointer;
        }

        .sikap-close-btn:hover {
            background: var(--sikap-border);
            color: var(--sikap-text);
            border-color: var(--sikap-border);
        }

        .sikap-messages {
            flex: 1;
            padding: 1.25rem;
            overflow-y: auto;
            scroll-behavior: smooth;
            background: var(--sikap-chat-bg); /* Gray background for messages area */
        }

        .sikap-input-area {
            padding: 1.25rem;
            border-top: 1px solid var(--sikap-border);
            background: var(--sikap-surface);
        }

        .sikap-input-group {
            display: flex;
            gap: 0.75rem;
            position: relative;
        }

        .sikap-input {
            flex: 1;
            padding: 0.875rem 1.125rem;
            border: 1px solid var(--sikap-border);
            background: var(--sikap-bg);
            border-radius: 1rem;
            color: var(--sikap-text);
            font-size: 0.9375rem;
            transition: all 0.2s ease;
        }

        .sikap-input:focus {
            outline: none;
            border-color: var(--sikap-primary);
            box-shadow: 0 0 0 3px rgba(9, 44, 76, 0.1);
        }

        .sikap-input::placeholder {
            color: var(--sikap-text-light);
        }

        .sikap-send-btn {
            padding: 0.875rem;
            width: 3rem;
            background: var(--sikap-primary);
            color: white;
            border: none;
            border-radius: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sikap-send-btn:hover {
            background: var(--sikap-primary-dark);
        }

        .sikap-send-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .sikap-toggle-btn {
            width: 3.5rem;
            height: 3.5rem;
            background: var(--sikap-primary);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: var(--sikap-shadow);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .sikap-toggle-btn:hover {
            background: var(--sikap-primary-dark);
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .sikap-toggle-btn.hidden {
            display: none;
            transform: scale(0.8);
            opacity: 0;
        }

        .typing-indicator {
            display: flex;
            gap: 4px;
            padding: 0.75rem 1rem;
            background: var(--sikap-bg); /* White background for typing indicator */
            border: 1px solid var(--sikap-border);
            border-radius: 1rem;
            width: fit-content;
        }

        .typing-indicator span {
            width: 6px;
            height: 6px;
            background: var(--sikap-primary);
            border-radius: 50%;
            animation: bounce 1.5s infinite;
            opacity: 0.7;
        }

        .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
        .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }

        .message-bubble {
            opacity: 0;
            transform: translateY(10px);
            animation: fadeIn 0.3s ease forwards;
            padding: 1rem 1.25rem;
            border-radius: 1.25rem;
            max-width: 85%;
            margin-bottom: 0.75rem;
            position: relative;
            transition: transform 0.2s ease;
            line-height: 1.5;
        }

        .message-bubble.user {
            background: var(--sikap-primary);
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 0.5rem;
        }

        .message-bubble.bot {
            background: var(--sikap-bg); /* White background for bot messages */
            color: var(--sikap-text);
            border: 1px solid var(--sikap-border);
            border-bottom-left-radius: 0.5rem;
        }

        .sikap-faq-button {
            display: block;
            width: 100%;
            padding: 1rem 1.25rem;
            text-align: left;
            background: var(--sikap-bg); /* White background for FAQ buttons */
            border: 1px solid var(--sikap-border);
            border-radius: 1rem;
            margin-bottom: 0.75rem;
            transition: all 0.2s ease;
            color: var(--sikap-text);
            font-size: 0.9375rem;
            cursor: pointer;
        }

        .sikap-faq-button:hover {
            background: var(--sikap-surface);
            border-color: var(--sikap-primary);
            transform: translateY(-1px);
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes pulse {
            0%, 100% { 
                transform: scale(1);
                opacity: 0.3;
            }
            50% { 
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .sikap-messages::-webkit-scrollbar {
            width: 4px;
        }

        .sikap-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        .sikap-messages::-webkit-scrollbar-thumb {
            background: var(--sikap-border);
            border-radius: 2px;
        }

        .sikap-messages::-webkit-scrollbar-thumb:hover {
            background: var(--sikap-text-light);
        }
    </style>
</head>
<body>

<?php
// Remove any output before this point
?>
<div class="sikap-chatbot-wrapper">
    <div id="chatbot" class="sikap-chatbot">
        <!-- Header -->
        <div class="sikap-chatbot-header">
            <div class="sikap-header-content">
                <div class="sikap-header-title">
                    <div class="sikap-avatar">
                        <i class="text-xl fas fa-robot"></i>
                    </div>
                    <div>
                        <h3 style="font-size: 1.125rem; font-weight: bold;">Sikap Assistant</h3>
                        <div class="sikap-status">
                            <span class="sikap-status-dot"></span>
                            <span>Online</span>
                        </div>
                    </div>
                </div>
                <button id="close-chat" class="sikap-close-btn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div id="chat-messages" class="sikap-messages"></div>

        <!-- Input Area -->
        <div class="sikap-input-area">
            <div class="sikap-input-group">
                <input type="text" 
                    id="chat-input"
                    class="sikap-input"
                    placeholder="Type your question...">
                <button id="send-message" class="sikap-send-btn">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Toggle Button -->
    <button id="chatbot-toggle" class="sikap-toggle-btn">
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
            typingIndicator.style.display = 'flex';
            typingIndicator.style.justifyContent = 'flex-start';
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
            messageDiv.style.display = 'flex';
            messageDiv.style.justifyContent = sender === 'user' ? 'flex-end' : 'flex-start';
            
            const bubbleClass = sender === 'user' ? 'user' : 'bot';
            
            messageDiv.innerHTML = `
                <div class="message-bubble ${bubbleClass}">
                    ${text}
                </div>
            `;
            
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }, sender === 'bot' ? 1000 : 0);
    }

    window.showFAQMenu = function() {
        addMessage('bot', `
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <button onclick="showFAQsByType('jobseeker')" 
                    class="sikap-faq-button" style="display: flex; align-items: center; gap: 1rem;">
                    <div style="display: flex; flex-direction: column; align-items: start; gap: 0.25rem;">
                        <span style="font-weight: 500;">Job Seeker Help Center</span>
                        <span style="font-size: 0.875rem; color: var(--sikap-text-light);">
                            <i class="fa-solid fa-briefcase" style="margin-right: 0.375rem;"></i>
                            Application guides and tips
                        </span>
                    </div>
                </button>
                <button onclick="showFAQsByType('employer')" 
                    class="sikap-faq-button" style="display: flex; align-items: center; gap: 1rem;">
                    <div style="display: flex; flex-direction: column; align-items: start; gap: 0.25rem;">
                        <span style="font-weight: 500;">Employer Help Center</span>
                        <span style="font-size: 0.875rem; color: var(--sikap-text-light);">
                            <i class="fa-solid fa-clipboard-list" style="margin-right: 0.375rem;"></i>
                            Posting and management guides
                        </span>
                    </div>
                </button>
            </div>
        `);
    }

    window.showFAQsByType = function(type) {
        const faqs = SIKAP_FAQS[type];
        let faqButtons = faqs.map(faq => `
            <button onclick="showAnswer('${type}', '${faq.q.replace(/'/g, "\\'")}')"
                class="sikap-faq-button">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-question-circle" style="color: var(--sikap-primary);"></i>
                    <span>${faq.q}</span>
                </div>
            </button>
        `).join('');

        addMessage('bot', `
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                    <i class="fas ${type === 'jobseeker' ? 'fa-user-tie' : 'fa-building'}" 
                       style="color: var(--sikap-primary); font-size: 1.25rem;"></i>
                    <p style="font-weight: 600; color: var(--sikap-text);">
                        ${type === 'jobseeker' ? 'Job Seeker Help Center' : 'Employer Help Center'}
                    </p>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                    <i class="fas fa-info-circle" style="color: var(--sikap-primary);"></i>
                    <p style="color: var(--sikap-text-light); font-size: 0.875rem;">
                        ${type === 'jobseeker' ? 'Find answers about your job search journey' : 'Learn about managing job postings and candidates'}
                    </p>
                </div>
                ${faqButtons}
                <button onclick="showFAQMenu()" 
                    class="sikap-faq-button" style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-chevron-left" style="color: var(--sikap-primary);"></i>
                    <span>Return to Help Topics</span>
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
        chatbot.classList.add('active');
        chatbotToggle.classList.add('hidden');
        addMessage('bot', 'Hello! How can I help you today?');
        showFAQMenu();
    });

    closeChat.addEventListener('click', () => {
        chatbot.classList.remove('active');
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