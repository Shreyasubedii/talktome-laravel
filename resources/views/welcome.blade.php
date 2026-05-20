<!DOCTYPE html>

<html lang="en">


<head>

    <meta charset="UTF-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />


    <link rel="stylesheet" href="{{ asset('css/animations.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />


    <title>TTM</title>


    <style>
    table {
        animation: transitionIn-Y-bottom 0.5s;
    }

    body {
        table {
            animation: transitionIn-Y-bottom 0.5s;
        }

        body {
            background:
                radial-gradient(circle at top left, #eef7fc 0%, transparent 30%),
                radial-gradient(circle at bottom right, #f4fbff 0%, transparent 30%),
                #f8fbfd;

            font-family: "Segoe UI", sans-serif;
            color: #2c3e50;
        }

        /* ================= HERO AREA ================= */

        .heading-text {
            font-size: 58px;
            font-weight: 700;
            line-height: 75px;
            letter-spacing: -1px;
            color: #234;
            margin-top: 20px;
        }

        .sub-text2 {
            color: #6b7c8f;
            font-size: 17px;
            line-height: 32px;
        }

        /* ================= NAV ================= */

        .nav-item {
            transition: 0.3s;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .nav-item:hover {
            color: #4f7fb8;
            transform: translateY(-2px);
        }

        /* ================= GENERAL CARDS ================= */

        .info-card,
        .feature-box,
        .how-it-works {
            background: rgba(255, 255, 255, 0.72);

            backdrop-filter: blur(14px);

            border: 1px solid rgba(255, 255, 255, 0.6);

            box-shadow:
                0 10px 35px rgba(31, 71, 102, 0.08),
                0 2px 10px rgba(31, 71, 102, 0.04);

            transition: all 0.35s ease;
        }

        .info-card {
            padding: 50px;
            border-radius: 32px;
            margin-bottom: 40px;
        }

        .info-card:hover,
        .feature-box:hover {
            transform: translateY(-6px);
            box-shadow:
                0 18px 45px rgba(31, 71, 102, 0.12),
                0 5px 18px rgba(31, 71, 102, 0.08);
        }

        /* ================= SECTION TITLES ================= */

        .info-card h2,
        .how-it-works h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 18px;
            color: #2b4d66;
            position: relative;
        }

        .info-card h2::after,
        .how-it-works h2::after {
            content: '';
            display: block;
            width: 70px;
            height: 4px;
            border-radius: 20px;
            margin-top: 14px;
            background: linear-gradient(to right, #7ca8c6, #c8e4f7);
        }

        /* ================= FEATURE SLIDER ================= */

        .feature-slider-container {
            position: relative;
            width: 100%;
            overflow: hidden;
            margin-bottom: 70px;
        }

        .feature-slider {
            display: flex;
            gap: 25px;
            transition: transform 0.5s ease;
        }

        .feature-box {
            min-width: calc(50% - 12px);
            border-radius: 28px;
            padding: 45px;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }

        .feature-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(to right, #7ca8c6, #d9f1ff);
        }

        .feature-box h3 {
            font-size: 26px;
            margin-bottom: 15px;
            color: #315d7b;
        }

        .feature-box p {
            font-size: 16px;
            line-height: 30px;
            color: #667789;
        }

        /* ================= SLIDER BUTTONS ================= */

        .slider-btn {
            position: absolute;
            top: 45%;
            transform: translateY(-50%);
            width: 58px;
            height: 58px;
            border: none;
            border-radius: 50%;

            background: rgba(255, 255, 255, 0.9);

            backdrop-filter: blur(10px);

            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);

            color: #4f7fb8;

            font-size: 22px;
            cursor: pointer;

            transition: 0.3s ease;

            z-index: 10;
        }

        .slider-btn:hover {
            transform: translateY(-50%) scale(1.08);
            background: #7ca8c6;
            color: white;
        }

        .left-btn {
            left: 15px;
        }

        .right-btn {
            right: 15px;
        }

        /* ================= HOW IT WORKS ================= */

        .how-it-works {
            padding: 60px 40px;
            border-radius: 32px;
            margin-bottom: 50px;
        }

        .steps {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 25px;
            margin-top: 40px;
        }

        .step-box {
            flex: 1;
            min-width: 220px;

            background: rgba(255, 255, 255, 0.65);

            padding: 35px 25px;

            border-radius: 24px;

            transition: 0.3s ease;
        }

        .step-box:hover {
            transform: translateY(-5px);
        }

        .step-box h1 {
            font-size: 70px;
            margin-bottom: 10px;

            background: linear-gradient(to bottom, #7ca8c6, #4f7fb8);

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .step-box p {
            font-size: 18px;
            font-weight: 600;
            color: #4d6274;
        }

        /* ================= FOOTER ================= */

        footer,
        .footer {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
        }

        /* ================= BREATHING MODAL ================= */

        .breathing-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 25, 35, 0.55);

            backdrop-filter: blur(8px);

            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .breathing-modal {
            background: rgba(255, 255, 255, 0.88);

            backdrop-filter: blur(16px);

            border-radius: 32px;

            padding: 40px;

            width: 90%;
            max-width: 430px;

            text-align: center;

            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.2);

            animation: fadeIn 0.5s ease;
        }

        .breathing-modal h2 {
            color: #2d4d63;
            margin-bottom: 10px;
        }

        .close-btn {
            position: absolute;
            top: 18px;
            right: 24px;
            font-size: 26px;
            cursor: pointer;
            color: #7a8b99;
            transition: 0.3s;
        }

        .close-btn:hover {
            color: #222;
            transform: rotate(90deg);
        }

        .breathing-circle {
            width: 160px;
            height: 160px;
            border-radius: 50%;

            background:
                radial-gradient(circle at 30% 30%,
                    #dff6ff,
                    #8ec5e8,
                    #6b9fcf,
                    #4f7fb8);

            margin: 35px auto;

            transition:
                transform 5s ease-in-out,
                box-shadow 2s ease;

            box-shadow:
                0 0 30px rgba(124, 168, 198, 0.55),
                0 0 60px rgba(124, 168, 198, 0.25);
        }

        .breathing-text {
            font-size: 28px;
            font-weight: 700;
            color: #34556d;
        }

        .timer-text {
            margin-top: 12px;
            color: #6f8190;
            line-height: 28px;
        }

        .start-btn {
            margin-top: 25px;

            background: linear-gradient(to right, #7ca8c6, #5e90b8);

            border: none;
            color: white;

            padding: 14px 32px;

            border-radius: 40px;

            font-size: 16px;
            font-weight: 600;

            cursor: pointer;

            transition: 0.3s ease;

            box-shadow:
                0 10px 20px rgba(124, 168, 198, 0.25);
        }

        .start-btn:hover {
            transform: translateY(-2px);
            opacity: 0.95;
        }

        /* ================= ANIMATION ================= */

        @keyframes fadeIn {

            from {
                opacity: 0;
                transform: translateY(20px) scale(0.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ================= MOBILE ================= */

        @media screen and (max-width:768px) {

            .heading-text {
                font-size: 40px;
                line-height: 52px;
            }

            .feature-box {
                min-width: 100%;
                padding: 35px;
            }

            .info-card {
                padding: 35px 25px;
            }

            .step-box {
                min-width: 100%;
            }

            .slider-btn {
                width: 48px;
                height: 48px;
            }
        }
    }

    /* ================= HERO AREA ================= */

    .heading-text {
        font-size: 58px;
        font-weight: 700;
        line-height: 75px;
        letter-spacing: -1px;
        color: #234;
        margin-top: 20px;
    }

    .sub-text2 {
        color: #6b7c8f;
        font-size: 17px;
        line-height: 32px;
    }

    /* ================= NAV ================= */

    .nav-item {
        transition: 0.3s;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .nav-item:hover {
        color: #4f7fb8;
        transform: translateY(-2px);
    }

    /* ================= GENERAL CARDS ================= */

    .info-card,
    .feature-box,
    .how-it-works {
        background: rgba(255, 255, 255, 0.72);

        backdrop-filter: blur(14px);

        border: 1px solid rgba(255, 255, 255, 0.6);

        box-shadow:
            0 10px 35px rgba(31, 71, 102, 0.08),
            0 2px 10px rgba(31, 71, 102, 0.04);

        transition: all 0.35s ease;
    }

    .info-card {
        padding: 50px;
        border-radius: 32px;
        margin-bottom: 40px;
    }

    .info-card:hover,
    .feature-box:hover {
        transform: translateY(-6px);
        box-shadow:
            0 18px 45px rgba(31, 71, 102, 0.12),
            0 5px 18px rgba(31, 71, 102, 0.08);
    }

    /* ================= SECTION TITLES ================= */

    .info-card h2,
    .how-it-works h2 {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 18px;
        color: #2b4d66;
        position: relative;
    }

    .info-card h2::after,
    .how-it-works h2::after {
        content: '';
        display: block;
        width: 70px;
        height: 4px;
        border-radius: 20px;
        margin-top: 14px;
        background: linear-gradient(to right, #7ca8c6, #c8e4f7);
    }

    /* ================= FEATURE SLIDER ================= */

    .feature-slider-container {
        position: relative;
        width: 100%;
        overflow: hidden;
        margin-bottom: 70px;
    }

    .feature-slider {
        display: flex;
        gap: 25px;
        transition: transform 0.5s ease;
    }

    .feature-box {
        min-width: calc(50% - 12px);
        border-radius: 28px;
        padding: 45px;
        box-sizing: border-box;
        position: relative;
        overflow: hidden;
    }

    .feature-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(to right, #7ca8c6, #d9f1ff);
    }

    .feature-box h3 {
        font-size: 26px;
        margin-bottom: 15px;
        color: #315d7b;
    }

    .feature-box p {
        font-size: 16px;
        line-height: 30px;
        color: #667789;
    }

    /* ================= SLIDER BUTTONS ================= */

    .slider-btn {
        position: absolute;
        top: 45%;
        transform: translateY(-50%);
        width: 58px;
        height: 58px;
        border: none;
        border-radius: 50%;

        background: rgba(255, 255, 255, 0.9);

        backdrop-filter: blur(10px);

        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);

        color: #4f7fb8;

        font-size: 22px;
        cursor: pointer;

        transition: 0.3s ease;

        z-index: 10;
    }

    .slider-btn:hover {
        transform: translateY(-50%) scale(1.08);
        background: #7ca8c6;
        color: white;
    }

    .left-btn {
        left: 15px;
    }

    .right-btn {
        right: 15px;
    }

    /* ================= HOW IT WORKS ================= */

    .how-it-works {
        padding: 60px 40px;
        border-radius: 32px;
        margin-bottom: 50px;
    }

    .steps {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 25px;
        margin-top: 40px;
    }

    .step-box {
        flex: 1;
        min-width: 220px;

        background: rgba(255, 255, 255, 0.65);

        padding: 35px 25px;

        border-radius: 24px;

        transition: 0.3s ease;
    }

    .step-box:hover {
        transform: translateY(-5px);
    }

    .step-box h1 {
        font-size: 70px;
        margin-bottom: 10px;

        background: linear-gradient(to bottom, #7ca8c6, #4f7fb8);

        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .step-box p {
        font-size: 18px;
        font-weight: 600;
        color: #4d6274;
    }

    /* ================= FOOTER ================= */

    footer,
    .footer {
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
    }

    /* ================= BREATHING MODAL ================= */

    .breathing-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 25, 35, 0.55);

        backdrop-filter: blur(8px);

        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .breathing-modal {
        background: rgba(255, 255, 255, 0.88);

        backdrop-filter: blur(16px);

        border-radius: 32px;

        padding: 40px;

        width: 90%;
        max-width: 430px;

        text-align: center;

        box-shadow:
            0 25px 60px rgba(0, 0, 0, 0.2);

        animation: fadeIn 0.5s ease;
    }

    .breathing-modal h2 {
        color: #2d4d63;
        margin-bottom: 10px;
    }

    .close-btn {
        position: absolute;
        top: 18px;
        right: 24px;
        font-size: 26px;
        cursor: pointer;
        color: #7a8b99;
        transition: 0.3s;
    }

    .close-btn:hover {
        color: #222;
        transform: rotate(90deg);
    }

    .breathing-circle {
        width: 160px;
        height: 160px;
        border-radius: 50%;

        background:
            radial-gradient(circle at 30% 30%,
                #dff6ff,
                #8ec5e8,
                #6b9fcf,
                #4f7fb8);

        margin: 35px auto;

        transition:
            transform 5s ease-in-out,
            box-shadow 2s ease;

        box-shadow:
            0 0 30px rgba(124, 168, 198, 0.55),
            0 0 60px rgba(124, 168, 198, 0.25);
    }

    .breathing-text {
        font-size: 28px;
        font-weight: 700;
        color: #34556d;
    }

    .timer-text {
        margin-top: 12px;
        color: #6f8190;
        line-height: 28px;
    }

    .start-btn {
        margin-top: 25px;

        background: linear-gradient(to right, #7ca8c6, #5e90b8);

        border: none;
        color: white;

        padding: 14px 32px;

        border-radius: 40px;

        font-size: 16px;
        font-weight: 600;

        cursor: pointer;

        transition: 0.3s ease;

        box-shadow:
            0 10px 20px rgba(124, 168, 198, 0.25);
    }

    .start-btn:hover {
        transform: translateY(-2px);
        opacity: 0.95;
    }

    /* ================= ANIMATION ================= */

    @keyframes fadeIn {

        from {
            opacity: 0;
            transform: translateY(20px) scale(0.96);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* ================= MOBILE ================= */

    @media screen and (max-width:768px) {

        .heading-text {
            font-size: 40px;
            line-height: 52px;
        }

        .feature-box {
            min-width: 100%;
            padding: 35px;
        }

        .info-card {
            padding: 35px 25px;
        }

        .step-box {
            min-width: 100%;
        }

        .slider-btn {
            width: 48px;
            height: 48px;
        }
    }
    </style>

</head>


<body>


    <div class="full-height">


        <center>


            <table border="0">


                <tr>


                    <td width="50%">

                        <img src="{{ asset('img/logo2.png') }}" alt="Talk To Me Logo" style="

                            height: 150px;

                            width: 150px;

                            vertical-align: middle;

                            margin-right: 10px;

                        " />

                    </td>


                    <td width="10%">

                        <a href="{{ url('/login') }}" class="non-style-link">

                            <p class="nav-item">LOGIN</p>

                        </a>

                    </td>


                    <td width="10%">

                        <a href="{{ url('/register') }}" class="non-style-link">

                            <p class="nav-item" style="padding-right: 10px">

                                REGISTER

                            </p>

                        </a>

                    </td>


                </tr>


                <tr>

                    <td colspan="3">

                        <p class="heading-text">

                            Take the first step towards a healthier mind.

                        </p>

                    </td>

                </tr>


                <tr>

                    <td colspan="3">

                        <p class="sub-text2">

                            Start your path to better well-being today, <br />

                            Because you deserve to be heard. Talk with us!<br />

                            Make your appointment now.

                        </p>

                    </td>

                </tr>


                <tr>

                    <td colspan="3"></td>

                </tr>


            </table>


            <!-- ABOUT -->


            <div style="width:90%; margin-top:250px;">


                <div class="info-card">


                    <h2 style="color:#4f7fb8; margin-bottom:20px;">

                        Why Choose Talk To Me?

                    </h2>


                    <!-- <p class="sub-text2" style="line-height:30px;">

                        Talk To Me is a mental wellness and therapy appointment platform

                        designed to support individuals through compassionate care and

                        accessible mental health services.


                        Our platform allows users to connect with professional therapists,

                        book appointments online, manage schedules, and access calming

                        wellness activities in a safe and supportive environment.

                    </p> -->


                </div>


                <!-- FEATURE SLIDER -->


                <div class="feature-slider-container">


                    <button class="slider-btn left-btn" onclick="moveSlide(-1)">

                        &#10094;

                    </button>


                    <div class="feature-slider" id="featureSlider">


                        <div class="feature-box">

                            <h3>Individual Appointments</h3>


                            <p class="sub-text2">

                                Book one-to-one sessions with therapists anytime for personalized care and support.

                            </p>

                        </div>


                        <div class="feature-box">

                            <h3>Group Sessions</h3>


                            <p class="sub-text2">

                                Join group sessions and connect with others in a supportive environment.

                            </p>

                        </div>


                        <!-- <div class="feature-box">

                            <h3>Online Appointments</h3>


                            <p class="sub-text2">

                                Easily book sessions with available therapists anytime.

                            </p>

                        </div> -->


                        <div class="feature-box">

                            <h3>Breathing Exercises</h3>


                            <p class="sub-text2">

                                Relax your mind with guided breathing and calming activities.

                            </p>

                        </div>


                        <div class="feature-box">

                            <h3>Safe & Private</h3>


                            <p class="sub-text2">

                                Your sessions and information remain confidential and secure.

                            </p>

                        </div>


                        <div class="feature-box">

                            <h3>Professional Support</h3>


                            <p class="sub-text2">

                                Connect with experienced mental health professionals.

                            </p>

                        </div>


                        <!-- <div class="feature-box">

                            <h3>Flexible Scheduling</h3>


                            <p class="sub-text2">

                                Choose available dates and times that work best for you.

                            </p>

                        </div> -->


                        <!-- <div class="feature-box">

                            <h3>Wellness Activities</h3>


                            <p class="sub-text2">

                                Explore calming exercises and self-care tools.

                            </p>

                        </div> -->


                    </div>


                    <button class="slider-btn right-btn" onclick="moveSlide(1)">

                        &#10095;

                    </button>


                </div>


                <!-- HOW IT WORKS -->


                <div class="how-it-works">


                    <h2 style="color:#4f7fb8; margin-bottom:25px;">

                        How It Works

                    </h2>


                    <div class="steps">


                        <div class="step-box">

                            <h1>1</h1>

                            <p>Create an account</p>

                        </div>


                        <div class="step-box">

                            <h1>2</h1>

                            <p>Find a therapist</p>

                        </div>


                        <div class="step-box">

                            <h1>3</h1>

                            <p>Start your wellness journey</p>

                        </div>


                    </div>


                </div>


                <!-- MOTIVATIONAL -->


                <div class="info-card">


                    <h2 style="color:#4f7fb8;">

                        You Are Not Alone

                    </h2>


                    <p class="sub-text2" style="line-height:30px;">

                        Healing takes time, and asking for support is a brave step.

                        Talk To Me is here to provide a safe space where your thoughts,

                        emotions, and experiences can be heard with care and understanding.

                    </p>


                </div>


            </div>


            <div style="

            width:100%;

            margin-top:60px;

            padding:25px 0;

            background:#f7fbff;

            text-align:center;

            ">


                <p class="sub-text2" style="margin:0;">

                    &copy; 2026, Talk To Me. All Rights Reserved.

                </p>


            </div>


        </center>


    </div>


    <!-- BREATHING POPUP -->


    <div class="breathing-overlay" id="breathingOverlay">


        <div class="breathing-modal">


            <span class="close-btn" id="closePopup">&times;</span>


            <h2>How are you feeling today?</h2>


            <p>

                Take a quick 1-minute breathing exercise.

            </p>


            <div class="breathing-circle" id="breathingCircle"></div>


            <div class="breathing-text" id="breathingText">

                Ready?

            </div>


            <div class="timer-text" id="timerText">

                1 minute calming session

            </div>


            <button class="start-btn" id="startExercise">

                Start Exercise

            </button>


        </div>


    </div>


    <script>
    const overlay = document.getElementById("breathingOverlay");

    const closeBtn = document.getElementById("closePopup");

    const startBtn = document.getElementById("startExercise");

    const circle = document.getElementById("breathingCircle");

    const breathingText = document.getElementById("breathingText");

    const timerText = document.getElementById("timerText");


    let breathingInterval;

    let sessionTimeout;


    // SHOW POPUP

    setTimeout(() => {

        overlay.style.display = "flex";

    }, 3000);


    // CLOSE POPUP

    closeBtn.addEventListener("click", () => {


        overlay.style.display = "none";


        clearInterval(breathingInterval);

        clearTimeout(sessionTimeout);


        circle.style.transform = "scale(1)";

        breathingText.innerText = "Ready?";

        startBtn.style.display = "inline-block";

    });


    // BREATHING EXERCISE

    startBtn.addEventListener("click", () => {


        startBtn.style.display = "none";


        let inhale = true;


        function breathingCycle() {


            if (inhale) {


                breathingText.innerText = "Breathe In";


                circle.style.transform = "scale(1.4)";


                circle.style.boxShadow =

                    "0 0 35px rgba(124,168,198,0.7), 0 0 60px rgba(124,168,198,0.5)";


            } else {


                breathingText.innerText = "Breathe Out";


                circle.style.transform = "scale(1)";


                circle.style.boxShadow =

                    "0 0 20px rgba(124,168,198,0.5), 0 0 40px rgba(124,168,198,0.3)";

            }


            inhale = !inhale;

        }


        breathingCycle();


        breathingInterval = setInterval(breathingCycle, 5000);


        sessionTimeout = setTimeout(() => {


            clearInterval(breathingInterval);


            breathingText.innerText = "Great Job 🌿";


            timerText.innerText =

                "You completed the exercise. Hope you feel better!";


        }, 60000);


    });


    // FEATURE SLIDER


    let currentSlide = 0;


    function moveSlide(direction) {


        const slider = document.getElementById("featureSlider");


        const cardWidth =

            slider.querySelector(".feature-box").offsetWidth + 20;


        const totalCards =

            slider.querySelectorAll(".feature-box").length;


        const visibleCards =

            window.innerWidth <= 768 ? 1 : 2;


        const maxSlide =

            totalCards - visibleCards;


        currentSlide += direction;


        if (currentSlide < 0) {

            currentSlide = 0;

        }


        if (currentSlide > maxSlide) {

            currentSlide = maxSlide;

        }


        slider.style.transform =

            `translateX(-${currentSlide * cardWidth}px)`;

    }
    </script>


</body>


</html>