<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Komentar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

 <style>
        .star-filled { color: #facc15; } /* Tailwind yellow-400 */
        .star-empty { color: #d1d5db; } /* Tailwind gray-300 */
        .star-icon { cursor: pointer; transition: color 0.1s; }
        .star-icon:hover { color: #facc15; }
</style>

<body class="bg-gray-50 min-h-screen py-8">


        <!-- Form Komentar -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form id="commentForm" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Rating (1 - 5 Bintang)
                    </label>
                    <div id="ratingStarsContainer" class="flex space-x-1">
                        <!-- Stars will be dynamically injected here -->
                    </div>
                    <!-- Hidden input to store the selected rating value -->
                    <input type="hidden" id="ratingValue" name="ratingValue" value="0" required data-rating="0">
                </div>
                
                <div>
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">
                        Komentar 
                    </label>
                    <textarea 
                        id="comment" 
                        name="comment"
                        rows="4"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Tulis komentar Anda di sini..."
                    ></textarea>
                </div>

                <button 
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium"
                >
                    Kirim Komentar
                </button>
            </form>
        </div>

        <!-- Daftar Komentar -->
        <div id="commentsSection">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Komentar Terbaru</h2>
            
            <div id="commentsList" class="space-y-4">
                <!-- Komentar akan ditampilkan di sini -->
                <div class="text-center text-gray-500 py-8">
                    Belum ada komentar. Jadilah yang pertama berkomentar!
                </div>
            </div>
        </div>

        <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
        import { getAuth, signInAnonymously, signInWithCustomToken, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-auth.js";
        import { getFirestore, doc, addDoc, onSnapshot, collection, query, orderBy, serverTimestamp, setLogLevel } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";

        // Set log level for debugging
        setLogLevel('Debug');

        // 1. Firebase Configuration and Initialization (MANDATORY)
        const appId = typeof __app_id !== 'undefined' ? __app_id : 'default-app-id';
        const firebaseConfig = JSON.parse(typeof __firebase_config !== 'undefined' ? __firebase_config : '{}');

        let db, auth;
        let userId = null;
        let isAuthReady = false;

        if (Object.keys(firebaseConfig).length > 0) {
            const app = initializeApp(firebaseConfig);
            db = getFirestore(app);
            auth = getAuth(app);
            
            // 2. Authentication (MANDATORY)
            onAuthStateChanged(auth, async (user) => {
                if (user) {
                    userId = user.uid;
                } else {
                    try {
                        if (typeof __initial_auth_token !== 'undefined' && __initial_auth_token) {
                            await signInWithCustomToken(auth, __initial_auth_token);
                        } else {
                            await signInAnonymously(auth);
                        }
                        userId = auth.currentUser.uid;
                    } catch (error) {
                        console.error("Authentication failed:", error);
                        // Fallback: use a random ID if Firebase Auth fails entirely
                        userId = crypto.randomUUID(); 
                    }
                }
                isAuthReady = true;
                console.log("User ID:", userId);
                // After auth is ready, start listening for comments
                if (db) {
                    setupRealtimeListener();
                }
            });
        } else {
            console.error("Firebase configuration is missing.");
            isAuthReady = true;
            userId = crypto.randomUUID(); 
        }

        // --- Rating Logic (Stars) ---
            const ratingContainer = document.getElementById('ratingStarsContainer');
            const ratingInput = document.getElementById('ratingValue');
            let currentRating = 0;

            // Function to create an SVG star icon
            const createStarIcon = (index) => {
                const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                svg.setAttribute("viewBox", "0 0 24 24");
                svg.setAttribute("fill", "currentColor");
                svg.setAttribute("stroke-width", "1.5");
                svg.setAttribute("stroke", "currentColor");
                svg.classList.add('w-6', 'h-6', 'star-icon');
                svg.dataset.value = index;

                // Star path (using Heroicons star)
                const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
                path.setAttribute("fill-rule", "evenodd");
                path.setAttribute("d", "M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006Z");
                path.setAttribute("clip-rule", "evenodd");
                svg.appendChild(path);

                // Click Handler
                svg.addEventListener('click', () => {
                    currentRating = index;
                    ratingInput.value = index;
                    updateStars(currentRating);
                });

                // Hover effects (optional, but nice UX)
                svg.addEventListener('mouseenter', () => updateStars(index, true));
                svg.addEventListener('mouseleave', () => updateStars(currentRating));

                return svg;
            };

            // Function to visually update the stars
            const updateStars = (rating, isHover = false) => {
                const stars = ratingContainer.querySelectorAll('.star-icon');
                stars.forEach((star) => {
                    const starValue = parseInt(star.dataset.value);
                    const isActive = isHover ? starValue <= rating : starValue <= currentRating;
                    
                    star.classList.toggle('star-filled', isActive);
                    star.classList.toggle('star-empty', !isActive);
                });
            };

            // Initialize 5 stars
            for (let i = 1; i <= 5; i++) {
                ratingContainer.appendChild(createStarIcon(i));
            }
            updateStars(0); // Initialize as empty

        // --- Firestore Operations ---

        const commentsList = document.getElementById('commentsList');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const noCommentsMessage = document.getElementById('noCommentsMessage');
        const statusMessage = document.getElementById('statusMessage');

        // Helper function to show temporary status messages
        const showStatus = (message, type = 'success') => {
            statusMessage.textContent = message;
            statusMessage.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');
            if (type === 'success') {
                statusMessage.classList.add('bg-green-100', 'text-green-700');
            } else if (type === 'error') {
                statusMessage.classList.add('bg-red-100', 'text-red-700');
            }
            setTimeout(() => {
                statusMessage.classList.add('hidden');
            }, 3000);
        };
        
        // Renders a single comment element
        const renderComment = (doc) => {
            const data = doc.data();
            const time = data.timestamp ? new Date(data.timestamp.toDate()).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' }) : 'Baru saja';
            const initials = data.name ? data.name.charAt(0).toUpperCase() : 'U';

            // Function to generate rating stars display
            const getRatingDisplay = (rating) => {
                let starsHtml = '';
                const fullStars = rating > 0 ? Math.round(rating) : 0;
                
                for (let i = 1; i <= 5; i++) {
                    const isFilled = i <= fullStars;
                    const colorClass = isFilled ? 'text-yellow-400' : 'text-gray-300';
                    starsHtml += `<svg class="w-5 h-5 ${colorClass} inline-block" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006Z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>`;
                }
                return starsHtml;
            };

            const commentElement = document.createElement('div');
            commentElement.classList.add('bg-white', 'p-5', 'rounded-lg', 'shadow-md', 'border-l-4', 'border-gray-300');
            commentElement.innerHTML = `
                <div class="flex items-start space-x-4">
                    <!-- Avatar/Initial -->
                    <div class="flex-shrink-0 size-10 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center text-lg shadow-inner">
                        ${initials}
                    </div>
                    
                    <div class="flex-grow">
                        <!-- Header: Name, Rating, Time -->
                        <div class="flex justify-between items-center mb-1">
                            <div class="font-bold text-gray-900 capitalize">${data.name}</div>
                            <div class="text-xs text-gray-500">${time}</div>
                        </div>

                        <!-- Rating Display -->
                        <div class="mb-2">
                            ${getRatingDisplay(data.rating)}
                            <span class="ml-2 text-sm font-semibold text-gray-700">${data.rating}/5</span>
                        </div>

                        <!-- Comment Body -->
                        <p class="text-gray-700 whitespace-pre-wrap">${data.comment}</p>
                    </div>
                </div>
            `;
            return commentElement;
        };


        // Function to set up real-time listener
        const setupRealtimeListener = () => {
            if (!db || !isAuthReady) return;

            // Using the public data path structure: /artifacts/{appId}/public/data/comments
            const commentsCollectionRef = collection(db, 'artifacts', appId, 'public', 'data', 'comments');

            // Query: order by timestamp descending
            const q = query(commentsCollectionRef, orderBy('timestamp', 'desc'));

            // Real-time listener
            onSnapshot(q, (snapshot) => {
                commentsList.innerHTML = ''; // Clear current list
                loadingIndicator.classList.add('hidden'); // Hide loading

                if (snapshot.empty) {
                    noCommentsMessage.classList.remove('hidden');
                } else {
                    noCommentsMessage.classList.add('hidden');
                    snapshot.forEach(doc => {
                        commentsList.appendChild(renderComment(doc));
                    });
                }
            }, (error) => {
                console.error("Error fetching comments: ", error);
                loadingIndicator.textContent = "Gagal memuat komentar. Silakan coba lagi.";
            });
        };

        // --- Form Submission ---
        document.getElementById('commentForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            if (!db || !userId) {
                showStatus('Error: Sistem tidak terhubung ke database.', 'error');
                return;
            }

            const form = e.target;
            const name = form.name.value.trim();
            const comment = form.comment.value.trim();
            const rating = parseInt(form.ratingValue.value, 10);
            const submitButton = document.getElementById('submitButton');

            if (rating === 0) {
                showStatus('Anda harus memberikan rating (1-5 bintang).', 'error');
                return;
            }
            
            submitButton.disabled = true;
            submitButton.textContent = 'Mengirim...';

            try {
                // Use the public data path structure: /artifacts/{appId}/public/data/comments
                const commentsCollectionRef = collection(db, 'artifacts', appId, 'public', 'data', 'comments');
                
                await addDoc(commentsCollectionRef, {
                    userId: userId,
                    name: name,
                    comment: comment,
                    rating: rating, // Save the new rating field
                    timestamp: serverTimestamp() 
                });

                form.reset(); // Clear form
                currentRating = 0; // Reset rating state
                updateStars(0);
                showStatus('Komentar berhasil dikirim!', 'success');

            } catch (error) {
                console.error("Error adding document: ", error);
                showStatus('Gagal mengirim komentar: ' + error.message, 'error');
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Kirim Komentar';
            }
        });

    </script>
</body>
</html>