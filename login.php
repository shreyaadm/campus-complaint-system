
<?php
if(isset($_POST['login'])){
header("Location: dashboard.php");
exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>CampusCare - Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
*{margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', Arial, sans-serif;}
body{
min-height:100vh;
display:flex; align-items:center; justify-content:center;
background:linear-gradient(rgba(0,0,0,0.45), rgba(74,0,224,0.55)), url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=1600&q=80');
background-size:cover; background-position:center;
padding:20px;
}
.card{
width:100%; max-width:420px;
background:rgba(255,255,255,0.95);
backdrop-filter:blur(15px);
padding:38px 32px;
border-radius:24px;
box-shadow:0 20px 50px rgba(0,0,0,0.35);
text-align:center;
animation:pop 0.6s ease;
}
@keyframes pop{from{transform:translateY(20px); opacity:0;} to{transform:translateY(0); opacity:1;}}
.logo{
width:70px; height:70px; margin:0 auto 12px;
background:linear-gradient(135deg,#4a00e0,#8e2de2);
border-radius:50%; display:flex; align-items:center; justify-content:center;
font-size:32px; color:white; box-shadow:0 8px 20px rgba(74,0,224,0.4);
}
.card h1{color:#1a1a2e; font-size:28px; letter-spacing:-0.5px;}
.card p{color:#777; font-size:14px; margin:6px 0 22px;}
.label{text-align:left; font-size:13px; font-weight:700; color:#333; margin:14px 0 6px; display:block;}
.input-box{position:relative;}
.input-box span{position:absolute; left:14px; top:50%; transform:translateY(-50%); font-size:18px;}
.input-box input{
width:100%; padding:14px 14px 14px 44px;
border:2px solid #eee; border-radius:14px; outline:none; font-size:15px; background:#f9f9ff; transition:0.2s;
}
.input-box input:focus{border-color:#4a00e0; background:white; box-shadow:0 0 0 4px rgba(74,0,224,0.1);}
.btn{
width:100%; margin-top:22px; padding:15px; border:none; border-radius:14px;
background:linear-gradient(90deg,#4a00e0,#8e2de2); color:white;
font-size:16px; font-weight:700; cursor:pointer; transition:0.2s; box-shadow:0 8px 20px rgba(74,0,224,0.3);
}
.btn:hover{transform:translateY(-2px); box-shadow:0 12px 25px rgba(74,0,224,0.4);}
.divider{display:flex; align-items:center; gap:10px; margin:20px 0; color:#aaa; font-size:12px;}
.divider:before,.divider:after{content:""; flex:1; height:1px; background:#eee;}
.features{display:flex; justify-content:space-between; gap:8px; margin-top:5px;}
.features div{background:#f2f2ff; padding:10px 8px; border-radius:12px; flex:1; font-size:12px; color:#4a00e0; font-weight:600;}
.footer{margin-top:18px; font-size:12px; color:#999;}
</style>
</head>
<body>

<div class="card">
<div class="logo" style="font-size:30px; font-weight:900;">C</div>
<h1>CampusCare</h1>
<p>Welcome back! Please login to continue</p>

<form method="POST">
<span class="label">👤 Username / Email</span>
<div class="input-box"><span>✉️</span><input type="text" name="username" placeholder="Enter your username" required></div>

<span class="label">🔒 Password</span>
<div class="input-box"><span>🔑</span><input type="password" name="password" placeholder="Enter your password" required></div>

<button class="btn" type="submit" name="login">Login ➜</button>
</form>

<div class="divider">WHY CAMPUSCARE?</div>

<div class="features">
<div>⚡ Fast<br>Complaints</div>
<div>✅ Track<br>Status</div>
<div>🔒 Safe &<br>Secure</div>
</div>

<div class="footer">Made with ❤️ for Students</div>
</div>

</body>
</html>