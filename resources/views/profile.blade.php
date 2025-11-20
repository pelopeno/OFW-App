
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; }
        .profile-container {
            max-width: 400px;
            margin: 60px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 32px 24px;
            text-align: center;
        }
        .avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #e9ecef;
            display: inline-block;
            margin-bottom: 18px;
            font-size: 40px;
            color: #6c757d;
            line-height: 90px;
        }
        h2 { margin: 10px 0 6px 0; }
        .info {
            margin: 18px 0;
            text-align: left;
        }
        .info label {
            font-weight: bold;
            display: block;
            margin-bottom: 2px;
        }
        .info span {
            display: block;
            margin-bottom: 12px;
            color: #333;
        }
        .edit-btn {
            padding: 10px 24px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 15px;
            cursor: pointer;
        }
        .edit-btn:hover { background: #0056b3; }
        .back-btn {
            display: inline-block;
            margin-bottom: 18px;
            padding: 8px 18px;
            background: #6c757d;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
        }
        .back-btn:hover { background: #495057; }
    </style>
</head>
<body>
    <div class="profile-container">
        <a href="{{ route('dashboard') }}" class="back-btn">← Back to Dashboard</a>
        <br>
        <div class="avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
        </div>
        <h2>{{ Auth::user()->name ?? 'User Name' }}</h2>
        <div class="info">
            <label>Email</label>
            <label>Member Since</label>
    
        </div>
        <button class="edit-btn">Edit Profile</button>
    </div>
</body>
</html>