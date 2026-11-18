<?php include "db.php"; 
if(isset($_GET['solve'])){ $id=$_GET['solve']; $conn->query("UPDATE complaints SET status='Solved' WHERE id='$id'"); header("Location: dashboard.php"); exit; }
if(isset($_GET['delete'])){ $id=$_GET['delete']; $conn->query("DELETE FROM complaints WHERE id='$id'"); header("Location: dashboard.php"); exit; }
$total = $conn->query("SELECT COUNT(*) as c FROM complaints")->fetch_assoc()['c'];
$solved = $conn->query("SELECT COUNT(*) as c FROM complaints WHERE status='Solved'")->fetch_assoc()['c'];
$pending = $total - $solved;
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'All';
$where = "WHERE 1";
if($search!=''){ $where .= " AND (name LIKE '%$search%' OR complaint LIKE '%$search%')"; }
if($filter=='Pending' || $filter=='Solved'){ $where .= " AND status='$filter'"; }
?>
<!DOCTYPE html>
<html>
<head>
<title>CampusCare - Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
*{margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', Arial, sans-serif;}
body{background:linear-gradient(135deg,#eef0ff,#ffeef8); min-height:100vh; padding:20px;}
.topbar{max-width:1000px; margin:0 auto; background:linear-gradient(90deg,#4a00e0,#8e2de2,#ff00a8); color:white; padding:22px 28px; border-radius:22px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 15px 35px rgba(142,45,226,0.4);}
.topbar h2{font-size:26px; letter-spacing:0.5px;}
.topbar p{font-size:13px; opacity:0.9; margin-top:3px;}
.topbar .logo{width:52px; height:52px; background:white; color:#4a00e0; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:24px; font-weight:900; box-shadow:0 5px 15px rgba(0,0,0,0.2);}
.top-links{max-width:1000px; margin:15px auto; display:flex; gap:10px;}
.top-links a{background:white; padding:11px 18px; border-radius:14px; text-decoration:none; color:#4a00e0; font-weight:700; font-size:14px; box-shadow:0 2px 10px rgba(0,0,0,0.08); transition:0.3s;}
.top-links a:hover{transform:translateY(-2px); box-shadow:0 8px 20px rgba(0,0,0,0.15);}
.top-links a.logout{color:#dc3545; margin-left:auto;}
.wrap{max-width:1000px; margin:0 auto;}
.stats{display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; margin-bottom:15px;}
.stat{background:white; padding:20px; border-radius:20px; text-align:center; box-shadow:0 5px 18px rgba(0,0,0,0.08); transition:0.3s; cursor:pointer;}
.stat:hover{transform:translateY(-5px) scale(1.02); box-shadow:0 12px 25px rgba(142,45,226,0.25);}
.stat b{font-size:30px; display:block; color:#4a00e0;}
.stat span{font-size:13px; color:#777;}
.stat.green b{color:#28a745;} .stat.orange b{color:#ff9800;}
.card{background:white; padding:26px; border-radius:22px; box-shadow:0 5px 20px rgba(0,0,0,0.08); margin-bottom:15px;}
.card input{width:100%; padding:14px; margin:6px 0 14px; border:2px solid #eee; border-radius:14px; outline:none; font-size:15px; background:#f9f9ff;}
.card input:focus{border-color:#8e2de2; background:white; box-shadow:0 0 0 3px rgba(142,45,226,0.1);}
.card button{background:linear-gradient(90deg,#4a00e0,#8e2de2,#ff00a8); color:white; padding:14px 28px; border:none; border-radius:14px; font-size:15px; font-weight:800; cursor:pointer; box-shadow:0 8px 20px rgba(142,45,226,0.4); transition:0.3s;}
.card button:hover{transform:scale(1.03);}
.search-box{background:white; padding:18px; border-radius:20px; box-shadow:0 5px 18px rgba(0,0,0,0.08); margin-bottom:15px; display:flex; gap:10px; flex-wrap:wrap;}
.search-box input{flex:1; min-width:200px; padding:13px 16px; border:2px solid #eee; border-radius:13px; outline:none; font-size:14px;}
.search-box select{padding:13px; border:2px solid #eee; border-radius:13px; outline:none; font-weight:700; color:#4a00e0; background:#f9f9ff;}
.search-box button{background:#4a00e0; color:white; border:none; padding:13px 20px; border-radius:13px; font-weight:800; cursor:pointer;}
.list{background:white; padding:22px; border-radius:22px; box-shadow:0 5px 20px rgba(0,0,0,0.08);}
.item{background:linear-gradient(90deg,#f8f8ff,#fff5fb); padding:16px; border-radius:16px; margin:10px 0; border-left:5px solid #8e2de2; display:flex; justify-content:space-between; align-items:center; gap:10px; transition:0.3s;}
.item:hover{transform:translateX(5px); box-shadow:0 8px 20px rgba(142,45,226,0.15);}
.item b{font-size:15px;} .item small{color:#666;}
.badge-pending{background:#fff3cd; color:#856404; padding:5px 11px; border-radius:20px; font-size:12px; font-weight:700;}
.badge-solved{background:#d4edda; color:#155724; padding:5px 11px; border-radius:20px; font-size:12px; font-weight:700;}
.solve-btn{background:#28a745; color:white; padding:8px 13px; border-radius:20px; text-decoration:none; font-size:13px; font-weight:600; white-space:nowrap;}
.del-btn{background:#ff2e63; color:white; padding:8px 13px; border-radius:20px; text-decoration:none; font-size:13px; font-weight:600; white-space:nowrap; margin-left:6px;}
.empty{text-align:center; color:#999; padding:25px;}
@media(max-width:600px){.topbar{flex-direction:column; text-align:center; gap:10px;} .item{flex-direction:column; align-items:flex-start;}}
</style>
</head>
<body>
<div class="topbar">
<div style="display:flex; gap:14px; align-items:center;">
<div class="logo">C</div>
<div><h2>CampusCare 🔥</h2><p>Welcome! Submit your college complaints here</p></div>
</div>
<div style="font-size:30px;">🎓✨</div>
</div>
<div class="top-links">
<a href="my_complaints.php">📋 View My Complaints</a>
<a href="login.php" class="logout">🚪 Logout</a>
</div>
<div class="wrap">
<div class="stats">
<a href="dashboard.php?filter=All" style="text-decoration:none;"><div class="stat"><b><?php echo $total; ?></b><span>📝 Total Complaints</span></div></a>
<a href="dashboard.php?filter=Pending" style="text-decoration:none;"><div class="stat orange"><b><?php echo $pending; ?></b><span>⏳ Pending</span></div></a>
<a href="dashboard.php?filter=Solved" style="text-decoration:none;"><div class="stat green"><b><?php echo $solved; ?></b><span>✅ Solved</span></div></a>
</div>
<div class="card">
<h3>✍️ Submit New Complaint</h3>
<form method="POST">
<input type="text" name="name" placeholder="👤 Enter your name" required>
<input type="text" name="complaint" placeholder="💬 Ex: Library fan isn't working" required>
<button type="submit" name="save">Submit Complaint ➜ 🔥</button>
</form>
<?php if(isset($_POST['save'])){ $name=$conn->real_escape_string($_POST['name']); $complaint=$conn->real_escape_string($_POST['complaint']); if($conn->query("INSERT INTO complaints (name, complaint) VALUES ('$name', '$complaint')")){ echo "<p style='color:green; margin-top:12px; font-weight:700;'>✅ Complaint Submitted Successfully! 🎉</p>"; } } ?>
</div>
<div class="search-box">
<form method="GET" style="display:flex; gap:10px; flex:1; flex-wrap:wrap;">
<input type="text" name="search" placeholder="🔍 Search by name or complaint..." value="<?php echo htmlspecialchars($search); ?>">
<select name="filter"><option value="All" <?php if($filter=='All') echo 'selected'; ?>>All ✨</option><option value="Pending" <?php if($filter=='Pending') echo 'selected'; ?>>⏳ Pending</option><option value="Solved" <?php if($filter=='Solved') echo 'selected'; ?>>✅ Solved</option></select>
<button type="submit">Search 🔍</button>
</form>
</div>
<div class="list">
<h3>📝 All Complaints <?php if($search!='') echo " - Result for '<span style='color:#8e2de2;'>$search</span>'"; ?></h3>
<?php
$result = $conn->query("SELECT * FROM complaints $where ORDER BY id DESC");
if($result->num_rows==0){ echo "<p class='empty'>😢 No complaints found! <br>Try another search.</p>"; }
while($row=$result->fetch_assoc()){ $status=isset($row['status'])?$row['status']:'Pending'; $badge=($status=='Solved')?'badge-solved':'badge-pending';
echo "<div class='item'><div><b>".$row['name']."</b><br><small>".$row['complaint']."</small><br><span style='display:inline-block; margin-top:6px;' class='$badge'>".$status."</span></div><div style='display:flex;'>";
if($status!='Solved'){ echo "<a class='solve-btn' href='?solve=".$row['id']."&filter=$filter&search=$search'>✅ Solved</a>"; } else { echo "<span style='font-size:22px;'>🎉</span>"; }
echo "<a class='del-btn' href='?delete=".$row['id']."' onclick=\"return confirm('Delete this complaint?')\">🗑️ Delete</a></div></div>"; }
?>
</div>
</div>
</body>
</html>