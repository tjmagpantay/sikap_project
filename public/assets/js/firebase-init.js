// public/assets/js/firebase-init.js
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.0/firebase-app.js";
import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/9.22.0/firebase-messaging.js";

const cfg = window.FIREBASE_CONFIG;
const vapidKey = window.FIREBASE_VAPID;
const app = initializeApp(cfg);
const messaging = getMessaging(app);

async function registerSW() {
  if ('serviceWorker' in navigator) {
    try {
      await navigator.serviceWorker.register('/firebase-messaging-sw.js');
      console.log('SW registered');
    } catch (e) {
      console.error('SW register failed', e);
    }
  }
}

async function requestAndSendToken() {
  try {
    const permission = await Notification.requestPermission();
    if (permission !== 'granted') {
      console.log('Notification permission denied');
      return;
    }
    const currentToken = await getToken(messaging, { vapidKey });
    if (currentToken) {
      console.log('FCM token', currentToken);
      // send to server
      await fetch('/public/api/save_token.php', {
        method: 'POST',
        credentials: 'include',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ token: currentToken })
      });
    } else {
      console.log('No registration token available.');
    }
  } catch (err) {
    console.error('Error get token', err);
  }
}

onMessage(messaging, (payload) => {
  console.log('Message in foreground: ', payload);
  if (Notification.permission === 'granted') {
    const notif = payload.notification || {};
    new Notification(notif.title || 'New', { body: notif.body || '', icon: notif.icon || '/assets/images/default-avatar.jpg' });
  }
  if (window.appendNotificationToDOM) window.appendNotificationToDOM(payload);
});

window.addEventListener('load', async () => {
  await registerSW();
  await requestAndSendToken();
});
