<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background: #f5f5f5;
            padding: 2rem;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #003366;
        }
        
        .header h1 {
            font-size: 28px;
            color: #003366;
        }
        
        .back-button {
            padding: 0.75rem 1.5rem;
            background: #6b7280;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .back-button:hover {
            background: #4b5563;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        table thead {
            background: #003366;
            color: white;
        }
        
        table th {
            padding: 1rem;
            text-align: left;
            font-weight: 700;
            border-bottom: 2px solid #003366;
        }
        
        table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e0e0e0;
        }
        
        table tbody tr:hover {
            background: #f9f9f9;
        }
        
        table tbody tr:nth-child(even) {
            background: #fafafa;
        }
        
        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        
        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }
        
        .actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-view {
            background: #003366;
            color: white;
        }
        
        .btn-view:hover {
            background: #002244;
        }
        
        .btn-edit {
            background: #17a2b8;
            color: white;
        }
        
        .btn-edit:hover {
            background: #138496;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        
        .btn-delete:hover {
            background: #c82333;
        }
        
        .no-data {
            text-align: center;
            padding: 2rem;
            color: #999;
        }
        
        .search-bar {
            margin-bottom: 1.5rem;
            display: flex;
            gap: 1rem;
        }
        
        .search-bar input {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .search-bar button {
            padding: 0.75rem 1.5rem;
            background: #003366;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
        }
        
        .search-bar button:hover {
            background: #002244;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Users Management</h1>
            <a href="{{ route('admin.dashboard') }}" class="back-button">← Back</a>
        </div>
        
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search by name or email..." onkeyup="filterTable()">
            <button onclick="location.reload()">Refresh</button>
        </div>
        
        @if($users->count() > 0)
            <table id="usersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Address</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="status-badge {{ $user->role === 'admin' ? 'status-active' : 'status-inactive' }}">
                                    {{ ucfirst($user->role ?? 'user') }}
                                </span>
                            </td>
                            <td>{{ $user->address ?? 'N/A' }}</td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="actions">
                                    <a href="#" class="btn btn-view" title="View">View</a>
                                    <a href="#" class="btn btn-edit" title="Edit">Edit</a>
                                    <a href="#" class="btn btn-delete" title="Delete" onclick="return confirm('Are you sure?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <p>No users found.</p>
            </div>
        @endif
    </div>
    
    <script>
        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const table = document.getElementById('usersTable');
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let match = false;
                
                for (let j = 0; j < cells.length - 1; j++) {
                    if (cells[j].textContent.toUpperCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
                
                rows[i].style.display = match ? '' : 'none';
            }
        }
    </script>
</body>
</html>
