<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arga's Neon Portfolio | Web Developer & Tutor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
            font-family: 'Space Grotesk', sans-serif;
            background: #000;
            overflow-x: hidden;
            cursor: crosshair;
        }

        /* GLSL Canvas Background */
        #canvas-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        /* Content Overlay */
        .portfolio-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            min-height: 100vh;
        }

        /* Neon Geometric Accent Lines */
        .neon-accent::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(34, 211, 238, 0.1) 50%, transparent 70%);
            pointer-events: none;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* ========== HEADER SECTION ========== */
        .header {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: radial-gradient(ellipse at 50% 0%, rgba(0, 200, 255, 0.1), transparent 70%);
            overflow: hidden;
            padding: 2rem;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"><path d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(34,211,238,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
            pointer-events: none;
            opacity: 0.3;
            animation: moveGrid 20s linear infinite;
        }

        @keyframes moveGrid {
            0% { transform: translate(0, 0); }
            100% { transform: translate(60px, 60px); }
        }

        .header-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 800px;
        }

        .header-content h1 {
            font-size: clamp(2.5rem, 8vw, 5rem);
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #00d4ff 0%, #0ea5e9 50%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 20px rgba(34, 211, 238, 0.5);
            letter-spacing: -2px;
            animation: neonFlicker 3s ease-in-out infinite;
        }

        @keyframes neonFlicker {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.95; }
        }

        .header-content .subtitle {
            font-size: clamp(1rem, 3vw, 1.5rem);
            color: #0ea5e9;
            font-weight: 500;
            margin-bottom: 2rem;
            text-shadow: 0 0 10px rgba(14, 165, 233, 0.5);
            font-family: 'Space Mono', monospace;
        }

        .header-content .description {
            font-size: clamp(0.9rem, 2.5vw, 1.1rem);
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 3rem;
            line-height: 1.8;
        }

        /* Neon Buttons */
        .neon-btn {
            display: inline-block;
            padding: 1rem 2.5rem;
            margin: 0.5rem;
            background: transparent;
            border: 2px solid #00d4ff;
            color: #00d4ff;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Space Mono', monospace;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.3), inset 0 0 10px rgba(0, 212, 255, 0);
        }

        .neon-btn:hover {
            background: rgba(0, 212, 255, 0.1);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.8), inset 0 0 20px rgba(0, 212, 255, 0.1);
            text-shadow: 0 0 10px rgba(0, 212, 255, 1);
            transform: scale(1.05);
        }

        .neon-btn.filled {
            background: linear-gradient(135deg, #00d4ff, #0ea5e9);
            color: #000;
            border-color: #0ea5e9;
        }

        /* Scroll Indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 3;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(10px); }
        }

        .scroll-indicator svg {
            width: 30px;
            height: 30px;
            stroke: #00d4ff;
            stroke-width: 2;
            fill: none;
        }

        /* ========== ABOUT SECTION ========== */
        .section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 2rem;
            position: relative;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
        }

        .section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(192, 132, 252, 0.05), transparent);
            pointer-events: none;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
            position: relative;
            z-index: 2;
        }

        .section-header h2 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            background: linear-gradient(135deg, #00d4ff 0%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .section-header h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #00d4ff, transparent);
            animation: slideIn 1s ease-in-out;
        }

        @keyframes slideIn {
            from { width: 0; }
            to { width: 100px; }
        }

        .section-content {
            max-width: 1000px;
            position: relative;
            z-index: 2;
        }

        /* About Grid */
        .about-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .about-card {
            background: rgba(0, 212, 255, 0.05);
            border: 1.5px solid rgba(0, 212, 255, 0.3);
            padding: 2rem;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .about-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 212, 255, 0.2), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .about-card:hover {
            border-color: rgba(0, 212, 255, 0.8);
            background: rgba(0, 212, 255, 0.1);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.3), inset 0 0 20px rgba(0, 212, 255, 0.05);
            transform: translateY(-5px);
        }

        .about-card h3 {
            color: #00d4ff;
            font-size: 1.3rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .about-card p {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.8;
            position: relative;
            z-index: 2;
        }

        /* ========== PROJECTS SECTION ========== */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .project-card {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.05), rgba(192, 132, 252, 0.05));
            border: 1.5px solid rgba(0, 212, 255, 0.2);
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            transition: all 0.4s ease;
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(10px);
        }

        .project-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(0, 212, 255, 0.1) 50%, transparent 70%);
            pointer-events: none;
        }

        .project-card:hover {
            border-color: rgba(0, 212, 255, 0.8);
            box-shadow: 0 0 30px rgba(0, 212, 255, 0.4), 0 20px 40px rgba(0, 212, 255, 0.1);
            transform: translateY(-10px) perspective(1000px) rotateX(5deg);
        }

        .project-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #0ea5e9, #c084fc);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: rgba(255, 255, 255, 0.2);
        }

        .project-image svg {
            width: 80px;
            height: 80px;
            opacity: 0.3;
        }

        .project-info {
            padding: 2rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 1;
        }

        .project-info h3 {
            color: #00d4ff;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .project-info p {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1.5rem;
            flex: 1;
            line-height: 1.6;
        }

        .project-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .tag {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            background: rgba(0, 212, 255, 0.15);
            border: 1px solid rgba(0, 212, 255, 0.4);
            color: #00d4ff;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 4px;
            font-family: 'Space Mono', monospace;
        }

        /* ========== SKILLS SECTION ========== */
        .skills-container {
            max-width: 1200px;
            position: relative;
            z-index: 2;
        }

        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .skill-category {
            background: rgba(0, 212, 255, 0.05);
            border: 1.5px solid rgba(0, 212, 255, 0.2);
            padding: 2rem;
            border-radius: 8px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .skill-category:hover {
            background: rgba(0, 212, 255, 0.1);
            border-color: rgba(0, 212, 255, 0.8);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);
        }

        .skill-category h3 {
            color: #00d4ff;
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .skill-category h3::before {
            content: '';
            width: 12px;
            height: 12px;
            background: #00d4ff;
            border-radius: 2px;
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.8);
        }

        .skill-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .skill-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .skill-item label {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }

        .skill-bar {
            width: 100px;
            height: 6px;
            background: rgba(0, 212, 255, 0.2);
            border-radius: 3px;
            overflow: hidden;
            border: 1px solid rgba(0, 212, 255, 0.4);
        }

        .skill-fill {
            height: 100%;
            background: linear-gradient(90deg, #00d4ff, #0ea5e9);
            border-radius: 3px;
            animation: fillUp 1s ease-in-out forwards;
        }

        @keyframes fillUp {
            from { width: 0; }
            to { width: 100%; }
        }

        /* ========== CONTACT SECTION ========== */
        .contact-container {
            max-width: 600px;
            position: relative;
            z-index: 2;
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            color: #00d4ff;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group textarea {
            background: rgba(0, 212, 255, 0.05);
            border: 1.5px solid rgba(0, 212, 255, 0.2);
            color: rgba(255, 255, 255, 0.9);
            padding: 0.8rem 1rem;
            border-radius: 6px;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: rgba(0, 212, 255, 0.8);
            background: rgba(0, 212, 255, 0.1);
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.3);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-submit {
            background: linear-gradient(135deg, #00d4ff, #0ea5e9);
            color: #000;
            padding: 1rem 2rem;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Space Mono', monospace;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.4);
        }

        .form-submit:hover {
            transform: scale(1.02);
            box-shadow: 0 0 30px rgba(0, 212, 255, 0.8);
        }

        /* Social Links */
        .social-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 3rem;
            position: relative;
            z-index: 2;
        }

        .social-link {
            width: 50px;
            height: 50px;
            border: 2px solid #00d4ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #00d4ff;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.2rem;
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.2);
        }

        .social-link:hover {
            background: rgba(0, 212, 255, 0.2);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.8);
            transform: translateY(-5px) rotate(10deg);
        }

        /* Footer */
        .footer {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            padding: 2rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            position: relative;
            z-index: 2;
            border-top: 1px solid rgba(0, 212, 255, 0.2);
        }

        .footer p {
            margin: 0.5rem 0;
            font-family: 'Space Mono', monospace;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .projects-grid, .skills-grid {
                grid-template-columns: 1fr;
            }

            .header-content h1 {
                font-size: 2rem;
            }

            .social-links {
                gap: 1rem;
            }

            .neon-btn {
                display: block;
                width: 100%;
                margin: 0.5rem 0;
            }
        }
    </style>
</head>

<body>
    <!-- GLSL Shader Background -->
    <div id="canvas-container"></div>

    <!-- Portfolio Content -->
    <div class="portfolio-wrapper">
        <!-- Header Section -->
        <section id="home" class="header neon-accent">
            <div class="header-content">
                <h1>ARGA</h1>
                <p class="subtitle">$ web_developer --mode=creative</p>
                <p class="description">
                    Crafting beautiful, interactive web experiences with cutting-edge technologies.
                    Full-stack developer passionate about creative coding and teaching others.
                </p>
                <div>
                    <button class="neon-btn" onclick="document.getElementById('projects').scrollIntoView()">View Projects</button>
                    <button class="neon-btn filled" onclick="document.getElementById('contact').scrollIntoView()">Get In Touch</button>
                </div>
            </div>
            
            <!-- Scroll Indicator -->
            <div class="scroll-indicator">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5v8m0 4v2" stroke="currentColor" stroke-linecap="round"/>
                    <path d="M6 12l6 6 6-6" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="section">
            <div class="section-content" style="width: 100%;">
                <div class="section-header">
                    <h2>About Me</h2>
                </div>
                
                <div class="about-grid">
                    <div class="about-card">
                        <h3>💻 Full-Stack Developer</h3>
                        <p>
                            Specialized in Laravel, React, and modern web technologies. 
                            Building responsive, performant applications with attention to detail.
                        </p>
                    </div>
                    
                    <div class="about-card">
                        <h3>🎨 Creative Coder</h3>
                        <p>
                            Passionate about WebGL, GLSL shaders, and interactive animations.
                            Love pushing the boundaries of what's possible in the browser.
                        </p>
                    </div>
                    
                    <div class="about-card">
                        <h3>👨‍🏫 Tech Educator</h3>
                        <p>
                            Started a coding tutoring business in Indonesia. 
                            Dedicated to helping others learn and grow in tech.
                        </p>
                    </div>

                    <div class="about-card">
                        <h3>📍 Based in Indonesia</h3>
                        <p>
                            Working on innovative projects while building a community of learners.
                            Open to collaboration and exciting opportunities.
                        </p>
                    </div>

                    <div class="about-card">
                        <h3>🚀 Always Learning</h3>
                        <p>
                            Exploring emerging technologies and sharing knowledge.
                            Believer in continuous improvement and experimentation.
                        </p>
                    </div>

                    <div class="about-card">
                        <h3>✨ Design-First Approach</h3>
                        <p>
                            Creating beautiful interfaces with smooth interactions.
                            Performance and UX are always top priorities.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Projects Section -->
        <section id="projects" class="section">
            <div class="section-content" style="width: 100%;">
                <div class="section-header">
                    <h2>Featured Projects</h2>
                </div>

                <div class="projects-grid">
                    <div class="project-card">
                        <div class="project-image">🎨</div>
                        <div class="project-info">
                            <h3>Neon Portfolio</h3>
                            <p>
                                An interactive portfolio with GLSL shaders and geometric animations.
                                Showcasing modern web technologies and creative coding.
                            </p>
                            <div class="project-tags">
                                <span class="tag">GLSL</span>
                                <span class="tag">Three.js</span>
                                <span class="tag">Blade</span>
                            </div>
                            <button class="neon-btn" style="width: fit-content;">View Live</button>
                        </div>
                    </div>

                    <div class="project-card">
                        <div class="project-image">📚</div>
                        <div class="project-info">
                            <h3>Coding Tutor Platform</h3>
                            <p>
                                A comprehensive platform for programming education and student management.
                                Built with Laravel and modern frontend frameworks.
                            </p>
                            <div class="project-tags">
                                <span class="tag">Laravel</span>
                                <span class="tag">PHP</span>
                                <span class="tag">Education</span>
                            </div>
                            <button class="neon-btn" style="width: fit-content;">View Live</button>
                        </div>
                    </div>

                    <div class="project-card">
                        <div class="project-image">🎯</div>
                        <div class="project-info">
                            <h3>E-Commerce Platform</h3>
                            <p>
                                Full-featured e-commerce solution with product management, 
                                shopping cart, and secure payment integration.
                            </p>
                            <div class="project-tags">
                                <span class="tag">React</span>
                                <span class="tag">Node.js</span>
                                <span class="tag">MongoDB</span>
                            </div>
                            <button class="neon-btn" style="width: fit-content;">View Live</button>
                        </div>
                    </div>

                    <div class="project-card">
                        <div class="project-image">🌐</div>
                        <div class="project-info">
                            <h3>Interactive Dashboard</h3>
                            <p>
                                Real-time data visualization dashboard with smooth animations
                                and responsive design for all devices.
                            </p>
                            <div class="project-tags">
                                <span class="tag">Chart.js</span>
                                <span class="tag">Vue.js</span>
                                <span class="tag">API</span>
                            </div>
                            <button class="neon-btn" style="width: fit-content;">View Live</button>
                        </div>
                    </div>

                    <div class="project-card">
                        <div class="project-image">🔮</div>
                        <div class="project-info">
                            <h3>WebGL Experiments</h3>
                            <p>
                                Collection of interactive WebGL experiments exploring particle systems,
                                fluid simulations, and generative art.
                            </p>
                            <div class="project-tags">
                                <span class="tag">WebGL</span>
                                <span class="tag">GLSL</span>
                                <span class="tag">Creative</span>
                            </div>
                            <button class="neon-btn" style="width: fit-content;">Explore</button>
                        </div>
                    </div>

                    <div class="project-card">
                        <div class="project-image">⚡</div>
                        <div class="project-info">
                            <h3>Performance Toolkit</h3>
                            <p>
                                Utility library for optimizing web performance with lazy loading,
                                code splitting, and caching strategies.
                            </p>
                            <div class="project-tags">
                                <span class="tag">JavaScript</span>
                                <span class="tag">Performance</span>
                                <span class="tag">Open Source</span>
                            </div>
                            <button class="neon-btn" style="width: fit-content;">GitHub</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Skills Section -->
        <section id="skills" class="section">
            <div class="skills-container">
                <div class="section-header">
                    <h2>Skills & Expertise</h2>
                </div>

                <div class="skills-grid">
                    <div class="skill-category">
                        <h3>Frontend</h3>
                        <div class="skill-list">
                            <div class="skill-item">
                                <label>React & Vue</label>
                                <div class="skill-bar"><div class="skill-fill" style="width: 90%;"></div></div>
                            </div>
                            <div class="skill-item">
                                <label>JavaScript/TypeScript</label>
                                <div class="skill-bar"><div class="skill-fill" style="width: 95%;"></div></div>
                            </div>
                            <div class="skill-item">
                                <label>Tailwind CSS</label>
                                <div class="skill-bar"><div class="skill-fill" style="width: 90%;"></div></div>
                            </div>
                            <div class="skill-item">
                                <label>WebGL/Three.js</label>
                                <div class="skill-bar"><div class="skill-fill" style="width: 85%;"></div></div>
                            </div>
                        </div>
                    </div>

                    <div class="skill-category">
                        <h3>Backend</h3>
                        <div class="skill-list">
                            <div class="skill-item">
                                <label>Laravel & PHP</label>
                                <div class="skill-bar"><div class="skill-fill" style="width: 95%;"></div></div>
                            </div>
                            <div class="skill-item">
                                <label>Node.js/Express</label>
                                <div class="skill-bar"><div class="skill-fill" style="width: 88%;"></div></div>
                            </div>
                            <div class="skill-item">
                                <label>Database Design</label>
                                <div class="skill-bar"><div class="skill-fill" style="width: 90%;"></div></div>
                            </div>
                            <div class="skill-item">
                                <label>API Development</label>
                                <div class="skill-bar"><div class="skill-fill" style="width: 92%;"></div></div>
                            </div>
                        </div>
                    </div>

                    <div class="skill-category">
                        <h3>Creative</h3>
                        <div class="skill-list">
                            <div class="skill-item">
                                <label>GLSL Shaders</label>
                                <div class="skill-bar"><div class="skill-fill" style="width: 85%;"></div></div>
                            </div>
                            <div class="skill-item">
                                <label>Animation</label>
                                <div class="skill-bar"><div class="skill-fill" style="width: 88%;"></div></div>
                            </div>
                            <div class="skill-item">
                                <label>UI/UX Design</label>
                                <div class="skill-bar"><div class="skill-fill" style="width: 82%;"></div></div>
                            </div>
                            <div class="skill-item">
                                <label>Creative Coding</label>
                                <div class="skill-bar"><div class="skill-fill" style="width: 90%;"></div></div>
                            </div>
                        </div>
                    </div>

                    <div class="skill-category">
                        <h3>Tools & DevOps</h3>
                        <div class="skill-list">
                            <div class="skill-item">
                                <label>Git & GitHub</label>
                                <div class="skill-bar"><div class="skill-fill" style="width: 95%;"></div></div>
                            </div>
                            <div class="skill-item">
                                <label>Docker & Linux</label>
                                <div class="skill-bar"><div class="skill-fill" style="width: 80%;"></div></div>
                            </div>
                            <div class="skill-item">
                                <label>Vite & Build Tools</label>
                                <div class="skill-bar"><div class="skill-fill" style="width: 90%;"></div></div>
                            </div>
                            <div class="skill-item">
                                <label>Testing & QA</label>
                                <div class="skill-bar"><div class="skill-fill" style="width: 85%;"></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="section">
            <div class="contact-container">
                <div class="section-header" style="width: 100%;">
                    <h2>Get In Touch</h2>
                </div>

                <form class="contact-form">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>

                    <button type="submit" class="form-submit">Send Message</button>
                </form>

                <div class="social-links">
                    <a href="#" class="social-link" title="GitHub">G</a>
                    <a href="#" class="social-link" title="Twitter">𝕏</a>
                    <a href="#" class="social-link" title="LinkedIn">in</a>
                    <a href="#" class="social-link" title="Email">✉</a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <p>© 2024 Arga | Full-Stack Developer & Creative Coder</p>
            <p>Designed & Built with ✨ and GLSL Shaders | Based in Indonesia 🇮🇩</p>
        </footer>
    </div>

    <script>
        // Smooth scroll behavior untuk links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Animasi skill bars saat scroll
        const observerOptions = {
            threshold: 0.5
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.skill-fill').forEach(el => {
            observer.observe(el);
        });

        // Form submission
        document.querySelector('.contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Thank you for your message! I will get back to you soon.');
            this.reset();
        });
    </script>
</body>
</html>