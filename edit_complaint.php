<?php include "db.php";
$id = $_GET['id'];
$row = $conn->query("SELECT * FROM complaints WHERE id='$id'")->fetch_assoc();
if(isset($_POST['update'])){
  $name = $conn->real_escape_string($_POST['name']);
  $complaint = $conn->real_escape_string($_POST['complaint']);
  $conn->query("UPDATE complaints SET name='$name', complaint='$complaint' WHERE id='$id'");
  header("Location: my_complaints.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Complaint</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
*{margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', Arial, sans-serif;}
body{background:linear-gradient(135deg,#eef0ff,#ffeef8); min-height:100vh; display:flex; justify-content:center; align-items:center; padding:20px;}
.box{background:white; padding:30px; border-radius:22px; width:100%; max-width:450px; box-shadow:0 10px 30px rgba(0,0,0,0.12);}
h2{color:#4a00e0; margin-bottom:5px;} p{color:#777; font-size:13px; margin-bottom:20px;}
label{font-weight:700; font-size:14px; display:block; margin:12px 0 6px;}
input, textarea{width:100%; padding:13px; border:2px solid #eee; border-radius:13px; outline:none; font-size:14px;}
textarea{height:100px; resize:none;}
button{width:100%; background:linear-gradient(90deg,#4a00e0,#8e2de2,#ff00a8); color:white; border:none; padding:14px; border-radius:13px; font-weight:800; margin-top:18px; cursor:pointer; font-size:15px;}
a{display:block; text-align:center; margin-top:12px; color:#4a00e0; text-decoration:none; font-weight:700; font-size:14px;}
</style>
</head>
<body>
<div class="box">
<h2>Edit Complaint ✏️</h2>
<p>Fix your complaint here</p>
<form method="POST">
<label>Your Name</label>
<input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
<label>Complaint</label>
<textarea name="complaint" required><?php echo htmlspecialchars($row['complaint']); ?></textarea>
<button type="submit" name="update">Update Complaint ✅</button>
</form>
<a href="my_complaints.php">← Back to My Complaints</a>
</div>
</body>
</html>