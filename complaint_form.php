<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Form</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-image: url('your-background-image.jpg'); /* Add your background image here */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 20px;
        }
        
        /* Back Button Styling */
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: green;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .back-btn:hover {
            background-color: #0056b3;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #93c572; /* Pistachio green background */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            position: relative;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-top: 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            color: #333;
        }
        input[type="email"],
        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
        }
        textarea {
            resize: vertical;
            height: 100px;
        }
        .star-rating {
            font-size: 24px;
            color: #ddd;
            cursor: pointer;
        }
        .star-rating .filled {
            color: #ffbf00;
        }
        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .submit-btn:hover {
            background-color: green;
        }
        .success, .error {
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <!-- Back Button outside the container -->
    <button class="back-btn" onclick="window.location.href='seeker_home.html';">Back</button>

    <div class="container">
        <h2>Submit a Complaint</h2>

        <!-- Success and Error messages -->
        <?php if (isset($message)): ?>
            <div class="<?php echo $message_type; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <form action="submit_complaint.php" method="post">
            <div class="form-group">
                <label for="complainer_email">Your Email:</label>
                <input type="email" id="complainer_email" name="complainer_email" required>
            </div>
            
            <div class="form-group">
                <label for="complainer_role">Your Role:</label>
                <select id="complainer_role" name="complainer_role" required>
                    <option value="seeker">Seeker</option>
                    <option value="recruiter">Recruiter</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="complained_against_email">Complaint Against (Email):</label>
                <input type="email" id="complained_against_email" name="complained_against_email" required>
            </div>

            <div class="form-group">
                <label>Rating:</label>
                <div id="star-rating" class="star-rating">
                    <span data-value="1">&#9733;</span>
                    <span data-value="2">&#9733;</span>
                    <span data-value="3">&#9733;</span>
                    <span data-value="4">&#9733;</span>
                    <span data-value="5">&#9733;</span>
                </div>
                <input type="hidden" id="rating" name="rating" required>
            </div>

            <div class="form-group">
                <label for="complaint">Complaint:</label>
                <textarea id="complaint" name="complaint" required></textarea>
            </div>

            <button type="submit" class="submit-btn">Submit Complaint</button>
        </form>
    </div>

    <script>
        // JavaScript for 5-star rating selection
        const stars = document.querySelectorAll('#star-rating span');
        const ratingInput = document.getElementById('rating');
        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                ratingInput.value = value;
                updateStarRating(value);
            });
        });

        function updateStarRating(value) {
            stars.forEach(star => {
                if (star.getAttribute('data-value') <= value) {
                    star.classList.add('filled');
                } else {
                    star.classList.remove('filled');
                }
            });
        }
    </script>
</body>
</html>
