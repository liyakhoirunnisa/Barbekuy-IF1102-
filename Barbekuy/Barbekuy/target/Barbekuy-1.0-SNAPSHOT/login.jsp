<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Login - Barbekuy</title>
    <link rel="stylesheet" href="${pageContext.request.contextPath}/css/login.css">
</head>
<body>
<div class="container">
    <!-- Left Section (Form) -->
    <div class="form-container">
        <div class="logo">
            <img src="${pageContext.request.contextPath}/image/logo.png" alt="Barbekuy Logo">
            <h2>Login</h2>
            <p>Login to access your travelwise account</p>
        </div>

        <form action="LoginServlet" method="post" class="login-form">
            <label>Email</label>
            <input type="email" name="email" placeholder="john.doe@gmail.com" required>

            <label>Password</label>
            <div class="password-wrapper">
                <input type="password" name="password" placeholder="********" required>
                <span class="toggle-password">👁️</span>
            </div>

            <div class="options">
                <label><input type="checkbox" name="remember"> Remember me</label>
                <a href="#">Forgot Password</a>
            </div>

            <button type="submit" class="btn-login">Login</button>

            <p class="signup-text">
                Don’t have an account? <a href="register.jsp">Sign up</a>
            </p>
        </form>

        <div class="divider">
            <span>Or login with</span>
        </div>

        <div class="social-login">
  <button class="social-btn"><img src="assets/icons/facebook.png" alt="Facebook"></button>
  <button class="social-btn"><img src="assets/icons/google.png" alt="Google"></button>
  <button class="social-btn"><img src="assets/icons/apple.png" alt="Apple"></button>
</div>

    </div>

    <!-- Right Section (Image) -->
    <div class="image-container">
        <img src="${pageContext.request.contextPath}/image/steak.png" alt="Grill Image">
    </div>
</div>
</body>
</html>
