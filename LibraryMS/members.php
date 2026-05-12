<?php
$page_title = 'Members Management';
include 'header.php';

$message = '';

// Add Member
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_member'])) {
    $member_data = array(
        'name'         => $_POST['name'],
        'email'        => $_POST['email'],
        'phoneNumber'  => $_POST['phone'],  // FIX: must match Java field name 'phoneNumber'
        'membershipId' => $_POST['membership_id'],
        'isActive'     => true
    );

    $result = apiCall(API_MEMBERS, 'POST', $member_data);
    
    if (isset($result['id'])) {
        $message = '<div class="alert alert-success">Member added successfully!</div>';
    } else {
        $message = '<div class="alert alert-error">Error adding member. Make sure the backend is running.</div>';
    }
}

// Delete Member
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $result = apiCall(API_MEMBERS . '/' . $id, 'DELETE');
    $message = '<div class="alert alert-success">Member deleted successfully!</div>';
}

// Get all members
$members = apiCall(API_MEMBERS);
?>

<h2>Members Management</h2>

<?php echo $message; ?>

<h3>Add New Member</h3>
<form method="POST" style="max-width: 500px; margin-bottom: 30px;">
    <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email">
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone">
    </div>

    <div class="form-group">
        <label for="membership_id">Membership ID</label>
        <input type="text" id="membership_id" name="membership_id" required>
    </div>

    <button type="submit" name="add_member" class="btn btn-success">Add Member</button>
</form>

<h3>All Members</h3>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Membership ID</th>
            <th>Joined</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (is_array($members) && !isset($members['error'])) {
            if (count($members) > 0) {
                foreach ($members as $member) {
                    echo "<tr>";
                    echo "<td>" . $member['name'] . "</td>";
                    echo "<td>" . ($member['email'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($member['phoneNumber'] ?? 'N/A') . "</td>"; // FIX: JSON key is 'phoneNumber'
                    echo "<td>" . $member['membershipId'] . "</td>";
                    echo "<td>" . formatDate($member['createdAt'] ?? '') . "</td>"; // FIX: JSON key is 'createdAt'
                    echo "<td><span style='padding: 5px 10px; border-radius: 3px; background-color: " . ($member['isActive'] ? '#c6f6d5' : '#fed7d7') . ";'>" . ($member['isActive'] ? 'Active' : 'Inactive') . "</span></td>";
                    echo "<td>";
                    echo "<a href='edit_member.php?id=" . $member['id'] . "' class='btn btn-warning' style='margin-right: 5px;'>Edit</a>";
                    echo "<a href='members.php?delete=" . $member['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' style='text-align: center;'>No members found</td></tr>";
            }
        } else {
            echo "<tr><td colspan='7' style='text-align: center;'><div class='alert alert-error'>Unable to load members. Make sure the backend is running on http://localhost:8080</div></td></tr>";
        }
        ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
