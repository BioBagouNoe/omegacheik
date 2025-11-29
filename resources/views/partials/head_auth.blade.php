 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 <style>
     * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
         font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
     }

     body {
         background-color: #f8fafc;
         min-height: 100vh;
         display: flex;
         justify-content: center;
         align-items: center;
         padding: 20px;
     }

     .auth-container {
         width: 100%;
         max-width: 380px;
     }

     .auth-card {
         background: white;
         border-radius: 12px;
         box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
         padding: 30px;
         margin-bottom: 20px;
     }

     .form-header {
         text-align: center;
         margin-bottom: 25px;
     }

     .logo {
         font-size: 1.8rem;
         color: #3b82f6;
         font-weight: 700;
         margin-bottom: 8px;
     }

     .form-header h2 {
         color: #1e293b;
         font-size: 1.4rem;
         margin-bottom: 5px;
     }

     .form-header p {
         color: #64748b;
         font-size: 0.9rem;
     }

     .form-group {
         margin-bottom: 18px;
     }

     .input-with-icon {
         position: relative;
     }

     .form-control {
         width: 100%;
         padding: 12px 15px;
         border: 1.5px solid #e2e8f0;
         border-radius: 8px;
         font-size: 0.95rem;
         transition: all 0.2s ease;
     }

     .form-control:focus {
         outline: none;
         border-color: #3b82f6;
         box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
     }

     .input-icon {
         position: absolute;
         right: 15px;
         top: 50%;
         transform: translateY(-50%);
         color: #94a3b8;
         font-size: 1rem;
     }

     .password-toggle {
         cursor: pointer;
         transition: color 0.2s ease;
     }

     .password-toggle:hover {
         color: #3b82f6;
     }

     .form-options {
         display: flex;
         justify-content: space-between;
         align-items: center;
         margin-bottom: 20px;
         font-size: 0.85rem;
     }

     .remember-me {
         display: flex;
         align-items: center;
         gap: 6px;
         color: #475569;
     }

     .remember-me input {
         accent-color: #3b82f6;
     }

     .forgot-password {
         color: #3b82f6;
         text-decoration: none;
         font-weight: 500;
         transition: color 0.2s ease;
     }

     .forgot-password:hover {
         color: #1e40af;
     }

     .btn {
         width: 100%;
         padding: 12px;
         border: none;
         border-radius: 8px;
         font-size: 0.95rem;
         font-weight: 600;
         cursor: pointer;
         transition: all 0.2s ease;
         display: flex;
         justify-content: center;
         align-items: center;
         gap: 8px;
     }

     .btn-primary {
         background: #3b82f6;
         color: white;
         margin-bottom: 15px;
     }

     .btn-primary:hover {
         background: #2563eb;
     }

     .social-auth {
         display: flex;
         gap: 10px;
         margin-bottom: 20px;
     }

     .btn-social {
         flex: 1;
         padding: 10px;
         border: 1.5px solid #e2e8f0;
         border-radius: 8px;
         background: white;
         color: #475569;
         cursor: pointer;
         transition: all 0.2s ease;
         display: flex;
         justify-content: center;
         align-items: center;
         font-size: 1.1rem;
     }

     .btn-social:hover {
         border-color: #3b82f6;
         color: #3b82f6;
     }

     .form-footer {
         text-align: center;
         color: #64748b;
         font-size: 0.9rem;
     }

     .toggle-link {
         color: #3b82f6;
         font-weight: 600;
         cursor: pointer;
         transition: color 0.2s ease;
     }

     .toggle-link:hover {
         color: #1e40af;
         text-decoration: underline;
     }

     .terms {
         font-size: 0.75rem;
         color: #94a3b8;
         margin-top: 15px;
         text-align: center;
         line-height: 1.4;
     }

     .terms a {
         color: #3b82f6;
         text-decoration: none;
     }

     .terms a:hover {
         text-decoration: underline;
     }

     .password-strength {
         margin-top: 5px;
         height: 4px;
         border-radius: 2px;
         background: #e2e8f0;
         overflow: hidden;
     }

     .strength-bar {
         height: 100%;
         width: 0%;
         transition: all 0.3s ease;
         border-radius: 2px;
     }

     .strength-weak {
         background: #ef4444;
         width: 33%;
     }

     .strength-medium {
         background: #f59e0b;
         width: 66%;
     }

     .strength-strong {
         background: #10b981;
         width: 100%;
     }

     /* Animation pour le changement de formulaire */
     .auth-card {
         transition: transform 0.3s ease, opacity 0.3s ease;
     }

     .auth-card.hidden {
         display: none;
     }

     @media (max-width: 480px) {
         .auth-card {
             padding: 25px 20px;
         }

         .social-auth {
             flex-direction: column;
             gap: 8px;
         }
     }
 </style>