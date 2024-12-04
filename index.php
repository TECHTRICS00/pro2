<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #fafafa;
            background-image: url('illu.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #333;
        }

        header {
            background-color: rgba(255, 51, 51, 0.85);
            padding: 40px;
            text-align: center;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            animation: headerSlideIn 1s ease-out;
        }

        header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            animation: textFadeIn 1.5s ease-in;
        }

        header p {
            font-size: 1.2em;
            animation: textFadeIn 2s ease-in;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 0 15px;
        }

        main {
            display: flex;
            justify-content: space-around;
            padding: 50px;
            flex-wrap: wrap;
            gap: 20px;
            animation: fadeInUp 1.5s ease-in-out;
        }

        .section {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUpDivs 1.5s forwards;
        }

        .section:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .clickable {
            cursor: pointer;
            font-size: 1.8em;
            color: #ff3333;
            transition: color 0.3s;
        }

        .clickable:hover {
            color: #cc0000;
        }

        .sub-menu {
            margin-top: 20px;
            display: none;
            flex-direction: column;
            align-items: center;
        }

        .sub-menu a {
            text-decoration: none;
            background-color: #ff3333;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            margin: 10px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .sub-menu a:hover {
            background-color: #cc0000;
            transform: scale(1.05);
        }

        .show {
            display: flex;
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Keyframe Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes headerSlideIn {
            from {
                transform: translateY(-100%);
            }
            to {
                transform: translateY(0);
            }
        }

        @keyframes textFadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUpDivs {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .info-section {
            text-align: center;
            margin: 50px 0;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .info-section h2 {
            color: #ff3333;
            font-size: 2em;
            margin-bottom: 20px;
        }

        .info-section p {
            font-size: 1.2em;
            line-height: 1.5;
            color: #333;
        }

        footer {
            background-color: rgba(255, 51, 51, 0.85);
            color: white;
            text-align: center;
            padding: 30px 0;
            margin-top: 50px;
        }

        footer .social-icons a {
            text-decoration: none;
            color: white;
            margin: 0 15px;
            font-size: 1.5em;
            transition: transform 0.3s;
        }

        footer .social-icons a:hover {
            transform: scale(1.2);
        }

        footer p {
            margin-top: 10px;
            font-size: 0.9em;
        }

        /* Media Queries for Responsive Design */
        @media (max-width: 768px) {
            main {
                flex-direction: column;
                padding: 20px;
            }

            .section {
                width: 100%;
                max-width: 100%;
                margin-bottom: 20px;
            }

            header h1 {
                font-size: 2em;
            }

            header p {
                font-size: 1.1em;
            }

            .info-section h2 {
                font-size: 1.8em;
            }

            .info-section p {
                font-size: 1.1em;
            }
        }

        @media (max-width: 480px) {
            header {
                padding: 20px;
            }

            header h1 {
                font-size: 1.8em;
            }

            header p {
                font-size: 1em;
            }

            main {
                padding: 10px;
            }

            .section {
                padding: 20px;
            }

            .info-section h2 {
                font-size: 1.5em;
            }

            .info-section p {
                font-size: 1em;
            }

            footer {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Donate Blood, Save Life!</h1>
            <p>Donate Blood And Inspire Others.</p>
        </div>
    </header>
    
    <main>
        <div class="section" id="hospital-section">
            <h2 class="clickable" onclick="toggleSubMenu('hospital')">Hospital</h2>
            <div class="sub-menu" id="hospital-sub-menu">
                <a href="login.php" class="button">Login</a>
                <a href="Registration.php" class="button">Register</a>
            </div>
        </div>
    </main>

    <!-- New Section for Blood Donation Info -->
    <section class="info-section">
        <h2>Why Donate Blood?</h2>
        <p>
            Donating blood is a simple act that can save lives. Every two seconds, someone in the world needs blood.
            By donating blood, you contribute to saving lives of accident victims, patients undergoing surgery, 
            and people suffering from serious illnesses. Your blood donation can be the difference between life and death.
        </p>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2024 Blood Donation System. All Rights Reserved.</p>
            <div class="social-icons">
                <a href="https://facebook.com" target="_blank">Facebook</a>
                <a href="https://twitter.com" target="_blank">Twitter</a>
                <a href="https://instagram.com" target="_blank">Instagram</a>
            </div>
            <p>Follow us for updates and information on upcoming donation events.</p>
        </div>
    </footer>

    <script>
        function toggleSubMenu(section) {
            let subMenu = document.getElementById(section + '-sub-menu');
            if (subMenu.classList.contains('show')) {
                subMenu.classList.remove('show');
            } else {
                subMenu.classList.add('show');
            }
        }
    </script>
</body>
</html>
