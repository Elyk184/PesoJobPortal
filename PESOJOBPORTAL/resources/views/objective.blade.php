<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Objective - PESO Manolo Fortich</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('/images/objective.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            min-height: 100vh;
        }
        
        /* Dark overlay */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.85), rgba(220, 38, 38, 0.75));
            z-index: 0;
        }
        
        /* Content wrapper */
        .content-wrapper {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        /* Back Button */
        .back-button {
            position: fixed;
            top: 2rem;
            left: 2rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 0.75rem 1.5rem;
            border-radius: 2rem;
            color: white;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            z-index: 10;
        }
        
        .back-button:hover {
            background: white;
            color: #1e3a8a;
            transform: translateX(-5px);
        }
        
        /* Page Title */
        .page-title {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .page-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .page-title .underline {
            width: 80px;
            height: 4px;
            background: #fcd34d;
            margin: 0.5rem auto 0;
            border-radius: 2px;
        }
        
        /* Objective Cards */
        .objectives-grid {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .objective-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
            border-left: 5px solid #dc2626;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .objective-card:hover {
            transform: translateX(10px);
            background: white;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
        }
        
        /* UPDATED: Navy Blue color for OBJECTIVE badges */
        .card-number {
            display: inline-block;
            background: #1e3a8a;
            color: white;
            font-weight: 700;
            font-size: 0.8rem;
            padding: 0.25rem 0.75rem;
            border-radius: 2rem;
            margin-bottom: 0.75rem;
            letter-spacing: 0.5px;
        }
        
        .objective-card h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 0.75rem;
        }
        
        .objective-divider {
            width: 50px;
            height: 3px;
            background: #dc2626;
            margin-bottom: 1rem;
        }
        
        .objective-card p {
            color: #4b5563;
            line-height: 1.6;
        }
        
        /* Footer */
        .footer {
            margin-top: 3rem;
            text-align: center;
            padding: 1.5rem;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 1rem;
            }
            
            .page-title h2 {
                font-size: 1.8rem;
            }
            
            .objective-card h3 {
                font-size: 1rem;
            }
            
            .back-button {
                top: 1rem;
                left: 1rem;
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Back to Home Button -->
    <a href="/" class="back-button">
        <i class="fas fa-arrow-left"></i>
        <span>Back to Home</span>
    </a>

    <div class="content-wrapper">
        <!-- Page Title -->
        <div class="page-title">
            <h2>Our Objectives</h2>
            <div class="underline"></div>
        </div>

        <!-- Objectives Grid -->
        <div class="objectives-grid">
            <!-- Objective 1 -->
            <div class="objective-card">
                <span class="card-number">OBJECTIVE 1</span>
                <h3>To facilitate employment opportunities for local residents</h3>
                <div class="objective-divider"></div>
                <p>PESO aims to provide employment assistance by connecting job seekers with local and overseas employers, helping reduce unemployment in the municipality.</p>
            </div>

            <!-- Objective 2 -->
            <div class="objective-card">
                <span class="card-number">OBJECTIVE 2</span>
                <h3>To provide timely and accurate labor market information</h3>
                <div class="objective-divider"></div>
                <p>PESO ensures that job seekers and employers have access to updated information on job vacancies, employment trends, and labor demands to support informed decision-making.</p>
            </div>

            <!-- Objective 3 -->
            <div class="objective-card">
                <span class="card-number">OBJECTIVE 3</span>
                <h3>To deliver career guidance and employment coaching services</h3>
                <div class="objective-divider"></div>
                <p>PESO supports students and job seekers through career guidance, counseling, and training programs to help them choose appropriate career paths and prepare for employment.</p>
            </div>

            <!-- Objective 4 -->
            <div class="objective-card">
                <span class="card-number">OBJECTIVE 4</span>
                <h3>To implement skills training and employability programs</h3>
                <div class="objective-divider"></div>
                <p>PESO coordinates with government agencies and private partners to conduct skills training, workshops, and employment programs that enhance the competencies of the workforce.</p>
            </div>

            <!-- Objective 5 -->
            <div class="objective-card">
                <span class="card-number">OBJECTIVE 5</span>
                <h3>To strengthen partnerships with stakeholders for employment generation</h3>
                <div class="objective-divider"></div>
                <p>PESO builds strong collaboration with local government units, private companies, and other agencies to create more job opportunities and improve employment services.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© 2026 Public Employment Service Office - Manolo Fortich. All rights reserved.</p>
        </div>
    </div>
</body>
</html>