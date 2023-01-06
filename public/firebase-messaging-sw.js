importScripts('https://www.gstatic.com/firebasejs/7.6.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.6.0/firebase-messaging.js');
  firebase.initializeApp({ 
    apiKey: "AIzaSyBKYmu0Na0CwNE8trfSMjCOlvAMKDj65Ko",
    authDomain: "prototypeproject-eeb91.firebaseapp.com",
    databaseURL: "https://prototypeproject-eeb91.firebaseio.com",
    projectId: "prototypeproject-eeb91",
    storageBucket: "prototypeproject-eeb91.appspot.com",
    messagingSenderId: "208414469125",
    appId: "1:208414469125:web:8357b52d90f71a5d9a006c",
    measurementId: "G-R62XTDLQWV"
});
  const messaging = firebase.messaging();