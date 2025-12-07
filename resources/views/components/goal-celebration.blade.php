<div id="celebrationModal" class="celebration-modal" style="display: none;">
    <div class="celebration-content">
        <button class="celebration-close" onclick="closeCelebration()">&times;</button>
        
        <div class="celebration-icon">🎉</div>
        <h1 class="celebration-title">Goal Completed!</h1>
        
        <div class="celebration-message">
            <p id="celebrationMessage"></p>
        </div>
        
        <div class="celebration-confetti" id="confetti"></div>
        
        <button class="celebration-btn" onclick="closeCelebration()">Awesome!</button>
    </div>
</div>

<style>
.celebration-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.celebration-content {
    background: white;
    padding: 50px 40px;
    border-radius: 20px;
    text-align: center;
    max-width: 500px;
    position: relative;
    animation: scaleIn 0.4s ease-out;
}

@keyframes scaleIn {
    from { transform: scale(0.5); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.celebration-close {
    position: absolute;
    top: 15px;
    right: 15px;
    background: none;
    border: none;
    font-size: 28px;
    cursor: pointer;
    color: #999;
}

.celebration-icon {
    font-size: 80px;
    margin-bottom: 20px;
    animation: bounce 0.6s ease-in-out;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

.celebration-title {
    font-size: 32px;
    color: #A68749;
    margin: 20px 0;
    font-family: 'Tilt Warp', sans-serif;
    font-weight: 200;
}

.celebration-message {
    font-size: 18px;
    color: #666;
    margin: 20px 0 30px;
    line-height: 1.6;
}

.celebration-btn {
    background: #A68749;
    color: white;
    border: none;
    padding: 12px 40px;
    border-radius: 25px;
    font-size: 16px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.celebration-btn:hover {
    background: #8a6f3a;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(166, 135, 73, 0.3);
}

.confetti {
    position: absolute;
    width: 10px;
    height: 10px;
    background: #A68749;
    border-radius: 50%;
    animation: fall 3s ease-out forwards;
}
</style>

<script>
function showCelebration(goalName, amount) {
    document.getElementById('celebrationMessage').textContent = 
        `You've reached your goal of ₱${amount} for "${goalName}"! Keep up the great work!`;
    document.getElementById('celebrationModal').style.display = 'flex';
    createConfetti();
}

function closeCelebration() {
    document.getElementById('celebrationModal').style.display = 'none';
}

function createConfetti() {
    const container = document.getElementById('confetti');
    container.innerHTML = '';
    
    for (let i = 0; i < 50; i++) {
        const confetti = document.createElement('div');
        confetti.className = 'confetti';
        confetti.style.left = Math.random() * 100 + '%';
        confetti.style.delay = Math.random() * 0.5 + 's';
        confetti.style.background = ['#A68749', '#FFD700', '#FF6B6B', '#4ECDC4'][Math.floor(Math.random() * 4)];
        container.appendChild(confetti);
    }
}
</script>