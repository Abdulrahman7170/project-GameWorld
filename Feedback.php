<?php
session_start(); // Start de sessie

include 'inc/functions.php'; // Zorg dat je dit bestand insluit

HTMLhead("Game Shop");
displaynav();
?>

<main>
    <section>
        <div id="ratingDisplay" class="rating-display" style="display:none;">
            <p>Je hebt <span id="starsGiven" class="stars-given"></span> sterren gegeven.</p>
            <p>Bedankt voor je feedback!</p>
        </div>

        <form action="feedback.php" method="POST" id="feedbackForm" class="feedback-form">
            <label for="rating" class="rating-label">Geef je rating:</label><br>
            <div class="rating-stars">
                <input type="radio" name="rating" value="5" id="star5" class="star-input"><label for="star5" class="star-label">&#9733;</label>
                <input type="radio" name="rating" value="4" id="star4" class="star-input"><label for="star4" class="star-label">&#9733;</label>
                <input type="radio" name="rating" value="3" id="star3" class="star-input"><label for="star3" class="star-label">&#9733;</label>
                <input type="radio" name="rating" value="2" id="star2" class="star-input"><label for="star2" class="star-label">&#9733;</label>
                <input type="radio" name="rating" value="1" id="star1" class="star-input"><label for="star1" class="star-label">&#9733;</label>
            </div><br><br>

            <label for="feedback" class="feedback-label">Laat je feedback achter:</label><br>
            <textarea id="feedback" name="feedback" rows="4" cols="50" class="feedback-textarea" required></textarea><br><br>

            <button type="submit" class="submit-btn">Verstuur Feedback</button>
            <button type="reset" class="reset-btn">Reset</button>
        </form>
    </section>
</main>

<script>
    document.getElementById("feedbackForm").onsubmit = function(event) {
        event.preventDefault();

        var selectedStar = document.querySelector('input[name="rating"]:checked');
        var feedbackText = document.getElementById("feedback").value;

        if (selectedStar && feedbackText) {
            // Hide the form with fade out
            document.getElementById("feedbackForm").style.opacity = "0";
            setTimeout(() => {
                document.getElementById("feedbackForm").style.display = "none";
                
                // Show thank you message
                let thankYouMessage = document.createElement("div");
                thankYouMessage.className = "thank-you-container";
                thankYouMessage.innerHTML = `
                    <div class="thank-you-content">
                        <h2>Bedankt voor je feedback!</h2>
                        <p>Je hebt ${selectedStar.value} sterren gegeven</p>
                        <div class="thank-you-stars">
                            ${'★'.repeat(parseInt(selectedStar.value))}
                            ${'☆'.repeat(5 - parseInt(selectedStar.value))}
                        </div>
                        <p class="feedback-message">"${feedbackText}"</p>
                        <button onclick="window.location.href='index.php'" class="return-home-btn">
                            Terug naar Home
                        </button>
                    </div>
                `;
                document.querySelector('section').appendChild(thankYouMessage);
            }, 300);
        } else {
            alert("Vul alstublieft beide velden in.");
        }
    };
</script>
</body>
</html>

<?php
HTMLfoot();
?>
